<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Currency;
use App\Models\PaymentPlatform;
use App\Models\Plan;
use App\Resolvers\PaymentPlatformResolver;
use App\Services\PaypalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Stripe\Stripe;

class StripePaymentController extends Controller
{
    protected $paymantPlatformResolver;

    public function __construct(PaymentPlatformResolver $paymantPlatformResolver)
    {
        $this->paymantPlatformResolver = $paymantPlatformResolver;
    }

    public function index(Request $request)
    {
        $cities = City::all();
        $city = null;
        $currencies = Currency::all();
        $platforms = PaymentPlatform::all();
        $plans = Plan::all();
        if ($request->has('plan')) {
            if (Plan::where('slug', $request->plan)->exists()) {
                $selected_plan = Plan::where('slug', $request->plan)->first();
            } else {
                App::abort(404, 'Plan not found');
            }
        }else{
           $selected_plan = null;
        }
        $intent = auth()->user()->createSetupIntent();
        return view('checkout', compact('cities', 'city', 'currencies', 'platforms', 'selected_plan', 'plans' , 'intent'));
    }

    public function checkout(Request $request)
    {
        $rules = [
            'value' =>['required', 'numeric', 'min:3'],
            'currency' => ['required', 'exists:currencies,iso'],
            'platform' => ['required', 'exists:payment_platforms,id'],
        ];

        $user = $request->user();
        $user->update([
            'line1' => $request->line1,
            'line2' => $request->line2,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
        ]);

        $request->validate($rules);

        $paymentPlatform = $this->paymantPlatformResolver->resolveService($request->platform);

        session()->put('paymentPlatformId', $request->platform);

        return $paymentPlatform->handlePayment($request);
    }

    public function approval()
    {
        if (session()->has('paymentPlatformId')) {
            $paymentPlatformId = session()->get('paymentPlatformId');

            $paymentPlatform = $this->paymantPlatformResolver->resolveService($paymentPlatformId);

            return $paymentPlatform->handleApproval();
        }
    }

    public function cancelled()
    {
        return redirect()->route('payment.form')->withErrors('You cancelled the payment');
    }
}

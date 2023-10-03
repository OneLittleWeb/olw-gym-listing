<?php

namespace App\Services;

use App\Models\Plan;
use App\Traits\ConsumeExternalServices;
use Illuminate\Http\Request;

class StripeService
{
    use ConsumeExternalServices;

    protected $base_uri;

    protected $key;

    protected $secret;

    public function __construct()
    {
        $this->base_uri = config('services.stripe.base_uri');
        $this->key = config('services.stripe.pub_key');
        $this->secret = config('services.stripe.secret_key');
    }

    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        $headers['Authorization'] = $this->resolveAccessToken();
    }

    public function decodeResponse($response)
    {
        return json_decode($response);
    }

    public function resolveAccessToken(): string
    {
        return "Bearer {$this->secret}";
    }

    public function handlePayment(Request $request)
    {
        $plan = Plan::where('stripe_name', $request->plan)->first();
        $paymentMethod = $request->payment_method;
        $user = $request->user();
        $user->newSubscription($request->plan, $plan->stripe_name)->create($paymentMethod);

        return redirect()->route('home');
    }

    public function handleApproval()
    {

    }

}

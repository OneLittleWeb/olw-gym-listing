<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\StripeClient;

class StripeManageController extends Controller
{
    public function index()
    {
        $stripe = new StripeClient(config('services.stripe.secret_key'));

        dd($stripe->products->all(['limit' => 3]));
        return view('admin.stripe.index');
    }

}

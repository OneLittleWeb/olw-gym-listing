<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Plan;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index()
    {
        $cities = City::all();
        $city = null;
        $plans = Plan::all();
        return view('pricing', compact('cities', 'city', 'plans'));
    }
}

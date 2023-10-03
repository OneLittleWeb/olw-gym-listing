<?php

namespace App\Http\Controllers;

use App\Models\City;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::orderByDesc('id')->get();
        $city = null;
        $category = null;
        return view('city.index', compact('cities', 'city','category'));
    }
}

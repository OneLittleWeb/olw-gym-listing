<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Organization;
use App\Models\Review;
use App\Models\State;

class HomeController extends Controller
{
    public function adminDashboard()
    {
        $organization_count = Organization::count();
        $reviews_count = Review::count();
        $state_count = State::count();
        $city_count = City::count();

        return view('admin.dashboard.dashboard', compact('organization_count', 'reviews_count', 'state_count', 'city_count'));
    }
}

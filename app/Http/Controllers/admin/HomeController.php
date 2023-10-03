<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Organization;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function adminDashboard()
    {
        $organization_count = Organization::count();
        $reviews_count = Review::count();
        $category_count = Category::count();
        $city_count = City::count();

        return view('admin.dashboard.dashboard', compact('organization_count', 'reviews_count', 'category_count', 'city_count'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Organization;
use Butschster\Head\Facades\Meta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index($slug)
    {
        $city = City::where('slug', $slug)->exists();
        $category = Category::where('slug', $slug)->exists();

        if ($city) {

            $cities = City::all();
            $city = City::where('slug', $slug)->first();
            $organizations = Organization::where('city_id', $city->id)->get()->groupBy('organization_category');

            if ($city->id == 1 || $city->id == 2 || $city->id == 3 || $city->id == 4) {
                $categories = Category::all();
            } else {
                $categories = Category::where('id', '!=', 23)->get();
            }

            return view('category.index', compact('cities', 'city', 'categories', 'organizations'));
        } elseif ($category) {

            $category = Category::where('slug', $slug)->first();

            if ($category->id == 23) {
                $cities = City::where('is_major', 1)->get();
            } else {
                $cities = City::all();
            }

            return view('city.category-city', compact('category', 'cities'));
        }
        abort(404);
    }

    public function categoryBusiness($slug)
    {
        $category = Category::where('slug', $slug)->first();
        if ($category) {
            $categories = Category::all();
            $cities = City::all();
            $city = null;
            $organizations = Organization::where('category_id', $category->id)
                ->orderByRaw('CAST(reviews_total_count AS SIGNED) DESC')
                ->orderByRaw('CAST(rate_stars AS SIGNED) DESC')
                ->paginate(10)
                ->onEachSide(0);

            return view('organization.index', compact('organizations', 'category', 'categories', 'cities', 'city'));
        } else {
            return $this->othersCategoriesFromBusiness($slug);
        }
    }

    public function othersCategoriesFromBusiness($slug)
    {
        $organizations = Organization::where('organization_category', $slug)
            ->orderByRaw('CAST(reviews_total_count AS SIGNED) DESC')
            ->orderByRaw('CAST(rate_stars AS SIGNED) DESC')
            ->paginate(20)
            ->onEachSide(0);

        if ($organizations) {
            $cities = City::all();
            $categories = Category::all();

            $business_category = Organization::where('organization_category', $slug)->first();
            $category = Category::find($business_category->category_id);

            $business_city = Organization::where('organization_category', $slug)->first();
            $city = City::find($business_city->city_id);

            $category->meta_title = Str::title($business_category->organization_category) . ' in ' . Str::title($city->name) . ', NE | nebraskalisting.com';

            return view('category.business', compact('organizations', 'city', 'cities', 'category', 'categories', 'business_category'));
        }

        abort(404);
    }

    public function allCategories()
    {
        $categories = Category::all();
        $cities = City::all();
        $city = null;
        $category = null;
        return view('category.all-categories', compact('categories', 'category', 'cities', 'city'));
    }
}

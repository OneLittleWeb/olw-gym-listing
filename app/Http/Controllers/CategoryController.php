<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Organization;
use App\Models\State;
use Butschster\Head\Facades\Meta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function categoryWiseBusiness($state_slug, $category_name)
    {
        $s_state = State::where('slug', $state_slug)->first();

        if ($s_state) {
            $organizations = Organization::where('organization_category', $category_name)
                ->where('state_id', $s_state->id)
                ->orderByRaw('CAST(reviews_total_count AS SIGNED) DESC')
                ->orderByRaw('CAST(rate_stars AS SIGNED) DESC')
                ->paginate(10);

            $organization_categories = Organization::select('organization_category', 'state_id', DB::raw('COUNT(*) as category_count'))
                ->where('state_id', $s_state->id)
                ->with('state:id,slug')
                ->groupBy('organization_category', 'state_id')
                ->get();

            $states = State::all();
            $cities = City::where('state_id', $s_state->id)->get();

            $organization_count = Organization::where('state_id', $s_state->id)->count();

            if ($organizations->onFirstPage()) {
                $s_state->meta_title = 'Top 10 Best Gyms Near ' . Str::title($s_state->name);
            } else {
                $s_state->meta_title = 'Gyms Near ' . Str::title($s_state->name);
            }

            Meta::setPaginationLinks($organizations);

            // Render the view as a string.
            return view('category.category-wise-organization', compact('organizations', 'organization_categories', 'category_name', 'organization_count', 's_state', 'states', 'cities'))->render();
        }

        abort(404);
    }

//    public function categoryWiseBusiness()
//    {
//        $currentPage = request()->get('page', 1);
//
//        // Define a unique cache key based on the slug and current page.
//        $cacheKey = 'category_wise_business_data_' . $currentPage;
//
//        // Attempt to retrieve the view as a string from the cache, or generate and cache it indefinitely.
//        $cachedView = Cache::rememberForever($cacheKey, function () {
//            return $this->generateCategoryWiseBusinessView();
//        });
//
//        return response($cachedView);
//    }
}

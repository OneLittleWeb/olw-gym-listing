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

    public function categoryWiseBusiness($state_slug, $organization_category_slug)
    {
        $s_state = State::where('slug', $state_slug)->first();

        if ($s_state) {
            $organizations = Organization::where('organization_category_slug', $organization_category_slug)
                ->where('state_id', $s_state->id)
                ->where('permanently_closed', 0)
                ->orderByRaw('CAST(reviews_total_count AS SIGNED) DESC')
                ->orderByRaw('CAST(rate_stars AS SIGNED) DESC')
                ->paginate(10)
                ->withQueryString();

            $organization_categories = Organization::select('organization_category', 'organization_category_slug', 'state_id', DB::raw('COUNT(*) as category_count'))
                ->where('state_id', $s_state->id)
                ->groupBy('organization_category', 'state_id', 'organization_category_slug')
                ->orderBy('category_count', 'desc')
                ->get();

            $states = State::all();
            $cities = City::where('state_id', $s_state->id)->get();

            $organization_category_count = Organization::where('state_id', $s_state->id)
                ->where('organization_category_slug', $organization_category_slug)->count();

            //For meta title
            $meta_title_prefix = ($organizations->onFirstPage() && $organization_category_count >= 10) ? 'Top 10 Best' : 'Best';
            $organization_category = Str::plural($organizations[0]->organization_category, $organization_category_count);
            $meta_title_suffix = 'Near ' . Str::title($s_state->name);

            $s_state->meta_title = $meta_title_prefix . ' ' . $organization_category . ' ' . $meta_title_suffix;

            Meta::setPaginationLinks($organizations);

            // Render the view as a string.
            return view('category.category-wise-organization', compact('organizations', 'organization_categories','organization_category_slug', 'organization_category_count', 's_state', 'states', 'cities'))->render();
        }

        abort(404);
    }

    public function organizationCategorySlugFromOrganizationCategory()
    {
        return redirect()->back();

        $chunkSize = 1000;

        Organization::query()
            ->chunk($chunkSize, function ($organization_categories) {
                foreach ($organization_categories as $category) {
                    $category->organization_category_slug = Str::slug($category->organization_category);
                    $category->save();
                }
            });

        alert()->success('Success', 'Organization category slug added successfully.');

        return redirect()->back();
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

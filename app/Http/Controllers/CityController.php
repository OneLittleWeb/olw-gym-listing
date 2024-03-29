<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Organization;
use App\Models\State;
use Butschster\Head\Facades\Meta;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CityController extends Controller
{
    public function cityWiseOrganizations($state_slug, $city_slug)
    {
        $current_page = request()->get('page', 1);

        // Define a unique cache key based on the state and city slugs.
        $cacheKey = 'city_wise_organization_data_' . $state_slug . '_' . $city_slug . '_' . $current_page;

        // Attempt to retrieve the view as a string from the cache.
        $cachedView = Cache::get($cacheKey);

        if ($cachedView === null) {
            // If the view is not found in the cache, retrieve and store it.
            $cachedView = $this->generateCityWiseOrganizationsView($state_slug, $city_slug, 'gym');
            Cache::forever($cacheKey, $cachedView);
        }

        return response($cachedView);
    }

    public function generateCityWiseOrganizationsView($state_slug, $city_slug, $organization_category_slug)
    {
        $city_check = City::where('slug', $city_slug)->exists();

        if ($city_check) {
            $city = City::with('State')->where('slug', $city_slug)->first();

            $states = State::with('organizations')->get();

            $cities = City::with('state')->where('state_id', $city->State->id)->get();

            $organizations = Organization::with('city:id,name,slug', 'state:name', 'category')
                ->where('organization_category_slug', $organization_category_slug)
                ->where('city_id', $city->id)
                ->where('state_id', $city->State->id)
                ->where('permanently_closed', 0)
                ->orderByRaw('CAST(rate_stars AS SIGNED) DESC')
                ->orderByRaw('CAST(reviews_total_count AS SIGNED) DESC')
                ->paginate(10)
                ->withQueryString();

            if ($organizations->isNotEmpty()) {
                // Check if it's the first page and has the "page" query parameter
                if ($organizations->currentPage() == 1 && request()->has('page')) {
                    // Redirect to the same URL without the "page" query parameter
                    return redirect()->route('city.wise.organizations', [
                        'state_slug' => $state_slug, 'city_slug' => $city_slug,
                        'organization_category_slug' => $organization_category_slug,
                    ]);
                }

                $organization_categories = Organization::with('state', 'city')->select('organization_category', 'organization_category_slug', 'state_id', 'city_id', DB::raw('COUNT(*) as category_count'))
                    ->where('state_id', $city->State->id)
                    ->where('city_id', $city->id)
                    ->groupBy('organization_category', 'state_id', 'city_id', 'organization_category_slug')
                    ->orderBy('category_count', 'desc')
                    ->get();

                $organization_badge = '';

                if ($organizations->isNotEmpty()) {
                    $files = File::files(public_path('images/badges'));
                    $images = [];

                    foreach ($files as $file) {
                        $images[] = $file->getRelativePathname();

                        foreach ($images as $image) {
                            if ($image == $organizations[0]->category->name . ' - ' . $organizations[0]->city->name . '.png') {
                                $organization_badge = $image;
                            }
                        }
                    }
                }

                $organization_count = Organization::where('city_id', $city->id)
                    ->where('state_id', $city->State->id)->count();
                $organization_category_count = Organization::where('state_id', $city->State->id)->where('city_id', $city->id)
                    ->where('organization_category_slug', $organization_category_slug)->count();

                //For meta title, description and keyword
                if ($organizations->isNotEmpty()) {
                    $meta_title_prefix = ($organizations->onFirstPage() && $organization_category_count >= 10) ? 'Top 10 Best' : 'Best';
                    $organization_category = Str::plural($organizations[0]->organization_category, $organization_category_count);
                    $meta_title_suffix = 'Near ' . Str::title($city->State->name . ' ' . $city->name);

                    $city->meta_title = $meta_title_prefix . ' ' . $organization_category . ' ' . $meta_title_suffix;

                    $category_name = Str::lower(Str::plural($organizations[0]->organization_category, $organization_category_count));
                    $city->meta_description = "Explore the best " . Str::plural($organizations[0]->organization_category, $organization_category_count) . " in the $city->State->name, " . $city->name . ". Get photos, business hours, phone numbers, ratings, reviews and service details.";
                    $city->meta_keywords = 'best ' . $category_name . ' in ' . $city->name . ', ' . $category_name . ' in ' . $city->name . ', ' . $category_name . ' near me, ' . $category_name . ' near ' . $city->name;
                }

                Meta::setPaginationLinks($organizations);

                // Render the view as a string.
                return view('city.city-wise-organizations', compact('organizations', 'organization_categories', 'organization_category_slug', 'organization_category_count', 'cities', 'city', 'states', 'organization_badge', 'organization_count'));
            } else {
                abort(404);
            }
        }

        abort(404);
    }
}

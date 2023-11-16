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
    public function index()
    {
        $cities = City::orderBy('name')->get();
        $city = null;
        $category = null;
        return view('city.index', compact('cities', 'city', 'category'));
    }

    public function cityWiseOrganizations($state_slug, $city_slug)
    {
        $current_page = request()->get('page', 1);

        // Define a unique cache key based on the state and city slugs.
        $cacheKey = 'city_wise_organization_data_' . $state_slug . '_' . $city_slug . '_' . $current_page;

        // Attempt to retrieve the view as a string from the cache.
        $cachedView = Cache::get($cacheKey);

        if ($cachedView === null) {
            // If the view is not found in the cache, retrieve and store it.
            $cachedView = $this->generateCityWiseOrganizationsView($state_slug, $city_slug);
            Cache::forever($cacheKey, $cachedView);
        }

        return response($cachedView);
    }

    public function generateCityWiseOrganizationsView($state_slug, $city_slug, $organization_category_slug)
    {
        $state_check = State::where('slug', $state_slug)->exists();
        $city_check = City::where('slug', $city_slug)->exists();

        if ($city_check && $state_check) {
            $s_state = State::where('slug', $state_slug)->first();
            $city = City::where('slug', $city_slug)->first();

            $states = State::all();
            $cities = City::where('state_id', $s_state->id)->get();

            $organizations = Organization::where('organization_category_slug', $organization_category_slug)
                ->where('city_id', $city->id)
                ->where('state_id', $s_state->id)
                ->where('permanently_closed', 0)
                ->orderByRaw('CAST(rate_stars AS SIGNED) DESC')
                ->orderByRaw('CAST(reviews_total_count AS SIGNED) DESC')
                ->paginate(10);

            $organization_categories = Organization::select('organization_category', 'organization_category_slug', 'state_id', 'city_id', DB::raw('COUNT(*) as category_count'))
                ->where('state_id', $s_state->id)
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
                ->where('state_id', $s_state->id)->count();
            $organization_category_count = Organization::where('state_id', $s_state->id)->where('city_id', $city->id)
                ->where('organization_category_slug', $organization_category_slug)->count();

            //For meta title
            $metaTitlePrefix = ($organizations->onFirstPage() && $organization_category_count >= 10) ? 'Top 10 Best' : 'Best';
            $metaTitleSuffix = 'Near ' . Str::title($s_state->name . ' ' . $city->name);

            $s_state->meta_title = $metaTitlePrefix . ' ' . $organizations[0]->organization_category . ' ' . $metaTitleSuffix;

            Meta::setPaginationLinks($organizations);

            // Render the view as a string.
            return view('city.city-wise-organizations', compact('organizations', 'organization_categories', 'organization_category_slug', 'organization_category_count', 'cities', 'city', 's_state', 'states', 'organization_badge', 'organization_count'))->render();
        }

        abort(404);
    }

    public function importCityData()
    {
        try {
            $baseDirectory = 'H:\gym';
            if (!File::exists($baseDirectory)) {
                throw new \Exception('Base directory does not exist.');
            }

            $stateDirectories = File::directories($baseDirectory);

            foreach ($stateDirectories as $stateDirectory) {
                $stateName = trim(basename($stateDirectory), " ");
                $state = State::where('name', Str::lower($stateName))->first();

                if (!$state) {
                    throw new \Exception('State not found: ' . $stateName);
                }

                $stateId = $state->id;

                $cityDirectories = File::directories($stateDirectory);

                foreach ($cityDirectories as $cityDirectory) {
                    $cityName = trim(basename($cityDirectory), " ");
                    $cityNameLower = Str::lower($cityName);

                    // Check if the city already exists in the database
                    $existingCity = City::where('name', $cityNameLower)->where('state_id', $stateId)->first();

                    if (!$existingCity) {
                        $city = new City();
                        $city->name = $cityNameLower;
                        $city->slug = Str::slug($cityNameLower);
                        $city->background_image = Str::slug($cityNameLower) . '.png';
                        $city->state_id = $stateId;
                        $city->save();
                    }
                }
            }

            return redirect()->back()->with('success', 'Cities imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


//    public function importCityData()
//    {
//        try {
//
//            $baseDirectory = 'H:\gym';
//            if (!File::exists($baseDirectory)) {
//                throw new \Exception('Base directory does not exist.');
//            }
//
//            $stateDirectories = File::directories($baseDirectory);
//
//            foreach ($stateDirectories as $stateDirectory) {
//                $stateName = trim(basename($stateDirectory), " ");
//                $state = State::where('name', Str::lower($stateName))->first();
//
//                if (!$state) {
//                    throw new \Exception('State not found: ' . $stateName);
//                }
//
//                $stateId = $state->id;
//
//                $cityDirectories = File::directories($stateDirectory);
//
//                foreach ($cityDirectories as $cityDirectory) {
//                    $cityName = trim(basename($cityDirectory), " ");
//                    $city = new City();
//                    $city->name = Str::lower($cityName);
//                    $city->slug = Str::slug($cityName);
//                    $city->background_image = Str::slug($cityName) . '.png';
//                    $city->state_id = $stateId;
//                    $city->save();
//                }
//            }
//
//            // Success message
//            return redirect()->back()->with('success', 'Cities imported successfully.');
//        } catch (\Exception $e) {
//            // Handle exceptions
//            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
//        }
//    }

}

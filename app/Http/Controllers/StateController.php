<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Organization;
use App\Models\State;
use Butschster\Head\Facades\Meta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class StateController extends Controller
{
    public function stateWiseOrganizations($slug)
    {
        $currentPage = request()->get('page', 1);

        // Define a unique cache key based on the slug and current page.
        $cacheKey = 'state_wise_organization_data_' . $slug . '_' . $currentPage;

        // Attempt to retrieve the view as a string from the cache, or generate and cache it indefinitely.
        $cachedView = Cache::rememberForever($cacheKey, function () use ($slug) {
            return $this->generateStateWiseOrganizationView($slug);
        });

        return response($cachedView);
    }

    public function generateStateWiseOrganizationView($slug)
    {
        $s_state = State::where('slug', $slug)->first();

        if ($s_state) {
            $organizations = Organization::where('state_id', $s_state->id)
                ->orderByRaw('CAST(reviews_total_count AS SIGNED) DESC')
                ->orderByRaw('CAST(rate_stars AS SIGNED) DESC')
                ->paginate(10);

            $organization_categories = Organization::select('organization_category', 'organization_category_slug', 'state_id', DB::raw('COUNT(*) as category_count'))
                ->where('state_id', $s_state->id)
                ->groupBy('organization_category', 'state_id', 'organization_category_slug')
                ->orderBy('category_count', 'desc')
                ->get();

            $states = State::all();
            $cities = City::where('state_id', $s_state->id)->get();
            $city = null;

            $organization_count = Organization::where('state_id', $s_state->id)->count();

            if ($organizations->onFirstPage()) {
                $s_state->meta_title = 'Top 10 Best Gyms Near ' . Str::title($s_state->name);
            } else {
                $s_state->meta_title = 'Gyms Near ' . Str::title($s_state->name);
            }

            Meta::setPaginationLinks($organizations);

            // Render the view as a string.
            return view('state.state-wise-organizations', compact('organizations', 'organization_categories', 'organization_count', 's_state', 'states', 'cities', 'city'))->render();
        }

        abort(404);
    }

    public function searchStates(Request $request)
    {
        $query = $request->input('query');
        $states = State::where('name', 'LIKE', '%' . $query . '%')
            ->withCount('organizations')
            ->take(6)
            ->get();

        return response()->json(['states' => $states]);
    }
}

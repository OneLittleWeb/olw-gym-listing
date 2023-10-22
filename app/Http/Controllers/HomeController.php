<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Organization;
use App\Models\State;
use Corcel\Model\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $businessIndex = Cache::remember('business_index', now()->addHours(10), function () {
            $major_states = State::where('is_major', 1)->get();
            $states = State::take(8)->get();
            $cities = City::all();
            $total_pages = Organization::count();
            $five_star_ratings = Organization::where('rate_stars', 5)->count();
            $company_joined = Organization::select('organization_name')->distinct()->get();

            try {
                $posts = Post::taxonomy('category', 'uncategorized')->newest()->take(6)->get();
            } catch (\Exception $e) {
                $posts = null;
            }

            return [
                'major_states' => $major_states,
                'states' => $states,
                'cities' => $cities,
                'total_pages' => $total_pages,
                'five_star_ratings' => $five_star_ratings,
                'company_joined' => $company_joined,
                'posts' => $posts,
            ];
        });

        // Use Cache::forever to cache the data forever
        Cache::forever('business_index', $businessIndex);

        // Extract the data if needed.
        extract($businessIndex);

        return view('home', compact('major_states', 'states', 'cities', 'total_pages', 'five_star_ratings', 'company_joined', 'posts'));
    }

    public function autocomplete(Request $request)
    {
        $query = $request->search;

        $organizations = DB::table('organizations')
            ->select(DB::raw('"organizations" as source'), 'id', 'organization_name')
            ->where('organization_name', 'like', '%' . $query . '%');

        $states = DB::table('states')
            ->select(DB::raw('"states" as source'), 'id', 'name')
            ->where('name', 'like', '%' . $query . '%');

        $cities = DB::table('cities')
            ->select(DB::raw('"cities" as source'), 'id', 'name')
            ->where('name', 'like', '%' . $query . '%');

        $results = $states->unionAll($organizations)->unionAll($cities)->get();

        return response()->json($results);
    }

    public function search(Request $request)
    {
        $source = $request->source_value;
        $search_source_id = $request->source_id;

        if ($request->looking_for) {
            if ($source == 'organizations') {

                $organization = Organization::find($search_source_id);
                $sourceController = new OrganizationController();

                return $sourceController->cityWiseOrganization($organization->city->slug, $organization->slug);
            } elseif ($source == 'states') {

                $state = State::find($search_source_id);
                $sourceController = new StateController();

                return $sourceController->stateWiseOrganizations($state->slug);
            } elseif ($source == 'cities') {

                $city = City::find($search_source_id);
                $sourceController = new OrganizationController();

                return $sourceController->cityWiseOrganizations($city->slug, $city->state->slug);
            }
        }

        abort(404);
    }
}

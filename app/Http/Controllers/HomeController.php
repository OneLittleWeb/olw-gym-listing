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
        $all_states = Cache::rememberForever('all_states_home_page', function () {
            return State::select('id', 'name', 'slug', 'background_image')->get();
        });
        $total_pages = Organization::count();
        $five_star_ratings = Organization::where('rate_stars', 5)->count();
        $company_joined = Organization::distinct('organization_name')->count('organization_name');
        $most_viewed_states = Organization::with('state')->select('state_id', DB::raw('SUM(views) as total_views'), DB::raw('COUNT(*) as total_business'))
            ->groupBy('state_id')
            ->orderByDesc('total_views')
            ->take(4)
            ->get();

        $view = view('home')
            ->with('all_states', $all_states)
            ->with('total_pages', $total_pages)
            ->with('five_star_ratings', $five_star_ratings)
            ->with('company_joined', $company_joined)
            ->with('most_viewed_states', $most_viewed_states);

        if (config('app.env') == 'production') {
            try {
                $posts = Post::taxonomy('category', 'guides')->newest()->published()->take(6)->get();
                $view = $view->with('posts', $posts);
            } catch (\Exception $e) {
                $posts = null;
            }
        }

        return $view;
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
        $looking_for = $request->looking_for;

        if ($looking_for && $source) {
            if ($source == 'organizations') {

                $organization = Organization::find($search_source_id);
                $sourceController = new OrganizationController();

                return $sourceController->generateCityWiseOrganizationView($organization->city->slug, $organization->slug);
            } elseif ($source == 'states') {

                $state = State::find($search_source_id);
                $sourceController = new CategoryController();

                return $sourceController->categoryWiseBusiness($state->slug, 'gym');
            } elseif ($source == 'cities') {

                $city = City::find($search_source_id);
                $sourceController = new CityController();

                return $sourceController->generateCityWiseOrganizationsView($city->state->slug, $city->slug, 'gym');
            }
        } elseif ($looking_for) {

            $organizations = Organization::where(function ($query) use ($looking_for) {
                $query->where('organization_name', 'like', '%' . $looking_for . '%')
                    ->orWhere('organization_address', 'like', '%' . $looking_for . '%')
                    ->orWhere('organization_phone_number', 'like', '%' . $looking_for . '%')
                    ->orWhere('organization_email', 'like', '%' . $looking_for . '%')
                    ->orWhere('organization_website', 'like', '%' . $looking_for . '%')
                    ->orWhere('organization_short_description', 'like', '%' . $looking_for . '%')
                    ->orWhere('organization_category', 'like', '%' . $looking_for . '%');
            })->paginate(15)->withQueryString();

            return view('organization.search-result', compact('organizations', 'looking_for'));
        }

        abort(404);
    }

    public function removeUnknownCategory()
    {
        $unknown_categories = ['lounge'];

        foreach ($unknown_categories as $unknown_category) {
            // Fetch organizations and their reviews with eager loading
            $organizations = Organization::with('reviews')
                ->where('organization_category_slug', $unknown_category)
                ->get();

            dd($organizations);

            foreach ($organizations as $organization) {

                dd($organization);
                // Ensure organization exists before deletion
                if ($organization) {
                    // Delete all associated reviews
                    $organization->reviews()->delete();

                    // Delete organization
                    $organization->delete();
                }
            }
        }

        return redirect()->back()->with('success', 'Unknown categories deleted successfully.');
    }
}

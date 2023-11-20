<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Organization;
use App\Models\State;
use Corcel\Model\Post;
use Corcel\Model\Taxonomy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $major_states = State::where('is_major', 1)->get();
        $all_states = State::all();
        $states = State::take(8)->get();
        $cities = City::all();
        $total_pages = Organization::count();
        $five_star_ratings = Organization::where('rate_stars', 5)->count();
        $company_joined = Organization::select('organization_name')->distinct()->count();

        $most_viewed_states = Organization::select('state_id', DB::raw('SUM(views) as total_views'), DB::raw('COUNT(*) as total_business'))
            ->groupBy('state_id')
            ->orderByDesc('total_views')
            ->take(4)
            ->get();
        $post = Post::taxonomy('category', 'things-to-do')->newest()->published()->take(6)->get();

        dd($post);

        try {
            $posts = Post::taxonomy('category', 'uncategorized')->newest()->published()->take(6)->get();
        } catch (\Exception $e) {
            $posts = null;
        }

        return view('home', compact('major_states', 'all_states', 'states', 'most_viewed_states', 'cities', 'total_pages', 'five_star_ratings', 'company_joined', 'posts'));
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

                return $sourceController->cityWiseOrganization($organization->city->slug, $organization->slug);
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
}

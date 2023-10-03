<?php

namespace App\Http\Controllers;

use App\Http\Controllers\OrganizationController;
use App\Models\Category;
use App\Models\City;
use App\Models\Organization;
use Corcel\Model\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::orderByDesc('id')->get();
        $major_cities = City::where('is_major', 1)->get();
        $popular_cities = City::take(8)->orderByDesc('population')->get();
        $cities = City::all();

        $total_pages = Organization::count();
        $five_star_ratings = Organization::where('rate_stars', 5)->count();
        $company_joined = Organization::select('organization_name')->distinct()->get();
        try {
            $posts = Post::taxonomy('category', 'uncategorized')->newest()->take(6)->get();
        } catch (\Exception $e) {
            $posts = null;
        }
        return view('home', compact('categories', 'major_cities', 'popular_cities', 'cities', 'total_pages', 'five_star_ratings', 'company_joined', 'posts'));
    }

    public function autocomplete(Request $request)
    {
        $query = $request->search;

        $organizations = DB::table('organizations')
            ->select(DB::raw('"organizations" as source'), 'id', 'organization_name')
            ->where('organization_name', 'like', '%' . $query . '%');

        $categories = DB::table('categories')
            ->select(DB::raw('"categories" as source'), 'id', 'name')
            ->where('name', 'like', '%' . $query . '%');

        $results = $categories->union($organizations)->get();

        return response()->json($results);
    }

    public function search(Request $request)
    {
        $source = $request->source_value;
        $search_city = $request->search_city;
        $search_source_id = $request->source_id;

        if ($request->looking_for) {

            $city = City::find($search_city);

            if ($source == 'organizations') {

                $organization = Organization::find($search_source_id);

                $sourceController = new OrganizationController();
                return $sourceController->cityWiseOrganization($organization->city->slug, $organization->slug);

            } elseif ($source == 'categories') {
                $category = Category::find($search_source_id);

                $category->meta_title = Str::title($category->name) . ' in ' . Str::title($city->name) . ', NE | nebraskalisting.com';

                $cities = City::all();
                $categories = Category::all();
                $organizations = Organization::where('category_id', $search_source_id)
                    ->orWhere('city_id', $search_city)
                    ->orderByRaw('CAST(reviews_total_count AS SIGNED) DESC')
                    ->orderByRaw('CAST(rate_stars AS SIGNED) DESC')
                    ->paginate(20)
                    ->withQueryString()
                    ->onEachSide(0);

                return view('organization.index', compact('organizations', 'cities', 'city', 'categories', 'category'));
            }
        }

        abort(404);
    }
}

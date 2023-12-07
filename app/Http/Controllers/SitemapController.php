<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{
    public function sitemapStore()
    {
        $now = Carbon::now()->format('Y-m-d\T00:00:00+06:00');

        // Create sitemap for pages
        $sitemap_pages = App::make("sitemap");
        $sitemap_pages->add(route('home'), $now, '1.0', 'daily');
        $sitemap_pages->add(route('states.index'), $now, '1.0', 'daily');
        $sitemap_pages->store('xml', 'sitemap-pages');

        // Generate sitemap for state business
        $sitemap_state_business = App::make("sitemap");
        $business_states = State::all();

        foreach ($business_states as $business_state) {
            $organization_categories = Organization::select('organization_category', 'organization_category_slug', 'state_id', DB::raw('COUNT(*) as category_count'))
                ->where('state_id', $business_state->id)
                ->groupBy('organization_category', 'state_id', 'organization_category_slug')
                ->orderBy('category_count', 'desc')
                ->get();

            foreach ($organization_categories as $organization_category) {
                if ($organization_category->organization_category_slug) {
                    $sitemap_state_business->add(route('category.wise.business', ['state_slug' => $business_state->slug, 'organization_category_slug' => $organization_category->organization_category_slug]), $now, '0.8', 'monthly');
                }
            }
        }
        $sitemap_state_business->store('xml', 'sitemap_state_business');

        // Generate sitemap for state and city wise businesses
        $sitemap_state_city_business = App::make("sitemap");
        $states = State::all();
        foreach ($states as $state) {
            foreach ($state->cities as $city) {

                $organization_categories = Organization::select('organization_category', 'organization_category_slug', DB::raw('COUNT(*) as category_count'))
                    ->where('state_id', $state->id)
                    ->where('city_id', $city->id)
                    ->groupBy('organization_category', 'organization_category_slug')
                    ->orderByDesc('category_count')
                    ->get();

                foreach ($organization_categories as $organization_category) {
                    if ($organization_category->organization_category_slug) {
                        $sitemap_state_city_business->add(route('city.wise.organizations', ['state_slug' => $state->slug, 'city_slug' => $city->slug, 'organization_category_slug' => $organization_category->organization_category_slug]), $now, '0.8', 'monthly');
                    }
                }
            }
        }
        $sitemap_state_city_business->store('xml', 'sitemap_state_city_business');

        // Create the main sitemap index
        $sitemap = App::make("sitemap");
        $sitemap->addSitemap(URL::to('sitemap-pages.xml'), $now);
        $sitemap->addSitemap(URL::to('sitemap_state_business.xml'), $now);
        $sitemap->addSitemap(URL::to('sitemap_state_city_business.xml'), $now);

        // Fetch state-wise organizations and create sitemap instances
        $states = State::all();

        foreach ($states as $state) {
            $chunkNumber = 1;

            $state->organizations()->chunk(10000, function ($organizations) use ($now, $state, &$sitemap, &$chunkNumber) {
                $sitemap_state_wise_business = App::make("sitemap");

                foreach ($organizations as $organization) {
                    $sitemap_state_wise_business->add(
                        route('city.wise.organization', ['city_slug' => $organization->city->slug, 'organization_slug' => $organization->slug]), $now, '0.8', 'daily');
                }

                $sitemapFilename = 'sitemap_' . str_replace(' ', '_', strtolower($state->name)) . '_business';
                if ($chunkNumber > 1) {
                    $sitemapFilename .= sprintf("%02d", $chunkNumber);
                }

                $sitemap_state_wise_business->store('xml', $sitemapFilename);
                $sitemap->addSitemap(secure_url($sitemapFilename . '.xml'), $now);

                $chunkNumber++;
            });
        }

        $sitemap->store('sitemapindex', 'sitemap');

        return redirect(url('sitemap.xml'));
    }
}

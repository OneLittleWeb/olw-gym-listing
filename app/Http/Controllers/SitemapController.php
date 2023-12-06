<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
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
        // create new sitemap object
        $sitemap_pages = App::make("sitemap");
        // add item to the sitemap (url, date, priority, freq)
        $sitemap_pages->add(route('home'), $now, '1.0', 'daily');
        $sitemap_pages->add(route('states.index'), $now, '1.0', 'daily');
        $sitemap_pages->store('xml', 'sitemap-pages');

        //For state business
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

        //state and city wise businesses
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

        // create sitemap index
        $sitemap = App::make("sitemap");
        $sitemap->addSitemap(URL::to('sitemap-pages.xml'), $now);
        $sitemap->addSitemap(URL::to('sitemap_state_business.xml'), $now);
        $sitemap->addSitemap(URL::to('sitemap_state_city_business.xml'), $now);

        // fetch records in batches of 2000
        Organization::chunk(2000, function ($businesses) use ($sitemap, &$counter, &$sitemapCounter, $now) {
            // add every record to multiple sitemaps with one sitemap index
            foreach ($businesses as $business) {
                if ($counter == 2000) {
                    // generate new sitemap file
                    $sitemap->store('xml', 'sitemap_state_city_business_0' . $sitemapCounter);
                    // add the file to the sitemaps array
                    $sitemap->addSitemap(secure_url('sitemap_state_city_business_0' . $sitemapCounter . '.xml'), $now);
                    // reset items array (clear memory)
                    $sitemap->model->resetItems();
                    // reset the counter
                    $counter = 0;
                    // count generated sitemap
                    $sitemapCounter++;
                }

                // add record to items array
                $sitemap->add(route('city.wise.organization', ['city_slug' => $business->city->slug, 'organization_slug' => $business->slug]), $now, '0.8', 'daily');

                // count number of elements
                $counter++;
            }
        });

// you need to check for unused items
        if (!empty($sitemap->model->getItems())) {
            // generate sitemap with last items
            $sitemap->store('xml', 'sitemap_state_city_business_0' . $sitemapCounter);
            // add sitemap to sitemaps array
            $sitemap->addSitemap(secure_url('sitemap_state_city_business_0' . $sitemapCounter . '.xml'), $now);
            // reset items array
            $sitemap->model->resetItems();
        }

        $sitemap->store('sitemapindex', 'sitemap');

        return redirect(url('sitemap.xml'));
    }
}

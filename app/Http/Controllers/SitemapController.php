<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Organization;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{
    public function sitemapStore()
    {
        // create new sitemap object
        $sitemap_pages = App::make("sitemap");
        // add item to the sitemap (url, date, priority, freq)
        $sitemap_pages->add(route('all.categories'), Carbon::now()->format('Y-m-d\T00:00:00+06:00'), '1.0', 'daily');
        $sitemap_pages->add(route('city.index'), Carbon::now()->format('Y-m-d\T00:00:00+06:00'), '1.0', 'daily');
        $sitemap_pages->store('xml', 'sitemap-pages');

        //For category business
        $sitemap_category_business = App::make("sitemap");
        $business_categories = Category::all();
        foreach ($business_categories as $business_category) {
            $sitemap_category_business->add(route('category.business', $business_category->slug), Carbon::now()->format('Y-m-d\T00:00:00+06:00'), '0.7', 'monthly');
        }
        $sitemap_category_business->store('xml', 'sitemap_category_business');

        //city and category wise businesses
        $sitemap_city_category_all_business = App::make("sitemap");
        $categories = Category::all();
        $cities = Organization::select('city_id')->distinct()->get();
        foreach ($cities as $city) {
            $city_slug = City::find($city->city_id)->slug;
            foreach ($categories as $category) {
                $sitemap_city_category_all_business->add(route('city.wise.organizations', ['city_slug' => $city_slug, 'category_slug' => $category->slug]), Carbon::now()->format('Y-m-d\T00:00:00+06:00'), '0.7', 'monthly');
            }
        }
        $sitemap_city_category_all_business->store('xml', 'sitemap_city_category_all_business');

        //category cities
        $sitemap_category_cities = App::make("sitemap");
        $categories = Category::all();
        foreach ($categories as $category) {
            $sitemap_category_cities->add(route('category.index', $category->slug), Carbon::now()->format('Y-m-d\T00:00:00+06:00'), '0.7', 'monthly');
        }
        $sitemap_category_cities->store('xml', 'sitemap_category_cities');

        //city categories
        $sitemap_city_categories = App::make("sitemap");
        $cities = City::all();
        foreach ($cities as $city) {
            $sitemap_city_categories->add(route('category.index', $city->slug), Carbon::now()->format('Y-m-d\T00:00:00+06:00'), '0.7', 'monthly');
        }
        $sitemap_city_categories->store('xml', 'sitemap_city_categories');

        // create sitemap index
        $sitemap = App::make("sitemap");
        $sitemap->addSitemap(URL::to('sitemap-pages.xml'), Carbon::now()->format('Y-m-d\T00:00:00+06:00'));
        $sitemap->addSitemap(URL::to('sitemap_category_business.xml'), Carbon::now()->format('Y-m-d\T00:00:00+06:00'));
        $sitemap->addSitemap(URL::to('sitemap_city_category_all_business.xml'), Carbon::now()->format('Y-m-d\T00:00:00+06:00'));
        $sitemap->addSitemap(URL::to('sitemap_category_cities.xml'), Carbon::now()->format('Y-m-d\T00:00:00+06:00'));
        $sitemap->addSitemap(URL::to('sitemap_city_categories.xml'), Carbon::now()->format('Y-m-d\T00:00:00+06:00'));

        // fetch records in batches of 2000
        Organization::chunk(2000, function ($businesses) use ($sitemap, &$counter, &$sitemapCounter) {
            // add every record to multiple sitemaps with one sitemap index
            foreach ($businesses as $business) {
                if ($counter == 2000) {
                    // generate new sitemap file
                    $sitemap->store('xml', 'sitemap_city_category_business_0' . $sitemapCounter);
                    // add the file to the sitemaps array
                    $sitemap->addSitemap(secure_url('sitemap_city_category_business_0' . $sitemapCounter . '.xml'), Carbon::now()->format('Y-m-d\T00:00:00+06:00'));
                    // reset items array (clear memory)
                    $sitemap->model->resetItems();
                    // reset the counter
                    $counter = 0;
                    // count generated sitemap
                    $sitemapCounter++;
                }

                // add record to items array
                $sitemap->add(route('city.wise.organization', ['city_slug' => $business->city->slug, 'organization_slug' => $business->slug]), Carbon::now()->format('Y-m-d\T00:00:00+06:00'), '0.7', 'daily');

                // count number of elements
                $counter++;
            }
        });

// you need to check for unused items
        if (!empty($sitemap->model->getItems())) {
            // generate sitemap with last items
            $sitemap->store('xml', 'sitemap_city_category_business_0' . $sitemapCounter);
            // add sitemap to sitemaps array
            $sitemap->addSitemap(secure_url('sitemap_city_category_business_0' . $sitemapCounter . '.xml'), Carbon::now()->format('Y-m-d\T00:00:00+06:00'));
            // reset items array
            $sitemap->model->resetItems();
        }

        $sitemap->store('sitemapindex', 'sitemap_index');

        return redirect(url('sitemap_index.xml'));
    }
}

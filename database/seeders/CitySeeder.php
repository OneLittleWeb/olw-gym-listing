<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::truncate();

        $cities = [
            ['state_id' => 1, 'name' => 'birmingham', 'slug' => 'birmingham', 'is_major' => 0, 'background_image' => 'birmingham.png'],
            ['state_id' => 1, 'name' => 'montgomery', 'slug' => 'montgomery', 'is_major' => 0, 'background_image' => 'montgomery.png'],
            ['state_id' => 2, 'name' => 'anchorage', 'slug' => 'anchorage', 'is_major' => 0, 'background_image' => 'anchorage.png'],
            ['state_id' => 3, 'name' => 'phoenix', 'slug' => 'phoenix', 'is_major' => 0, 'background_image' => 'phoenix.png'],
            ['state_id' => 3, 'name' => 'tucson', 'slug' => 'tucson', 'is_major' => 0, 'background_image' => 'tucson.png'],
            ['state_id' => 4, 'name' => 'fort smith', 'slug' => 'fort-smith', 'is_major' => 0, 'background_image' => 'fort-smith.png'],
            ['state_id' => 4, 'name' => 'little rock', 'slug' => 'little-rock', 'is_major' => 0, 'background_image' => 'little-rock.png'],
            ['state_id' => 5, 'name' => 'los angeles', 'slug' => 'los-angeles', 'is_major' => 0, 'background_image' => 'los-angeles.png'],
            ['state_id' => 5, 'name' => 'san diego', 'slug' => 'san-diego', 'is_major' => 0, 'background_image' => 'san-diego.png'],
            ['state_id' => 6, 'name' => 'colorado springs', 'slug' => 'colorado-springs', 'is_major' => 0, 'background_image' => 'colorado-springs.png'],
            ['state_id' => 6, 'name' => 'denver', 'slug' => 'denver', 'is_major' => 0, 'background_image' => 'denver.png'],
            ['state_id' => 7, 'name' => 'bridgeport', 'slug' => 'bridgeport', 'is_major' => 0, 'background_image' => 'bridgeport.png'],
            ['state_id' => 7, 'name' => 'new haven', 'slug' => 'new-haven', 'is_major' => 0, 'background_image' => 'new-haven.png'],
            ['state_id' => 8, 'name' => 'wilmington', 'slug' => 'wilmington', 'is_major' => 0, 'background_image' => 'wilmington.png'],
            ['state_id' => 9, 'name' => 'washington dc', 'slug' => 'washington-dc', 'is_major' => 0, 'background_image' => 'washington-dc.png'],
            ['state_id' => 10, 'name' => 'jacksonville', 'slug' => 'jacksonville', 'is_major' => 0, 'background_image' => 'jacksonville.png'],
            ['state_id' => 10, 'name' => 'miami', 'slug' => 'miami', 'is_major' => 0, 'background_image' => 'miami.png'],
            ['state_id' => 11, 'name' => 'atlanta', 'slug' => 'atlanta', 'is_major' => 0, 'background_image' => 'atlanta.png'],
            ['state_id' => 11, 'name' => 'augusta richmond county', 'slug' => 'augusta-richmond-county', 'is_major' => 0, 'background_image' => 'augusta-richmond-county.png'],
            ['state_id' => 12, 'name' => 'honolulu', 'slug' => 'honolulu', 'is_major' => 0, 'background_image' => 'honolulu.png'],
            ['state_id' => 13, 'name' => 'boise', 'slug' => 'boise', 'is_major' => 0, 'background_image' => 'boise.png'],
            ['state_id' => 13, 'name' => 'nampa', 'slug' => 'nampa', 'is_major' => 0, 'background_image' => 'nampa.png'],
            ['state_id' => 14, 'name' => 'aurora', 'slug' => 'aurora', 'is_major' => 0, 'background_image' => 'aurora.png'],
            ['state_id' => 14, 'name' => 'chicago', 'slug' => 'chicago', 'is_major' => 0, 'background_image' => 'chicago.png'],
            ['state_id' => 15, 'name' => 'fort wayne', 'slug' => 'fort-wayne', 'is_major' => 0, 'background_image' => 'fort-wayne.png'],
            ['state_id' => 15, 'name' => 'indianapolis', 'slug' => 'indianapolis', 'is_major' => 0, 'background_image' => 'indianapolis.png'],
            ['state_id' => 16, 'name' => 'cedar rapids', 'slug' => 'cedar-rapids', 'is_major' => 0, 'background_image' => 'cedar-rapids.png'],
            ['state_id' => 16, 'name' => 'des moines', 'slug' => 'des-moines', 'is_major' => 0, 'background_image' => 'des-moines.png'],
            ['state_id' => 17, 'name' => 'overland park', 'slug' => 'overland-park', 'is_major' => 0, 'background_image' => 'overland-park.png'],
            ['state_id' => 17, 'name' => 'wichita', 'slug' => 'wichita', 'is_major' => 0, 'background_image' => 'wichita.png'],
            ['state_id' => 18, 'name' => 'lexington', 'slug' => 'lexington', 'is_major' => 0, 'background_image' => 'lexington.png'],
            ['state_id' => 18, 'name' => 'louisville', 'slug' => 'louisville', 'is_major' => 0, 'background_image' => 'louisville.png'],
            ['state_id' => 19, 'name' => 'baton rouge', 'slug' => 'baton-rouge', 'is_major' => 0, 'background_image' => 'baton-rouge.png'],
            ['state_id' => 19, 'name' => 'new orleans', 'slug' => 'new-orleans', 'is_major' => 0, 'background_image' => 'new-orleans.png'],
            ['state_id' => 20, 'name' => 'portland', 'slug' => 'portland', 'is_major' => 0, 'background_image' => 'portland.png'],
            ['state_id' => 21, 'name' => 'baltimore', 'slug' => 'baltimore', 'is_major' => 0, 'background_image' => 'baltimore.png'],
            ['state_id' => 22, 'name' => 'boston', 'slug' => 'boston', 'is_major' => 0, 'background_image' => 'boston.png'],
            ['state_id' => 22, 'name' => 'worcester', 'slug' => 'worcester', 'is_major' => 0, 'background_image' => 'worcester.png'],
            ['state_id' => 23, 'name' => 'detroit', 'slug' => 'detroit', 'is_major' => 0, 'background_image' => 'detroit.png'],
            ['state_id' => 23, 'name' => 'grand rapids', 'slug' => 'grand-rapids', 'is_major' => 0, 'background_image' => 'grand-rapids.png'],
            ['state_id' => 24, 'name' => 'minneapolis', 'slug' => 'minneapolis', 'is_major' => 0, 'background_image' => 'minneapolis.png'],
            ['state_id' => 24, 'name' => 'st. paul', 'slug' => 'st-paul', 'is_major' => 0, 'background_image' => 'st-paul.png'],
            ['state_id' => 25, 'name' => 'gulfport', 'slug' => 'gulfport', 'is_major' => 0, 'background_image' => 'gulfport.png'],
            ['state_id' => 25, 'name' => 'jackson', 'slug' => 'jackson', 'is_major' => 0, 'background_image' => 'jackson.png'],
            ['state_id' => 26, 'name' => 'kansas city', 'slug' => 'kansas-city', 'is_major' => 0, 'background_image' => 'kansas-city.png'],
            ['state_id' => 26, 'name' => 'st. louis', 'slug' => 'st-louis', 'is_major' => 0, 'background_image' => 'st-louis.png'],
            ['state_id' => 27, 'name' => 'billings', 'slug' => 'billings', 'is_major' => 0, 'background_image' => 'billings.png'],
            ['state_id' => 27, 'name' => 'missoula', 'slug' => 'missoula', 'is_major' => 0, 'background_image' => 'missoula.png'],
            ['state_id' => 28, 'name' => 'lincoln', 'slug' => 'lincoln', 'is_major' => 0, 'background_image' => 'lincoln.png'],
            ['state_id' => 28, 'name' => 'omaha', 'slug' => 'omaha', 'is_major' => 0, 'background_image' => 'omaha.png'],
            ['state_id' => 29, 'name' => 'henderson', 'slug' => 'henderson', 'is_major' => 0, 'background_image' => 'henderson.png'],
            ['state_id' => 29, 'name' => 'las vegas', 'slug' => 'las-vegas', 'is_major' => 0, 'background_image' => 'las-vegas.png'],
            ['state_id' => 30, 'name' => 'manchester', 'slug' => 'manchester', 'is_major' => 0, 'background_image' => 'manchester.png'],
            ['state_id' => 30, 'name' => 'nashua', 'slug' => 'nashua', 'is_major' => 0, 'background_image' => 'nashua.png'],
            ['state_id' => 31, 'name' => 'jersey city', 'slug' => 'jersey-city', 'is_major' => 0, 'background_image' => 'jersey-city.png'],
            ['state_id' => 31, 'name' => 'newark', 'slug' => 'newark', 'is_major' => 0, 'background_image' => 'newark.png'],
            ['state_id' => 32, 'name' => 'albuquerque', 'slug' => 'albuquerque', 'is_major' => 0, 'background_image' => 'albuquerque.png'],
            ['state_id' => 32, 'name' => 'las cruces', 'slug' => 'las-cruces', 'is_major' => 0, 'background_image' => 'las-cruces.png'],
            ['state_id' => 33, 'name' => 'buffalo', 'slug' => 'buffalo', 'is_major' => 0, 'background_image' => 'buffalo.png'],
            ['state_id' => 33, 'name' => 'new york', 'slug' => 'new-york', 'is_major' => 0, 'background_image' => 'new-york.png'],
            ['state_id' => 34, 'name' => 'charlotte', 'slug' => 'charlotte', 'is_major' => 0, 'background_image' => 'charlotte.png'],
            ['state_id' => 34, 'name' => 'raleigh', 'slug' => 'raleigh', 'is_major' => 0, 'background_image' => 'raleigh.png'],
            ['state_id' => 35, 'name' => 'fargo', 'slug' => 'fargo', 'is_major' => 0, 'background_image' => 'fargo.png'],
            ['state_id' => 36, 'name' => 'cleveland', 'slug' => 'cleveland', 'is_major' => 0, 'background_image' => 'cleveland.png'],
            ['state_id' => 36, 'name' => 'columbus', 'slug' => 'columbus', 'is_major' => 0, 'background_image' => 'columbus.png'],
            ['state_id' => 37, 'name' => 'oklahoma city', 'slug' => 'oklahoma-city', 'is_major' => 0, 'background_image' => 'oklahoma-city.png'],
            ['state_id' => 37, 'name' => 'tulsa', 'slug' => 'tulsa', 'is_major' => 0, 'background_image' => 'tulsa.png'],
            ['state_id' => 38, 'name' => 'eugene', 'slug' => 'eugene', 'is_major' => 0, 'background_image' => 'eugene.png'],
            ['state_id' => 38, 'name' => 'portland', 'slug' => 'portland', 'is_major' => 0, 'background_image' => 'portland.png'],
            ['state_id' => 39, 'name' => 'philadelphia', 'slug' => 'philadelphia', 'is_major' => 0, 'background_image' => 'philadelphia.png'],
            ['state_id' => 39, 'name' => 'pittsburgh', 'slug' => 'pittsburgh', 'is_major' => 0, 'background_image' => 'pittsburgh.png'],
            ['state_id' => 40, 'name' => 'providence', 'slug' => 'providence', 'is_major' => 0, 'background_image' => 'providence.png'],
            ['state_id' => 40, 'name' => 'warwick', 'slug' => 'warwick', 'is_major' => 0, 'background_image' => 'warwick.png'],
            ['state_id' => 41, 'name' => 'charleston', 'slug' => 'charleston', 'is_major' => 0, 'background_image' => 'charleston.png'],
            ['state_id' => 41, 'name' => 'columbia', 'slug' => 'columbia', 'is_major' => 0, 'background_image' => 'columbia.png'],
            ['state_id' => 42, 'name' => 'rapid city', 'slug' => 'rapid-city', 'is_major' => 0, 'background_image' => 'rapid-city.png'],
            ['state_id' => 42, 'name' => 'sioux falls', 'slug' => 'sioux-falls', 'is_major' => 0, 'background_image' => 'sioux-falls.png'],
            ['state_id' => 43, 'name' => 'memphis', 'slug' => 'memphis', 'is_major' => 0, 'background_image' => 'memphis.png'],
            ['state_id' => 43, 'name' => 'nashville', 'slug' => 'nashville', 'is_major' => 0, 'background_image' => 'nashville.png'],
            ['state_id' => 44, 'name' => 'houston', 'slug' => 'houston', 'is_major' => 0, 'background_image' => 'houston.png'],
            ['state_id' => 44, 'name' => 'san antonio', 'slug' => 'san-antonio', 'is_major' => 0, 'background_image' => 'san-antonio.png'],
            ['state_id' => 45, 'name' => 'salt lake city', 'slug' => 'salt-lake-city', 'is_major' => 0, 'background_image' => 'salt-lake-city.png'],
            ['state_id' => 45, 'name' => 'west valley city', 'slug' => 'west-valley-city', 'is_major' => 0, 'background_image' => 'west-valley-city.png'],
            ['state_id' => 46, 'name' => 'burlington', 'slug' => 'burlington', 'is_major' => 0, 'background_image' => 'burlington.png'],
            ['state_id' => 47, 'name' => 'norfolk', 'slug' => 'norfolk', 'is_major' => 0, 'background_image' => 'norfolk.png'],
            ['state_id' => 47, 'name' => 'virginia beach', 'slug' => 'virginia-beach', 'is_major' => 0, 'background_image' => 'virginia-beach.png'],
            ['state_id' => 48, 'name' => 'seattle', 'slug' => 'seattle', 'is_major' => 0, 'background_image' => 'seattle.png'],
            ['state_id' => 48, 'name' => 'spokane', 'slug' => 'spokane', 'is_major' => 0, 'background_image' => 'spokane.png'],
            ['state_id' => 49, 'name' => 'charleston', 'slug' => 'charleston', 'is_major' => 0, 'background_image' => 'charleston.png'],
            ['state_id' => 50, 'name' => 'madison', 'slug' => 'madison', 'is_major' => 0, 'background_image' => 'madison.png'],
            ['state_id' => 50, 'name' => 'milwaukee', 'slug' => 'milwaukee', 'is_major' => 0, 'background_image' => 'milwaukee.png'],
            ['state_id' => 51, 'name' => 'cheyenne', 'slug' => 'cheyenne', 'is_major' => 0, 'background_image' => 'cheyenne.png'],
        ];
        foreach ($cities as $city) {
            City::create($city);
        }
    }
}

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
            ['name' => 'omaha', 'is_major' => 1, 'population' => 488059, 'background_image' => 'omaha.jpg'],
            ['name' => 'lincoln', 'is_major' => 1, 'population' => 289136, 'background_image' => 'lincoln.jpg'],
            ['name' => 'bellevue', 'is_major' => 1, 'population' => 62888, 'background_image' => 'bellevue.jpg'],
            ['name' => 'grand island', 'is_major' => 1, 'population' => 52755, 'background_image' => 'grand_island.jpg'],
            ['name' => 'kearney', 'is_major' => 0, 'population' => 33558, 'background_image' => 'kearney.jpg'],
            ['name' => 'fremont', 'is_major' => 0, 'population' => 27245, 'background_image' => 'fremont.jpg'],
            ['name' => 'hastings', 'is_major' => 0, 'population' => 25247, 'background_image' => 'hastings.jpg'],
            ['name' => 'norfolk', 'is_major' => 0, 'population' => 24964, 'background_image' => 'norfolk.jpg'],
            ['name' => 'columbus', 'is_major' => 0, 'population' => 23954, 'background_image' => 'columbus.jpg'],
            ['name' => 'papillion', 'is_major' => 0, 'population' => 23875, 'background_image' => 'papillion.jpg'],
            ['name' => 'north platte', 'is_major' => 0, 'population' => 23543, 'background_image' => 'north-platte.jpg'],
        ];
        foreach ($cities as $city) {
            City::create($city);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::orderBy('name')->get();
        $city = null;
        $category = null;
        return view('city.index', compact('cities', 'city', 'category'));
    }

    public function importCityData()
    {
        try {
            $baseDirectory = 'H:\gym';
            if (!File::exists($baseDirectory)) {
                throw new \Exception('Base directory does not exist.');
            }

            $stateDirectories = File::directories($baseDirectory);

            foreach ($stateDirectories as $stateDirectory) {
                $stateName = trim(basename($stateDirectory), " ");
                $state = State::where('name', Str::lower($stateName))->first();

                if (!$state) {
                    throw new \Exception('State not found: ' . $stateName);
                }

                $stateId = $state->id;

                $cityDirectories = File::directories($stateDirectory);

                foreach ($cityDirectories as $cityDirectory) {
                    $cityName = trim(basename($cityDirectory), " ");
                    $cityNameLower = Str::lower($cityName);

                    // Check if the city already exists in the database
                    $existingCity = City::where('name', $cityNameLower)->where('state_id', $stateId)->first();

                    if (!$existingCity) {
                        $city = new City();
                        $city->name = $cityNameLower;
                        $city->slug = Str::slug($cityNameLower);
                        $city->background_image = Str::slug($cityNameLower) . '.png';
                        $city->state_id = $stateId;
                        $city->save();
                    }
                }
            }

            return redirect()->back()->with('success', 'Cities imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


//    public function importCityData()
//    {
//        try {
//
//            $baseDirectory = 'H:\gym';
//            if (!File::exists($baseDirectory)) {
//                throw new \Exception('Base directory does not exist.');
//            }
//
//            $stateDirectories = File::directories($baseDirectory);
//
//            foreach ($stateDirectories as $stateDirectory) {
//                $stateName = trim(basename($stateDirectory), " ");
//                $state = State::where('name', Str::lower($stateName))->first();
//
//                if (!$state) {
//                    throw new \Exception('State not found: ' . $stateName);
//                }
//
//                $stateId = $state->id;
//
//                $cityDirectories = File::directories($stateDirectory);
//
//                foreach ($cityDirectories as $cityDirectory) {
//                    $cityName = trim(basename($cityDirectory), " ");
//                    $city = new City();
//                    $city->name = Str::lower($cityName);
//                    $city->slug = Str::slug($cityName);
//                    $city->background_image = Str::slug($cityName) . '.png';
//                    $city->state_id = $stateId;
//                    $city->save();
//                }
//            }
//
//            // Success message
//            return redirect()->back()->with('success', 'Cities imported successfully.');
//        } catch (\Exception $e) {
//            // Handle exceptions
//            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
//        }
//    }

}

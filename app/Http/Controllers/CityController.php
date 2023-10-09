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
        return view('city.index', compact('cities', 'city','category'));
    }

    public function importCityData()
    {
        try {
            City::truncate();

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

                // Fetch city directories within each state directory
                $cityDirectories = File::directories($stateDirectory);

                foreach ($cityDirectories as $cityDirectory) {
                    $cityName = trim(basename($cityDirectory), " ");
                    $city = new City();
                    $city->name = $cityName;
                    $city->slug = Str::slug($cityName);
                    $city->background_image = Str::slug($cityName) . '.png';
                    $city->state_id = $stateId;
                    $city->save();
                }
            }

            // Success message
            return redirect()->back()->with('success', 'Cities imported successfully.');
        } catch (\Exception $e) {
            // Handle exceptions
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

}

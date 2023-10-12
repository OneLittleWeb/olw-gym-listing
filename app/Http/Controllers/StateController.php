<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class StateController extends Controller
{
    public function index()
    {
        $states = State::all();
        $cities = City::orderByDesc('id')->get();
        $city = null;
        $category = null;

        return view('state.index', compact('states', 'cities', 'city', 'category'));
    }

    public function importStateName()
    {
        try {
            $stateDirectories = File::directories('H:\gym');

            foreach ($stateDirectories as $stateDirectory) {
                $stateName = trim(basename($stateDirectory), " ");
                $stateNameLower = Str::lower($stateName);

                // Check if the state already exists in the database
                $existingState = State::where('name', $stateNameLower)->first();

                if (!$existingState) {
                    $state = new State();
                    $state->name = $stateNameLower;
                    $state->slug = Str::slug($stateNameLower);
                    $state->background_image = Str::slug($stateNameLower) . '.png';
                    $state->save();
                }
            }

            return redirect()->back()->with('success', 'States imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


//    public function importStateName()
//    {
//        $state_directories = File::directories('H:\gym');
//
//        foreach ($state_directories as $state_directory) {
//            $state_name = trim(basename($state_directory), " ");
//            $state = new State();
//            $state->name = $state_name;
//            $state->slug = Str::slug($state_name);
//            $state->background_image = Str::slug($state_name) . '.png';
//            $state->save();
//        }
//
//        alert()->success('success', 'States imported successfully.');
//
//        return redirect()->back();
//    }
}

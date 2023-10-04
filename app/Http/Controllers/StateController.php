<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class StateController extends Controller
{
    public function importStateName()
    {
        State::truncate();

        $state_directories = File::directories('H:\gym');

        foreach ($state_directories as $state_directory) {
            $state_name = trim(basename($state_directory), " ");
            $state = new State();
            $state->name = $state_name;
            $state->slug = Str::slug($state_name);
            $state->background_image = Str::slug($state_name) . '.jpg';
            $state->save();
        }

        alert()->success('success', 'States imported successfully.');

        return redirect()->back();
    }
}

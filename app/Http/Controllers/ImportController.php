<?php

namespace App\Http\Controllers;

use App\Imports\ImportOrganization;
use App\Jobs\ExcelImportJob;
use App\Jobs\ImageCopyPasteJob;
use App\Models\City;
use App\Models\Organization;
use App\Models\State;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
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

    public function importCityName()
    {
        try {
//            $baseDirectory = 'H:\4city';

            $baseDirectory = public_path('6city_separate');

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
                    $existingCity = City::where('state_id', $stateId)->where('name', $cityNameLower)->first();

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

    public function importOrganizationData()
    {
        try {
//            $state_directories = File::directories('H:\6city_separate');

            $state_directories = File::directories(public_path('6city_separate'));

            foreach ($state_directories as $state_directory) {

                $state_name = trim(basename($state_directory), " ");

                $state = State::where('name', Str::lower($state_name))->first();

                if ($state) {

                    $state_id = $state->id;

                    foreach (File::directories($state_directory) as $city_directory) {

                        $city_name = trim(basename($city_directory), " ");
                        $city = City::where('name', Str::lower($city_name))->where('state_id', $state_id)->first();

                        if ($city) {
                            $city_id = $city->id;
                            $files = File::files($city_directory);

                            if (count($files) > 0) {
                                ExcelImportJob::dispatch($state_id, $city_id, $files[0]->getRealPath());
                            } else {
                                alert()->error('Error', "No Excel files found in the '$city_name' directory.");
                            }
                        } else {
                            alert()->error('Error', "City '$city_name' not found in the database.");
                        }
                    }
                } else {
                    alert()->error('Error', "State '$state_name' not found in the database.");
                }
            }

            alert()->success('Success', 'Organization data import job dispatched successfully.');
        } catch (\Exception $e) {
            alert()->error('Error', 'An error occurred during the import process.');
            \Log::error('Import Error: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function imageCopyPasteFromOneFolderToAnother()
    {
        dispatch(new ImageCopyPasteJob());

        return redirect()->back()->with('success', 'Images copy and paste job has been queued for execution.');
    }

    //    public function importCityName()
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

//    public function importOrganizationData()
//    {
//        try {
//            $state_directories = File::directories('H:\gym_div_2');
//            $successCount = 0;
//
//            foreach ($state_directories as $state_directory) {
//                $state_name = trim(basename($state_directory), " ");
//                $state = State::where('name', Str::lower($state_name))->first();
//
//                if ($state) {
//                    $state_id = $state->id;
//
//                    foreach (File::directories($state_directory) as $city_directory) {
//                        $city_name = trim(basename($city_directory), " ");
//                        $city = City::where('name', Str::lower($city_name))->first();
//
//                        if ($city) {
//                            $city_id = $city->id;
//                            $files = File::files($city_directory);
//
//                            if (count($files) > 0) {
//                                Excel::import(new ImportOrganization($state_id, $city_id), $files[0]);
//                                $successCount++; // Increment the success count
//                            } else {
//                                // Handle the case where no files were found in the city directory
//                                alert()->error('Error', "No Excel files found in the '$city_name' directory.");
//                            }
//                        } else {
//                            // Handle the case where the city is not found in the database
//                            alert()->error('Error', "City '$city_name' not found in the database.");
//                        }
//                    }
//                } else {
//                    // Handle the case where the state is not found in the database
//                    alert()->error('Error', "State '$state_name' not found in the database.");
//                }
//            }
//
//            if ($successCount > 0) {
//                alert()->success('Success', "{$successCount} files imported successfully.");
//            } else {
//                alert()->info('Info', 'No files were imported.');
//            }
//        } catch (\Exception $e) {
//            // Handle exceptions, log errors, and provide user feedback
//            alert()->error('Error', 'An error occurred during the import process.');
//            \Log::error('Import Error: ' . $e->getMessage());
//        }
//
//        return redirect()->back();
//    }

//    public function importOrganizationData()
//    {
//        $state_directories = File::directories('H:\gym');
//
//        foreach ($state_directories as $state_directory) {
//            $state_name = trim(basename($state_directory), " ");
//            $state_id = State::where('name', Str::lower($state_name))->first()->id;
//
//            foreach (File::directories($state_directory) as $city_directory) {
//
//                $city_name = trim(basename($city_directory), " ");
//                $city_id = City::where('name', Str::lower($city_name))->first()->id;
//
//                $files = File::files($city_directory);
//
//                Excel::import(new ImportOrganization($state_id, $city_id), $files[0]);
//            }
//        }
//
//        alert()->success('success', 'Organization data imported successfully.');
//
//        return redirect()->back();
//    }

//    public function copyPaste()
//    {
//        try {
//            $state_directories = File::directories('H:\gym');
//
//            foreach ($state_directories as $state_directory) {
//                foreach (File::directories($state_directory) as $city_directory) {
//
//                    $sourcePath = File::glob($city_directory . '/media/*');
//
//                    foreach ($sourcePath as $source) {
//
//                        $destinationPath = 'H:\gymnearx-images';
//                        $file = basename($source);
//                        $destinationPath = $destinationPath . '/' . $file;
//                        File::copy($source, $destinationPath);
//                    }
//                }
//            }
//
//            return redirect()->back()->with('success', 'Images copy and past successfully completed.');
//        } catch (\Exception $e) {
//            // Handle exceptions
//            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
//        }
//    }
}

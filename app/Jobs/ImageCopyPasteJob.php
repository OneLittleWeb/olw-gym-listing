<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ImageCopyPasteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $state_directories = File::directories('H:\gymnearx_city_separated\8city');

            foreach ($state_directories as $state_directory) {
                foreach (File::directories($state_directory) as $city_directory) {
                    $sourcePath = File::glob($city_directory . '/media/*');
                    foreach ($sourcePath as $source) {
                        $destinationPath = 'H:\8city_image';
                        $file = basename($source);
                        $destinationPath = $destinationPath . '/' . $file;
                        File::copy($source, $destinationPath);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
        }
    }

    // Log a message to indicate that the job has completed
    public function completed()
    {
        Log::info('Image copy paste for file has completed.');
    }
}

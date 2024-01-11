<?php

namespace App\Jobs;

use App\Imports\ImportOrganization;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Excel;
use Illuminate\Foundation\Bus\Dispatchable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\ToCollection;

class ExcelImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $stateId;
    protected $cityId;
    protected $cityName;
    protected $filePath;

    public function __construct($stateId, $cityId, $cityName, $filePath)
    {
        $this->stateId = $stateId;
        $this->cityId = $cityId;
        $this->cityName = $cityName;
        $this->filePath = $filePath;
    }

    public function handle(Excel $excel)
    {
        $import = new ImportOrganization($this->stateId, $this->cityId);

        try {
            $excel->import($import, $this->filePath);
        } catch (\Exception $e) {
            Log::error('ExcelImportJob failed for file: ' . $this->filePath);
            Log::error('Error: ' . $e->getMessage());
        }
    }

    // Log a message to indicate that the job has completed
    public function completed()
    {
        Log::info('ExcelImportJob for the ' . $this->cityName . ' (' .$this->cityId . ') is processing.');
    }
}

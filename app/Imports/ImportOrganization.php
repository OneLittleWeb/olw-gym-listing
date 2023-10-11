<?php

namespace App\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class ImportOrganization implements WithMultipleSheets
{
    protected $state_id;
    protected $city_id;

    public function __construct($state_id, $city_id)
    {
        $this->state_id = $state_id;
        $this->city_id = $city_id;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function sheets(): array
    {
        Log::info('Completed successfully for the city: ' . $this->city_id);

        return [
            new FirstSheetImporter($this->state_id, $this->city_id),
            new SecondSheetImporter(),
        ];
    }
}

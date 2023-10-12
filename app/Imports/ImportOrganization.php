<?php

namespace App\Imports;

use Illuminate\Support\Facades\Log;
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

    public function sheets(): array
    {
        Log::info('Completed successfully for the city: ' . $this->city_id);

        return [
            new FirstSheetImporter($this->state_id, $this->city_id),
            new SecondSheetImporter(),
        ];
    }
}

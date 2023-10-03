<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class ImportOrganization implements WithMultipleSheets
{
    protected $category_id;
    protected $city_id;

    public function __construct($category_id, $city_id)
    {
        $this->category_id = $category_id;
        $this->city_id = $city_id;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function sheets(): array
    {
        return [
            new FirstSheetImporter($this->category_id, $this->city_id),
            new SecondSheetImporter(),
        ];
    }
}

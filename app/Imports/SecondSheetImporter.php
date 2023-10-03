<?php

namespace App\Imports;

use App\Models\Picture;
use App\Models\Review;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;

class SecondSheetImporter implements ToCollection, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Review::updateOrCreate([
                'review_id' => $row[1],
            ], [
                'organization_guid' => (!empty($row[13])) ? $row[13] : null,
                'organization_gmaps_id' => (!empty($row[12])) ? $row[12] : null,
                'review_id' => $row[1],
                'reviewer_name' => (!empty($row[2])) ? $row[2] : null,
                'reviewer_reviews_count' => (!empty($row[4])) ? $row[4] : null,
                'review_date' => (!empty($row[5])) ? $row[5] : null,
                'review_rate_stars' => (!empty($row[6])) ? $row[6] : null,
                'review_text_original' => (!empty($row[7])) ? $row[7] : null,
                'review_photos_files' => (!empty($row[10])) ? $row[10] : null,
                'review_thumbs_up_value' => (!empty($row[14])) ? $row[14] : null,
            ]);

            $photo_paths = $row[10];
            $photo_path_array = explode(',', $photo_paths);

            foreach ($photo_path_array as $photo_path) {
                if ($photo_path) {
                    Picture::updateOrCreate([
                        'picture_file' => $photo_path
                    ], [
                        'organization_guid' => $row[13],
                        'review_id' => $row[1],
                    ]);
                }
            }
        }
    }
}

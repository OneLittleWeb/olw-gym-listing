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
            $reviewId = $row[1];

            // You might want to validate if $reviewId is a valid value before proceeding
            if (!$reviewId) {
                continue; // Skip this row if review_id is empty
            }

            Review::updateOrCreate(
                ['review_id' => $reviewId],
                [
                    'organization_guid' => $row[13] ?? null,
                    'organization_gmaps_id' => $row[12] ?? null,
                    'reviewer_name' => $row[2] ?? null,
                    'reviewer_reviews_count' => $row[4] ?? null,
                    'review_date' => $row[5] ?? null,
                    'review_rate_stars' => $row[6] ?? null,
                    'review_text_original' => $row[7] ?? null,
                    'review_photos_files' => $row[10] ?? null,
                    'review_thumbs_up_value' => $row[14] ?? null,
                ]
            );
        }
    }
}

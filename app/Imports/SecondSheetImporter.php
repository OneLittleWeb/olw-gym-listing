<?php

namespace App\Imports;

use App\Models\Review;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;

class SecondSheetImporter implements ToCollection, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows)
    {
        $chunkSize = 500; // Set your preferred chunk size

        $rows->chunk($chunkSize)->each(function ($chunk) {
            $recordsToUpdate = [];

            $chunk->each(function ($row) use (&$recordsToUpdate) {
                $reviewId = $row[1];

                if (!$reviewId) {
                    return;
                }

                $reviewData = [
                    'organization_guid' => $row[13] ?? null,
                    'organization_gmaps_id' => $row[12] ?? null,
                    'reviewer_name' => $row[2] ?? null,
                    'reviewer_reviews_count' => $row[4] ?? null,
                    'review_date' => $row[5] ?? null,
                    'review_specified_date' => $this->diffForHumansToCarbon($row[5], Carbon::now()->toDateTimeString()),
                    'review_rate_stars' => $row[6] ?? null,
                    'review_text_original' => $row[7] ?? null,
                    'review_photos_files' => $row[10] ?? null,
                    'review_thumbs_up_value' => $row[14] ?? null,
                ];

                $recordsToUpdate[] = [
                    'criteria' => ['review_id' => $reviewId],
                    'data' => $reviewData
                ];
            });

            // Update or create records in chunks
            foreach ($recordsToUpdate as $record) {
                Review::updateOrCreate($record['criteria'], $record['data']);
            }
        });
    }

//    public function collection(Collection $rows)
//    {
//        foreach ($rows as $row) {
//            $reviewId = $row[1];
//
//            if (!$reviewId) {
//                continue;
//            }
//
//            Review::updateOrCreate(
//                ['review_id' => $reviewId],
//                [
//                    'organization_guid' => $row[13] ?? null,
//                    'organization_gmaps_id' => $row[12] ?? null,
//                    'reviewer_name' => $row[2] ?? null,
//                    'reviewer_reviews_count' => $row[4] ?? null,
//                    'review_date' => $row[5] ?? null,
//                    'review_specified_date' => $this->diffForHumansToCarbon($row[5], Carbon::now()->toDateTimeString()),
//                    'review_rate_stars' => $row[6] ?? null,
//                    'review_text_original' => $row[7] ?? null,
//                    'review_photos_files' => $row[10] ?? null,
//                    'review_thumbs_up_value' => $row[14] ?? null,
//                ]
//            );
//        }
//    }

    function diffForHumansToCarbon($current_review_date, $created_at)
    {
        $carbon = Carbon::parse($created_at);

        // Try matching the standard pattern
        $pattern = '/(\d+)\s(\w+)\s(ago|from now)/';

        if (preg_match($pattern, $current_review_date, $matches)) {
            $units = $matches[1];
            $unitType = $matches[2];
            $direction = $matches[3];

            if ($units == 1) {
                // Handle special cases for "a year ago," "a month ago," "a week ago," and "a day ago"
                if (in_array($unitType, ['year', 'month', 'week', 'day'])) {
                    $unitType = rtrim($unitType, 's');
                }
            }

            if ($direction === 'ago') {
                $carbon->sub($units, $unitType);
            } else {
                $carbon->add($units, $unitType);
            }

            return $carbon;
        }

        // If the standard pattern doesn't match, try alternative patterns
        if (preg_match('/a year ago/i', $current_review_date)) {
            $carbon->subYears(1);
            return $carbon;
        } elseif (preg_match('/a month ago/i', $current_review_date)) {
            $carbon->subMonths(1);
            return $carbon;
        } elseif (preg_match('/a week ago/i', $current_review_date)) {
            $carbon->subWeeks(1);
            return $carbon;
        } elseif (preg_match('/a day ago/i', $current_review_date)) {
            $carbon->subDays(1);
            return $carbon;
        }

        return null; // Handle unsupported formats gracefully.
    }
}

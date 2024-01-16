<?php

namespace App\Imports;

use App\Models\City;
use App\Models\Organization;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;

class FirstSheetImporter implements ToCollection, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    protected $state_id;
    protected $city_id;

    public function __construct($state_id, $city_id)
    {
        $this->state_id = $state_id;
        $this->city_id = $city_id;
    }

    public function collection(Collection $rows)
    {
        $rows->each(function ($row) {
            $org_city_id = $this->city_id; // Default city ID

            if (!empty($row[8])) {
                $address = $row[8];
                $exploded_address = array_map('trim', explode(',', $address)); // Explode address parts and trim whitespaces
                if (isset($exploded_address[1])) {
                    $org_city = City::where('name', Str::lower($exploded_address[1]))->first();
                    if ($org_city) {
                        $org_city_id = $org_city->id; // Assign city ID if found
                    }
                }
            }

            $organizationData = [
                'organization_gmaps_id' => $row[3],
                'category_id' => 1,
                'state_id' => $this->state_id,
                'city_id' => $org_city_id,
                'gmaps_link' => (!empty($row[1])) ? $row[1] : null,
                'organization_name' => (!empty($row[2])) ? $row[2] : null,
                'organization_guid' => (!empty($row[38])) ? $row[38] : null,
                'rate_stars' => (!empty($row[4])) ? $row[4] : null,
                'reviews_total_count' => (!empty($row[5])) ? $row[5] : null,
                'price_policy' => (!empty($row[6])) ? $row[6] : null,
                'organization_category' => (!empty($row[7])) ? $row[7] : null,
                'organization_category_slug' => (!empty($row[7])) ? Str::slug($row[7]) : null,
                'organization_address' => (!empty($row[8])) ? $row[8] : null,
                'located_in' => (!empty($row[9])) ? $row[9] : null,
                'organization_website' => (!empty($row[10])) ? $row[10] : null,
                'organization_phone_number' => (!empty($row[11])) ? $row[11] : null,
                'organization_plus_code' => (!empty($row[12])) ? $row[12] : null,
                'organization_work_time' => (!empty($row[13])) ? $row[13] : null,
                'popular_load_times' => (!empty($row[14])) ? $row[14] : null,
                'organization_latitude' => (!empty($row[15])) ? $row[15] : null,
                'organization_longitude' => (!empty($row[16])) ? $row[16] : null,
                'organization_short_description' => (!empty($row[17])) ? $row[17] : null,
                'organization_head_photo_file' => (!empty($row[18])) ? $row[18] : null,
                'organization_photos_files' => (!empty($row[20])) ? $row[20] : null,
                'organization_email' => (!empty($row[22])) ? $row[22] : null,
                'organization_facebook' => (!empty($row[23])) ? $row[23] : null,
                'organization_instagram' => (!empty($row[24])) ? $row[24] : null,
                'organization_twitter' => (!empty($row[25])) ? $row[25] : null,
                'organization_linkedin' => (!empty($row[26])) ? $row[26] : null,
                'organization_youTube' => (!empty($row[27])) ? $row[27] : null,
                'organization_yelp' => (!empty($row[29])) ? $row[29] : null,
                'organization_trip_advisor' => (!empty($row[30])) ? $row[30] : null,
                'organization_search_request' => (!empty($row[31])) ? $row[31] : null,
                'embed_map_code' => (!empty($row[34])) ? $row[34] : null,
                'organization_skype' => (!empty($row[35])) ? $row[35] : null,
                'organization_telegram' => (!empty($row[36])) ? $row[36] : null,
                'organization_phone_from_the_website' => (!empty($row[37])) ? $row[37] : null,
                'organization_tiktok' => (!empty($row[39])) ? $row[39] : null,
                'search_position_number_overall' => (!empty($row[41])) ? $row[41] : null
            ];

            Organization::updateOrCreate(
                ['organization_gmaps_id' => $row[3]],
                $organizationData
            );
        });
    }

//    public function collection(Collection $rows)
//    {
//        $chunkSize = 500; // Set your preferred chunk size
//
//        $rows->chunk($chunkSize)->each(function ($chunk) {
//            $recordsToUpdate = [];
//
//            $chunk->each(function ($row) use (&$recordsToUpdate) {
//                $org_city_id = $this->city_id; // Default city ID
//
//                if (!empty($row[8])) {
//                    $address = $row[8];
//                    $exploded_address = array_map('trim', explode(',', $address)); // Explode address parts and trim whitespaces
//                    if (isset($exploded_address[1])) {
//                        $org_city = City::where('name', Str::lower($exploded_address[1]))->where('state_id', $this->state_id)->first();
//                        if ($org_city) {
//                            $org_city_id = $org_city->id; // Assign city ID if found
//                        }
//                    }
//                }
//
//                $organizationData = [
//                    'organization_gmaps_id' => $row[3],
//                    'category_id' => 1,
//                    'state_id' => $this->state_id,
//                    'city_id' => $org_city_id,
//                    'gmaps_link' => (!empty($row[1])) ? $row[1] : null,
//                    'organization_name' => (!empty($row[2])) ? $row[2] : null,
//                    'organization_guid' => (!empty($row[38])) ? $row[38] : null,
//                    'rate_stars' => (!empty($row[4])) ? $row[4] : null,
//                    'reviews_total_count' => (!empty($row[5])) ? $row[5] : null,
//                    'price_policy' => (!empty($row[6])) ? $row[6] : null,
//                    'organization_category' => (!empty($row[7])) ? $row[7] : null,
//                    'organization_category_slug' => (!empty($row[7])) ? Str::slug($row[7]) : null,
//                    'organization_address' => (!empty($row[8])) ? $row[8] : null,
//                    'located_in' => (!empty($row[9])) ? $row[9] : null,
//                    'organization_website' => (!empty($row[10])) ? $row[10] : null,
//                    'organization_phone_number' => (!empty($row[11])) ? $row[11] : null,
//                    'organization_plus_code' => (!empty($row[12])) ? $row[12] : null,
//                    'organization_work_time' => (!empty($row[13])) ? $row[13] : null,
//                    'popular_load_times' => (!empty($row[14])) ? $row[14] : null,
//                    'organization_latitude' => (!empty($row[15])) ? $row[15] : null,
//                    'organization_longitude' => (!empty($row[16])) ? $row[16] : null,
//                    'organization_short_description' => (!empty($row[17])) ? $row[17] : null,
//                    'organization_head_photo_file' => (!empty($row[18])) ? $row[18] : null,
//                    'organization_photos_files' => (!empty($row[20])) ? $row[20] : null,
//                    'organization_email' => (!empty($row[22])) ? $row[22] : null,
//                    'organization_facebook' => (!empty($row[23])) ? $row[23] : null,
//                    'organization_instagram' => (!empty($row[24])) ? $row[24] : null,
//                    'organization_twitter' => (!empty($row[25])) ? $row[25] : null,
//                    'organization_linkedin' => (!empty($row[26])) ? $row[26] : null,
//                    'organization_youTube' => (!empty($row[27])) ? $row[27] : null,
//                    'organization_yelp' => (!empty($row[29])) ? $row[29] : null,
//                    'organization_trip_advisor' => (!empty($row[30])) ? $row[30] : null,
//                    'organization_search_request' => (!empty($row[31])) ? $row[31] : null,
//                    'embed_map_code' => (!empty($row[34])) ? $row[34] : null,
//                    'organization_skype' => (!empty($row[35])) ? $row[35] : null,
//                    'organization_telegram' => (!empty($row[36])) ? $row[36] : null,
//                    'organization_phone_from_the_website' => (!empty($row[37])) ? $row[37] : null,
//                    'organization_tiktok' => (!empty($row[39])) ? $row[39] : null,
//                    'search_position_number_overall' => (!empty($row[41])) ? $row[41] : null
//                ];
//
//                $recordsToUpdate[] = [
//                    'criteria' => ['organization_gmaps_id' => $row[3]],
//                    'data' => $organizationData
//                ];
//            });
//
//            foreach ($recordsToUpdate as $record) {
//                Organization::updateOrCreate($record['criteria'], $record['data']);
//            }
//        });
//    }

//    public function collection(Collection $rows)
//    {
//        foreach ($rows as $row) {
//
//            $org_city_id = $this->city_id; // Default city ID
//
//            if (!empty($row[8])) {
//                $address = $row[8];
//                $exploded_address = array_map('trim', explode(',', $address)); // Explode address parts and trim whitespaces
//                if (isset($exploded_address[1])) {
//                    $org_city = City::where('name', Str::lower($exploded_address[1]))->first();
//                    if ($org_city) {
//                        $org_city_id = $org_city->id; // Assign city ID if found
//                    }
//                }
//            }
//
//            Organization::updateOrCreate(
//                ['organization_gmaps_id' => $row[3],],
//                [
//                    'category_id' => 1,
//                    'state_id' => $this->state_id,
//                    'city_id' => $org_city_id,
//                    'gmaps_link' => (!empty($row[1])) ? $row[1] : null,
//                    'organization_name' => (!empty($row[2])) ? $row[2] : null,
//                    'organization_guid' => (!empty($row[38])) ? $row[38] : null,
//                    'rate_stars' => (!empty($row[4])) ? $row[4] : null,
//                    'reviews_total_count' => (!empty($row[5])) ? $row[5] : null,
//                    'price_policy' => (!empty($row[6])) ? $row[6] : null,
//                    'organization_category' => (!empty($row[7])) ? $row[7] : null,
//                    'organization_category_slug' => (!empty($row[7])) ? Str::slug($row[7]) : null,
//                    'organization_address' => (!empty($row[8])) ? $row[8] : null,
//                    'located_in' => (!empty($row[9])) ? $row[9] : null,
//                    'organization_website' => (!empty($row[10])) ? $row[10] : null,
//                    'organization_phone_number' => (!empty($row[11])) ? $row[11] : null,
//                    'organization_plus_code' => (!empty($row[12])) ? $row[12] : null,
//                    'organization_work_time' => (!empty($row[13])) ? $row[13] : null,
//                    'popular_load_times' => (!empty($row[14])) ? $row[14] : null,
//                    'organization_latitude' => (!empty($row[15])) ? $row[15] : null,
//                    'organization_longitude' => (!empty($row[16])) ? $row[16] : null,
//                    'organization_short_description' => (!empty($row[17])) ? $row[17] : null,
//                    'organization_head_photo_file' => (!empty($row[18])) ? $row[18] : null,
//                    'organization_photos_files' => (!empty($row[20])) ? $row[20] : null,
//                    'organization_email' => (!empty($row[22])) ? $row[22] : null,
//                    'organization_facebook' => (!empty($row[23])) ? $row[23] : null,
//                    'organization_instagram' => (!empty($row[24])) ? $row[24] : null,
//                    'organization_twitter' => (!empty($row[25])) ? $row[25] : null,
//                    'organization_linkedin' => (!empty($row[26])) ? $row[26] : null,
//                    'organization_youTube' => (!empty($row[27])) ? $row[27] : null,
//                    'organization_yelp' => (!empty($row[29])) ? $row[29] : null,
//                    'organization_trip_advisor' => (!empty($row[30])) ? $row[30] : null,
//                    'organization_search_request' => (!empty($row[31])) ? $row[31] : null,
//                    'embed_map_code' => (!empty($row[34])) ? $row[34] : null,
//                    'organization_skype' => (!empty($row[35])) ? $row[35] : null,
//                    'organization_telegram' => (!empty($row[36])) ? $row[36] : null,
//                    'organization_phone_from_the_website' => (!empty($row[37])) ? $row[37] : null,
//                    'organization_tiktok' => (!empty($row[39])) ? $row[39] : null,
//                    'search_position_number_overall' => (!empty($row[41])) ? $row[41] : null
//                ]);
//        }
//    }
}

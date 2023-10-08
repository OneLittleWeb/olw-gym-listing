<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::truncate();

        $states = [
            ['name' => 'alabama','slug' => 'alabama', 'is_major' => 0, 'background_image' => 'alabama.png'],
            ['name' => 'alaska','slug' => 'alaska', 'is_major' => 0, 'background_image' => 'alaska.png'],
            ['name' => 'arizona','slug' => 'arizona', 'is_major' => 0, 'background_image' => 'arizona.png'],
            ['name' => 'arkansas','slug' => 'arkansas', 'is_major' => 0, 'background_image' => 'arkansas.png'],
            ['name' => 'california','slug' => 'california', 'is_major' => 1, 'background_image' => 'california.png'],
            ['name' => 'colorado','slug' => 'colorado', 'is_major' => 0, 'background_image' => 'colorado.png'],
            ['name' => 'connecticut','slug' => 'connecticut', 'is_major' => 0, 'background_image' => 'connecticut.png'],
            ['name' => 'delaware','slug' => 'delaware', 'is_major' => 0, 'background_image' => 'delaware.png'],
            ['name' => 'district of columbia','slug' => 'district-of-columbia', 'is_major' => 0, 'background_image' => 'district-of-columbia.png'],
            ['name' => 'florida','slug' => 'florida', 'is_major' => 1, 'background_image' => 'florida.png'],
            ['name' => 'georgia','slug' => 'georgia', 'is_major' => 1, 'background_image' => 'georgia.png'],
            ['name' => 'hawaii','slug' => 'hawaii', 'is_major' => 0, 'background_image' => 'hawaii.png'],
            ['name' => 'idaho','slug' => 'idaho', 'is_major' => 0, 'background_image' => 'idaho.png'],
            ['name' => 'illinois','slug' => 'illinois', 'is_major' => 1, 'background_image' => 'illinois.png'],
            ['name' => 'indiana','slug' => 'indiana', 'is_major' => 0, 'background_image' => 'indiana.png'],
            ['name' => 'iowa','slug' => 'iowa', 'is_major' => 0, 'background_image' => 'iowa.png'],
            ['name' => 'kansas','slug' => 'kansas', 'is_major' => 0, 'background_image' => 'kansas.png'],
            ['name' => 'kentucky','slug' => 'kentucky', 'is_major' => 0, 'background_image' => 'kentucky.png'],
            ['name' => 'louisiana','slug' => 'louisiana', 'is_major' => 0, 'background_image' => 'louisiana.png'],
            ['name' => 'maine','slug' => 'maine', 'is_major' => 0, 'background_image' => 'maine.png'],
            ['name' => 'maryland','slug' => 'maryland', 'is_major' => 0, 'background_image' => 'maryland.png'],
            ['name' => 'massachusetts','slug' => 'massachusetts', 'is_major' => 0, 'background_image' => 'massachusetts.png'],
            ['name' => 'michigan','slug' => 'michigan', 'is_major' => 1, 'background_image' => 'michigan.png'],
            ['name' => 'minnesota','slug' => 'minnesota', 'is_major' => 0, 'background_image' => 'minnesota.png'],
            ['name' => 'mississippi','slug' => 'mississippi', 'is_major' => 0, 'background_image' => 'mississippi.png'],
            ['name' => 'missouri','slug' => 'missouri', 'is_major' => 0, 'background_image' => 'missouri.png'],
            ['name' => 'montana','slug' => 'montana', 'is_major' => 0, 'background_image' => 'montana.png'],
            ['name' => 'nebraska','slug' => 'nebraska', 'is_major' => 0, 'background_image' => 'nebraska.png'],
            ['name' => 'nevada','slug' => 'nevada', 'is_major' => 0, 'background_image' => 'nevada.png'],
            ['name' => 'new hampshire','slug' => 'new-hampshire', 'is_major' => 0, 'background_image' => 'new-hampshire.png'],
            ['name' => 'new jersey','slug' => 'new-jersey', 'is_major' => 0, 'background_image' => 'new-jersey.png'],
            ['name' => 'new mexico','slug' => 'new-mexico', 'is_major' => 0, 'background_image' => 'new-mexico.png'],
            ['name' => 'new york','slug' => 'new-york', 'is_major' => 1, 'background_image' => 'new-york.png'],
            ['name' => 'north carolina','slug' => 'north-carolina', 'is_major' => 1, 'background_image' => 'north-carolina.png'],
            ['name' => 'north dakota','slug' => 'north-dakota', 'is_major' => 0, 'background_image' => 'north-dakota.png'],
            ['name' => 'ohio','slug' => 'ohio', 'is_major' => 1, 'background_image' => 'ohio.png'],
            ['name' => 'oklahoma','slug' => 'oklahoma', 'is_major' => 0, 'background_image' => 'oklahoma.png'],
            ['name' => 'oregon','slug' => 'oregon', 'is_major' => 0, 'background_image' => 'oregon.png'],
            ['name' => 'pennsylvania','slug' => 'pennsylvania', 'is_major' => 1, 'background_image' => 'pennsylvania.png'],
            ['name' => 'rhode island','slug' => 'rhode-island', 'is_major' => 0, 'background_image' => 'rhode-island.png'],
            ['name' => 'south carolina','slug' => 'south-carolina', 'is_major' => 0, 'background_image' => 'south-carolina.png'],
            ['name' => 'south dakota','slug' => 'south-dakota', 'is_major' => 0, 'background_image' => 'south-dakota.png'],
            ['name' => 'tennessee','slug' => 'tennessee', 'is_major' => 0, 'background_image' => 'tennessee.png'],
            ['name' => 'texas','slug' => 'texas', 'is_major' => 1, 'background_image' => 'texas.png'],
            ['name' => 'utah','slug' => 'utah', 'is_major' => 0, 'background_image' => 'utah.png'],
            ['name' => 'vermont','slug' => 'vermont', 'is_major' => 0, 'background_image' => 'vermont.png'],
            ['name' => 'virginia','slug' => 'virginia', 'is_major' => 0, 'background_image' => 'virginia.png'],
            ['name' => 'washington','slug' => 'washington', 'is_major' => 0, 'background_image' => 'washington.png'],
            ['name' => 'west virginia','slug' => 'west-virginia', 'is_major' => 0, 'background_image' => 'west-virginia.png'],
            ['name' => 'wisconsin','slug' => 'wisconsin', 'is_major' => 0, 'background_image' => 'wisconsin.png'],
            ['name' => 'wyoming','slug' => 'wyoming', 'is_major' => 0, 'background_image' => 'wyoming.png'],
        ];
        foreach ($states as $city) {
            State::create($city);
        }
    }
}

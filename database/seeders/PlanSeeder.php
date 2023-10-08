<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::truncate();

        $includeBasic = [
            '1' => '1 User',
            '2' => 'Lifetime Availability',
            '3' => 'Business Hours',
            '4' => '1 Location',
            '5' => '1 Service',
            '6' => '1 Staff',
            '7' => '1 Appointment',
        ];
        $excludeBasic = [
            '1' => 'One Listing',
            '2' => 'No Online Booking',
            '3' => 'No Online Payments',
            '4' => 'No Online Reviews',
            '5' => 'No Online Marketing',
        ];

        Plan::create([
            'name' => 'Basic Plan',
            'slug' => 'basic-plan',
            'stripe_name' => 'Basic',
            'stripe_id' => 'price_1Mt9luDagRG4n09BEQgtwByo',
            'price' => 149,
            'abbreviation' => '/3 months',
            'included' => json_encode($includeBasic),
            'not_included' => json_encode($excludeBasic),
        ]);

        Plan::create([
            'name' => 'Professional Plan',
            'slug' => 'professional-plan',
            'stripe_name' => 'Professional',
            'stripe_id' => 'price_1Mv2KrDagRG4n09BW6lJq8qC',
            'price' => 299,
            'abbreviation' => '/6 months',
            'included' => json_encode($includeBasic),
            'not_included' => json_encode($excludeBasic),
        ]);

        Plan::create([
            'name' => 'Business Plan',
            'slug' => 'business-plan',
            'stripe_name' => 'Business',
            'stripe_id' => 'price_1Mv2LdDagRG4n09BFJX39PxO',
            'price' => 499,
            'abbreviation' => '/1 year',
            'included' => json_encode($includeBasic),
            'not_included' => json_encode($excludeBasic),
        ]);
    }
}

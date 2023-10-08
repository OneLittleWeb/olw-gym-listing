<?php

namespace Database\Seeders;

use App\Models\PaymentPlatform;
use Illuminate\Database\Seeder;

class PaymentPlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentPlatform::truncate();

        PaymentPlatform::create([
           'name' => 'PayPal',
            'image' => 'images/paypal.png'
        ]);
        PaymentPlatform::create([
           'name' => 'Stripe',
            'image' => 'images/stripe.png'
        ]);
    }
}

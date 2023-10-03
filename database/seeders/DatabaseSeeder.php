<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            CitySeeder::class,
            PaymentPlatformSeeder::class,
            CurrenciesSeeder::class,
            PlanSeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();
    }
}

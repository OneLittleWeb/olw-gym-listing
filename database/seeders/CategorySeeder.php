<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();

        $categories = [
            ['name' => 'beauty salons', 'icon' => 'fa-solid fa-spa', 'background' => 'bg-1', 'background_image' => 'omaha.jpg'],
            ['name' => 'car detailing', 'icon' => 'fa-solid fa-car-rear', 'background' => 'bg-2', 'background_image' => 'omaha.jpg'],
            ['name' => 'car rentals', 'icon' => 'fa-solid fa-car-side', 'background' => 'bg-3', 'background_image' => 'omaha.jpg'],
            ['name' => 'car wash', 'icon' => 'fa-solid fa-car', 'background' => 'bg-4', 'background_image' => 'omaha.jpg'],
            ['name' => 'daycares', 'icon' => 'fa-solid fa-building-user', 'background' => 'bg-5', 'background_image' => 'omaha.jpg'],
            ['name' => 'dentists', 'icon' => 'fa-solid fa-tooth', 'background' => 'bg-6', 'background_image' => 'omaha.jpg'],
            ['name' => 'dog grooming', 'icon' => 'fa-solid fa-dog', 'background' => 'bg-7', 'background_image' => 'omaha.jpg'],
            ['name' => 'dry cleaners', 'icon' => 'fa-solid fa-soap', 'background' => 'bg-8', 'background_image' => 'omaha.jpg'],
            ['name' => 'electricians', 'icon' => 'fa-solid fa-plug-circle-bolt', 'background' => 'bg-9', 'background_image' => 'omaha.jpg'],
            ['name' => 'gyms', 'icon' => 'fa-solid fa-dumbbell', 'background' => 'bg-10', 'background_image' => 'omaha.jpg'],
            ['name' => 'hair salons', 'icon' => 'fa-solid fa-spa', 'background' => 'bg-1', 'background_image' => 'omaha.jpg'],
            ['name' => 'hotels', 'icon' => 'fa-solid fa-hotel', 'background' => 'bg-2', 'background_image' => 'omaha.jpg'],
            ['name' => 'HVAC companies', 'icon' => 'fa-solid fa-building', 'background' => 'bg-3', 'background_image' => 'omaha.jpg'],
            ['name' => 'landscapers', 'icon' => 'fa-solid fa-landmark', 'background' => 'bg-4', 'background_image' => 'omaha.jpg'],
            ['name' => 'moving companies', 'icon' => 'fa-solid fa-building', 'background' => 'bg-5', 'background_image' => 'omaha.jpg'],
            ['name' => 'nail salons', 'icon' => 'fa-solid fa-spa', 'background' => 'bg-6', 'background_image' => 'omaha.jpg'],
            ['name' => 'pest control', 'icon' => 'fa-solid fa-bug', 'background' => 'bg-7', 'background_image' => 'omaha.jpg'],
            ['name' => 'pet stores', 'icon' => 'fa-solid fa-store', 'background' => 'bg-8', 'background_image' => 'omaha.jpg'],
            ['name' => 'physical therapists', 'icon' => 'fa-solid fa-user-nurse', 'background' => 'bg-9', 'background_image' => 'omaha.jpg'],
            ['name' => 'plumbers', 'icon' => 'fa-solid fa-wrench', 'background' => 'bg-10', 'background_image' => 'omaha.jpg'],
            ['name' => 'resorts', 'icon' => 'fa-solid fa-hotel', 'background' => 'bg-1', 'background_image' => 'omaha.jpg'],
            ['name' => 'restaurants', 'icon' => 'fa-solid fa-utensils', 'background' => 'bg-2', 'background_image' => 'omaha.jpg'],
            ['name' => 'towing', 'icon' => 'fa-solid fa-car-burst', 'background' => 'bg-8', 'background_image' => 'omaha.jpg'],
        ];
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

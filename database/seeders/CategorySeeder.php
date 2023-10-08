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
            ['name' => 'gyms', 'icon' => 'fa-solid fa-dumbbell', 'background' => 'bg-10', 'background_image' => 'omaha.jpg'],
        ];
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

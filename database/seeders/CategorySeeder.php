<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;





class CategorySeeder extends Seeder
{
    public function run()
    {
      $categories = [
            // Early Years
            ['name' => 'Creche', 'type' => 'early_years', 'sort_order' => 1],
            ['name' => 'Kindergarten 1', 'type' => 'early_years', 'sort_order' => 2],
            ['name' => 'Kindergarten 2', 'type' => 'early_years', 'sort_order' => 3],
            ['name' => 'Nursery 1', 'type' => 'early_years', 'sort_order' => 4],
            ['name' => 'Nursery 2', 'type' => 'early_years', 'sort_order' => 5],
            
            // Primary
            ['name' => 'Primary 1', 'type' => 'primary', 'sort_order' => 6],
            ['name' => 'Primary 2', 'type' => 'primary', 'sort_order' => 7],
            ['name' => 'Primary 3', 'type' => 'primary', 'sort_order' => 8],
            ['name' => 'Primary 4', 'type' => 'primary', 'sort_order' => 9],
            ['name' => 'Primary 5', 'type' => 'primary', 'sort_order' => 10],
            ['name' => 'Primary 6', 'type' => 'primary', 'sort_order' => 11],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
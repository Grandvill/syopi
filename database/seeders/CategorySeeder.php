<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'icon' => 'category/elektronik.webp',
                'childs' => ['Microwave', 'TV'],
            ],
            [
                'name' => 'Elektronik',
                'icon' => 'category/elektronik.webp',
                'childs' => ['Microwave', 'TV'],
            ]
        ];
    }
}

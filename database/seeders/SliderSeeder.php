<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            'dummy/banner 1.png',
            'dummy/banner 2.png',
            'dummy/banner 3.png',
            'dummy/banner 4.png',
        ];

        foreach ($sliders as $slider) {
          \App\Models\Slider::create([
            'image' => $slider
          ]);
        }
    }
}

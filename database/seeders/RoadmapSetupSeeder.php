<?php

namespace Database\Seeders;

use App\Models\RoadmapStep;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoadmapSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoadmapStep::create([
            'roadmap_id' => 1,
            'step_number'=>1,
            'title' => 'Introduction to Laravel',
            'description' => 'Learn the basics of Laravel, including installation and setup.',
            'resource_url' => 'https://laravel.com/docs/installation',
            'estimated_time_minutes' => 60
        ]);

        RoadmapStep::create([
            'roadmap_id' => 1,
            'step_number'=>2,
            'title' => 'how to setup   Laravel',
            'description' => 'Learn the basics of Laravel, including installation and setup.',
            'resource_url' => 'https://laravel.com/docs/installation',
            'estimated_time_minutes' => 120
        ]);
    }
}

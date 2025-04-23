<?php

namespace Database\Seeders;

use App\Models\Roadmap;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoadmapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Roadmap::create([
            'title' => 'Laravel Roadmap',
            'description' => 'A comprehensive roadmap for learning Laravel.',
            'language' => 'PHP',
            'difficulty_level' => 'Intermediate',
            'ai_generated' => false,
        ]);
    }
}

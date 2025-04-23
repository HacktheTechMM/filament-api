<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([RoadmapSeeder::class,
                            RoadmapSetupSeeder::class,
                            SubjectSeeder::class,]);
        // User::factory(10)->create();
        // $this->call([
        //     EmailTemplateSeeder::class,
        //     EmailTemplateThemeSeeder::class,
        // ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'role'=>User::ROLE_USER,
            'specialization'=>'laravel',
            'current_level'=>'junior',
            'tech_stack'=>'laravel,vuejs',
            'last_roadmap_id'=>1,
        ]);

        // User::factory()->create([
        //     'name' => 'Moe Wai Yan',
        //     'email' => 'moewaiyan@example.com',
        // ]);
    }
}

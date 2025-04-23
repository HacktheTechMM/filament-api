<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::create([
            'name'=>'laravel framework',
        ]);

        Subject::create([
            'name'=>'vuejs framework',
        ]);

        Subject::create([
            'name'=>'react framework',
        ]);

        Subject::create([
            'name'=>'angular framework',
        ]);

        Subject::create([
            'name'=>'flutter framework',
        ]);

        Subject::create([
            'name'=>'ionic framework',
        ]);

        Subject::create([
            'name'=>'react native framework',
        ]);
    }
}

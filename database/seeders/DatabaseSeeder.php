<?php

namespace Database\Seeders;

use App\Models\LearnerProfile;
use App\Models\MentorRequest;
use App\Models\User;
use App\Models\Subject;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\MentorProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([RoadmapSeeder::class,
                            RoadmapSetupSeeder::class,
                            ]);
        // User::factory(10)->create();
        // $this->call([
        //     EmailTemplateSeeder::class,
        //     EmailTemplateThemeSeeder::class,
        // ]);

       $mentor= User::factory()->create([
            'name' => 'Test User',
            'email' => 'waiyanwoody@gmail.com',
            'role'=>User::ROLE_MENTOR,
            'specialization'=>'laravel',
            'current_level'=>'intermediate',
            'tech_stack'=>'laravel,vuejs',
            'last_roadmap_id'=>1,
        ]);

        $mentor_second= User::factory()->create([
            'name' => 'Mentor User',
            'email' => 'mentora@gmail.com',
            'role'=>User::ROLE_MENTOR,
            'specialization'=>'laravel',
            'current_level'=>'intermediate',
            'tech_stack'=>'laravel,vuejs',
            'last_roadmap_id'=>1,
        ]);

        $mentor_third= User::factory()->create([
            'name' => 'Mentor User 2',
            'email' => 'mentor2@gmail.com',
            'role'=>User::ROLE_MENTOR,
            'specialization'=>'laravel',
            'current_level'=>'intermediate',
            'tech_stack'=>'laravel,vuejs',
            'last_roadmap_id'=>1,
        ]);

        $mentor_forth= User::factory()->create([
            'name' => 'Mentor User 3',
            'email' => 'mentor3@gmail.com',
            'role'=>User::ROLE_MENTOR,
            'specialization'=>'laravel',
            'current_level'=>'junior',
            'tech_stack'=>'laravel,vuejs',
            'last_roadmap_id'=>1,
        ]);

        MentorProfile::factory()->create([
            'user_id'=>$mentor->id,
            'bio'=>'I am a mentor',
            'experience'=>'I have 5 years of experience',
            'availability' => json_encode([
            [
                "date" => "2025-04-26",
                "time_slots" => [
                ["start_time" => "09:00:00", "end_time" => "17:00:00"]
                ]
            ],
            [
                "date" => "2025-04-30",
                "time_slots" => [
                ["start_time" => "09:00:00", "end_time" => "17:00:00"]
                ]
            ]
            ]),
        ]);
        MentorProfile::factory()->create([
            'user_id'=>$mentor_second->id,
            'bio'=>'I am a mentor',
            'experience'=>'I have 5 years of experience',
            'availability' => json_encode([
            [
                "date" => "2025-04-26",
                "time_slots" => [
                ["start_time" => "09:00:00", "end_time" => "17:00:00"]
                ]
            ],
            [
                "date" => "2025-04-30",
                "time_slots" => [
                ["start_time" => "09:00:00", "end_time" => "17:00:00"]
                ]
            ]
            ]),
        ]);
        MentorProfile::factory()->create([
            'user_id'=>$mentor_third->id,
            'bio'=>'I am a mentor',
            'experience'=>'I have 5 years of experience',
            'availability' => json_encode([
            [
                "date" => "2025-04-26",
                "time_slots" => [
                ["start_time" => "09:00:00", "end_time" => "17:00:00"]
                ]
            ],
            [
                "date" => "2025-04-30",
                "time_slots" => [
                ["start_time" => "09:00:00", "end_time" => "17:00:00"]
                ]
            ]
            ]),
        ]);
        MentorProfile::factory()->create([
            'user_id'=>$mentor_forth->id,
            'bio'=>'I am a mentor',
            'experience'=>'I have 5 years of experience',
            'availability' => json_encode([
            [
                "date" => "2025-04-26",
                "time_slots" => [
                ["start_time" => "09:00:00", "end_time" => "17:00:00"]
                ]
            ],
            [
                "date" => "2025-04-30",
                "time_slots" => [
                ["start_time" => "09:00:00", "end_time" => "17:00:00"]
                ]
            ]
            ]),
        ]);


        $subject1 = Subject::create(['name' => 'Laravel']);
        $subject2 = Subject::create(['name' => 'Vue.js']);

        $subject3 = Subject::create(['name' => 'React']);
        $subject4 = Subject::create(['name' => 'notejs']);
        $subject5 = Subject::create(['name' => 'Python']);
        $subject6 = Subject::create(['name' => 'Java']);
        $subject7 = Subject::create(['name' => 'C#']);
        $subject8 = Subject::create(['name' => 'C++']);

        DB::table('mentor_subjects')->insert([
            ['mentor_id' => $mentor->id, 'subject_id' => $subject1->id],
            ['mentor_id' => $mentor->id, 'subject_id' => $subject2->id],

            ['mentor_id' => $mentor_second->id, 'subject_id' => $subject3->id],
            ['mentor_id' => $mentor_second->id, 'subject_id' => $subject4->id],

            ['mentor_id' => $mentor_third->id, 'subject_id' => $subject5->id],
            ['mentor_id' => $mentor_third->id, 'subject_id' => $subject6->id],

            ['mentor_id' => $mentor_forth->id, 'subject_id' => $subject7->id],
            ['mentor_id' => $mentor_forth->id, 'subject_id' => $subject8->id],
        ]);









       $learner= User::factory()->create([
            'name' => 'Learner',
            'email' => 'wytun8904@gmail.com',
            'role'=>User::ROLE_LEARNER,
            'specialization'=>'laravel',
            'current_level'=>'junior',
            'tech_stack'=>'laravel,vuejs',
            'last_roadmap_id'=>1,
        ]);

      $learnerProfile=  LearnerProfile::create([
            'user_id'=>$learner->id,
            'age'=>20,
            'school_grade'=>'Grade 1',
            'guardian_contact'=>'0123456789',
            'learning_goals'=>'Learn Laravel',
            'special_needs'=>'None',
            'location'=>'Singapore',
      ]);

      $mentor_request=MentorRequest::create([
        'learner_id'=>$learnerProfile->id,
        'mentor_id'=>$mentor->id,
        'subject_id'=>$subject1->id,
        'message'=>'Hello',
        'requested_time' => 'Monday 10:00-12:00',
      ]);

      $mentor_request=MentorRequest::create([
        'learner_id'=>$learnerProfile->id,
        'mentor_id'=>$mentor_second->id,
        'subject_id'=>$subject2->id,
        'message'=>'Hello',
        'requested_time' => 'Tuesday 10:00-12:00',
      ]);






        // User::factory()->create([
        //     'name' => 'Moe Wai Yan',
        //     'email' => 'moewaiyan@example.com',
        // ]);
    }
}

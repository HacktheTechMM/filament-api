<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorProfile extends Model
{
    protected $guarded = [''];

    public function subjects(){
        return $this->belongsToMany(Subject::class, 'mentor_subjects', 'mentor_id', 'subject_id');
    }

    protected $casts = [
        'availability' => 'array',
    ];

}

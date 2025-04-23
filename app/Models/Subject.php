<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $guarded=[''];

    public function mentors(){
        return $this->belongsToMany(MentorProfile::class, 'mentor_subjects', 'subject_id', 'mentor_id');
    }
}

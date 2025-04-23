<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorProfile extends Model
{
    protected $guarded = [''];

    public function subjects(){
        return $this->belongsToMany(MentorProfile::class, 'mentor_subjects', 'mentor_id', 'subject_id');
    }
}

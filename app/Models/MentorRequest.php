<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorRequest extends Model
{
    protected $guarded=[''];

    public function subject(){
        return $this->belongsTo(Subject::class);
    }

    public function mentor(){
        return $this->belongsTo(MentorProfile::class);
    }

    public function learner(){
        return $this->belongsTo(LearnerProfile::class);
    }
}

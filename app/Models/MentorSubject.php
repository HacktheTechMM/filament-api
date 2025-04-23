<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorSubject extends Model
{
    protected $guarded=[''];

    public function subject()
    {
        return $this->belongsTo(Subject::class); // if many subjects
    }

    public function mentor(){
        return $this->belongsTo(MentorProfile::class);
    }
}

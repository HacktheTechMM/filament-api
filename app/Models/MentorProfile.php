<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentorProfile extends Model
{

    use HasFactory;
    protected $guarded = [''];

    public function subjects(){
        return $this->belongsToMany(Subject::class, 'mentor_subjects', 'mentor_id', 'subject_id');
    }

    // protected $casts = [
    //     'availability' => 'array',
    // ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}

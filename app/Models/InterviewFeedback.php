<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewFeedback extends Model
{
    protected $table = 'interview_feedback';

    protected $guarded = [];

    protected $casts = [
        'category_scores' => 'array',
        'strengths' => 'array',
        'areas_for_improvement' => 'array',
        'created_at' => 'datetime',
    ];
}

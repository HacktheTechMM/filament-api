<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{

    protected $table = 'interviews';

    protected $guarded = [];

    protected $casts = [
        'techstack' => 'array',
        'questions' => 'array',
        'finalized' => 'boolean',
        'created_at' => 'datetime',
    ];


}

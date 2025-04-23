<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LearnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'age'=>$this->age,
            'school_grade'=>$this->school_grade,
            'guardian_contact'=>$this->guardian_contact,
            'learning_goals'=>$this->learning_goals,
            'special_needs'=>$this->special_needs,
            'location'=>$this->location,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MentorSubjectResource extends JsonResource
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
            'mentor_id'=>$this->mentor_id,
            'subject_ids'=>$this->subject_ids,
            'subject'=>SubjectResource::make($this->subject),
            'mentor'=>MentorProfileResource::make($this->mentor),
        ];
    }
}

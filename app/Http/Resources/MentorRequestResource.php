<?php

namespace App\Http\Resources;

use App\Models\LearnerProfile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MentorRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'learner_id'=>$this->learner_id,
            'subject_id'=>$this->subject_id,
            'mentor_id'=>$this->mentor_id,
            'message'=>$this->message,
            'requested_time'=>$this->requested_time,
            'status'=>$this->status,
            'learner'=>LearnerProfileResource::make($this->learner),
            'mentor'=>MentorProfileResource::make($this->mentor),
            'subject'=>SubjectResource::make($this->subject)
        ];
    }
}

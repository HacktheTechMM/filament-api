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
            'id' => $this->id,
            'learner_id' => $this->learner_id,
            'learner_name' => $this->learner->user->name, // learner name
            'mentor_id' => $this->mentor_id,
            'mentor_name' => $this->mentor->user->name, // mentor name
            'subject_id' => $this->subject_id,
            'subject_name' => $this->subject->name, // subject name
            'message' => $this->message,
            'requested_time' => json_decode($this->requested_time), // convert JSON string to array
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

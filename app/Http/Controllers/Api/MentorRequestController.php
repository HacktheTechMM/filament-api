<?php

namespace App\Http\Controllers\Api;

use Mockery\Expectation;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Models\MentorProfile;
use App\Models\MentorRequest;
use App\Models\MentorSession;
use App\Models\MentorSubject;
use App\Models\LearnerProfile;
use App\Http\Controllers\Controller;
use App\Http\Resources\MentorRequestResource;

class MentorRequestController extends Controller
{
    use HttpResponse;
    public function create(Request $request)
    {
        try {
            $user = auth()->user();
            $learner = LearnerProfile::where('user_id', $user->id)->first();
            $mentor = MentorSubject::where('subject_id', $request->subject_id)->first();
            $request->merge([
                'learner_id' => $learner->id,
                'mentor_id' => $mentor->mentor_id,
            ]);
            $mentor_availability = MentorProfile::where('id', $request->mentor_id)->first();
            $mentor_availability_time = $mentor_availability->availability;
            $validator = $request->validate([
                'mentor_id' => 'required|exists:mentor_profiles,id',
                'subject_id' => 'required|exists:subjects,id',
                'learner_id' => 'required|exists:learner_profiles,id',
                'message' => 'nullable|string|max:255',
                'requested_time' => 'nullable|array',
            ]);
            $validator['requested_time'] = json_encode($mentor_availability_time);
            $mentor_request = MentorRequest::create($validator);

            $created_mentor_request = MentorRequest::where('id', $mentor_request->id)->with(['learner', 'mentor', 'subject'])->first();
            return response()->json([
                'message' => 'Mentor Subject Created Successfully',
                'data' => MentorRequestResource::make($created_mentor_request)
            ]);
        } catch (\Exception $e) {
            return $this->error('Something went wrong', $e->getMessage(), 500);
        }
    }

    public function accept($id, Request $request)
    {
        try {
            $mentor_request = MentorRequest::where('id', $id)->first();
            if ($mentor_request) {
                $mentor_request->update([
                    'status' => 'accepted',
                ]);

                $mentor_session = MentorSession::create([
                    'request_id' => $mentor_request->id,
                    'scheduled_time' => $mentor_request->requested_time,
                    'meeting_link' => $request->meeting_link,
                ]);


                return response()->json([
                    'message' => 'Mentor Request Accepted Successfully',
                    'data' => MentorRequestResource::make($mentor_request)
                ]);
            }
        } catch (\Exception $e) {
            return $this->error('Something went wrong', $e->getMessage(), 500);
        }
    }
}

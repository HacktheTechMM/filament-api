<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Mockery\Expectation;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Models\MentorProfile;
use App\Models\MentorRequest;
use App\Models\MentorSession;
use App\Models\MentorSubject;
use App\Models\LearnerProfile;
use App\Http\Services\ZoomService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
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
                'requested_time' => 'nullabel|string|max:255',
            ]);
            $validator['requested_time'] = $mentor_availability_time;
            $mentor_request = MentorRequest::create($validator);

            $created_mentor_request = MentorRequest::where('id', $mentor_request->id)->with(['learner', 'mentor', 'subject'])->first();
            return response()->json([
                'message' => 'Mentor Request Created Successfully',
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
                // Update the mentor request status to accepted
                $mentor_request->update([
                    'status' => 'accepted',
                ]);




                return response()->json([
                    'message' => 'Mentor Request Accepted Successfully',
                    'data' => $mentor_request,
                ]);
            }

            return response()->json(['message' => 'Mentor Request Not Found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }



    public function getMyMentorRequests(){
        try {
            $mentorRequests=MentorRequest::where('learner_id',auth()->user()->learnerProfile->id)->with(['mentor','subject'])->get();
            return response()->json([
                'message'=>'Mentor Requests',
                'data'=>MentorRequestResource::collection($mentorRequests)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message'=>'Something went wrong',
                'error'=>$e->getMessage()
            ],500);
        }
    }

    public function getMyAcceptedMentors(){
        try {
            $mentorRequests=MentorRequest::where('learner_id',auth()->user()->learnerProfile->id)->where('status','accepted')->with(['mentor','subject'])->get();
            return response()->json([
                'message'=>'Mentor Requests',
                'data'=>MentorRequestResource::collection($mentorRequests)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message'=>'Something went wrong',
                'error'=>$e->getMessage()
            ],500);
        }
    }

    public function getMentorLearnerRequests(){
        try {
            $mentorRequests=MentorRequest::where('mentor_id',auth()->user()->mentorProfile->id)->with(['learner','subject'])->get();
            return response()->json([
                'message'=>'Mentor Requests',
                'data'=>MentorRequestResource::collection($mentorRequests)
            ]);
        } catch (\Exception $eh) {
            return response()->json([
                'message'=>'Something went wrong',
                'error'=>$eh->getMessage()
            ],500);

        }
    }

}

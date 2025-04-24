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

    // protected $zoomService;

    // public function __construct(ZoomService $zoomService)
    // {
    //     $this->zoomService = $zoomService;
    // }

    public function accept($id, Request $request)
    {
        try {
            $mentor_request = MentorRequest::where('id', $id)->first();

            if ($mentor_request) {
                // Update the mentor request status to accepted
                $mentor_request->update([
                    'status' => 'accepted',
                ]);


                // // Create the Zoom meeting link
                // $meeting_link = $this->zoomService->createMeeting(
                //     'Mentorship Session - ' . $mentor_request->mentor->name,
                //  Carbon::now()->format('Y-m-d\TH:i:s')

                //     // Carbon::parse($mentor_request->requested_time)->toDateTimeLocalString()

                // );

                // // Create the mentor session with the meeting link
                // $mentor_session = MentorSession::create([
                //     'request_id' => $mentor_request->id,
                //     'scheduled_time' => $mentor_request->requested_time,
                //     'meeting_link' => $meeting_link,
                // ]);

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

    // private function createMeeting()
    // {
    //     $accessToken = 'eyJzdiI6IjAwMDAwMiIsImFsZyI6IkhTNTEyIiwidiI6IjIuMCIsImtpZCI6Ijg2ZjczNGVkLWVkZjItNDhjNi05ODZhLTQzZWE0YzVlOTUwZiJ9.eyJhdWQiOiJodHRwczovL29hdXRoLnpvb20udXMiLCJ1aWQiOiIyYTJkMHFQSVF6RzFBb2JHdTJRMlV3IiwidmVyIjoxMCwiYXVpZCI6IjI4N2I3ZmQxOWMzMmY4NzNlMjI4NzgyY2QwMWUzMTI2MjhiM2ExZjAzY2ZmMzMyZmU5ZjQ1NWFkNDc5ODQyOWQiLCJuYmYiOjE3NDU0ODQ4OTgsImNvZGUiOiJEWHFNT3J5a2V0Q2w4dnowTmRPUXk2X1E3ejl2Sy1PclEiLCJpc3MiOiJ6bTpjaWQ6RHMwRHZmX21SM0dpMVRsVjFkeV9ZQSIsImdubyI6MCwiZXhwIjoxNzQ1NDg4NDk4LCJ0eXBlIjowLCJpYXQiOjE3NDU0ODQ4OTgsImFpZCI6ImNfRl9mVnBHVHdTS2RtMjF0b3pIQ2cifQ.YJaMxC624dtDph1CCTrXogG1HJGXH_KeqJqyrf2rolYG0RNH0y7ImEvZIXcalpV7VpVrhNAGd3M29_6cGeECbg'; // Get token from session

    //     // Make API request to create a Zoom meeting
    //     $response = Http::withToken(token: $accessToken)->post("https://api.zoom.us/v2/users/me/meetings", [
    //         'topic' => 'Laravel Zoom Meeting', // Meeting topic
    //         'type' => 2, // Type 2 means scheduled meeting
    //         'start_time' => now()->addHour()->toIso8601String(), // Meeting start time (1 hour from now)
    //         'duration' => 30, // Meeting duration in minutes
    //         'timezone' => 'Asia/Yangon',
    //         'settings' => [
    //             'join_before_host' => true,
    //             'waiting_room' => false,
    //         ],
    //     ]);



    //     // Get meeting details from the API response
    //     $data = $response->json();
    //     $joinUrl = $data['join_url'];
    //     $startUrl = $data['start_url'];
    //     $startTime = $data['start_time'];

    //     return $joinUrl;
    // }

}

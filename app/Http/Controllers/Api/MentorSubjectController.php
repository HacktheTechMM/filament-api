<?php

namespace App\Http\Controllers\Api;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Models\MentorProfile;
use App\Models\MentorSubject;
use App\Http\Controllers\Controller;
use App\Http\Resources\MentorSubjectResource;

class MentorSubjectController extends Controller
{

    use HttpResponse;
    public function create(Request $request){
        try {
            $user=auth()->user();
            $mentor=MentorProfile::where('user_id',$user->id)->first();
            $request->merge(['mentor_id' =>$mentor->id]);
          $request->validate([
                'mentor_id' => 'required|exists:mentor_profiles,id',
                'subject_ids' => 'required|array',
                'subject_ids.*' => 'exists:subjects,id',
            ]);

            $mentor_subject=$mentor->subjects()->sync($request->subject_ids);
            $mentor_subject=MentorSubject::where('mentor_id',$mentor->id)->get();
            return response()->json([
                'message' => 'Mentor Subject Created Successfully',
                'data'=>MentorSubjectResource::collection($mentor_subject)
            ]);
        // return $this->success('Mentor Subject Created Successfully',['mentor_subject'=>MentorSubjectResource::collection($mentor_subject)],201);
        } catch (\Exception $e) {
           return $this->error('Something went wrong', $e->getMessage(), 500);
        }
    }
}

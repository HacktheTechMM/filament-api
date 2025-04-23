<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InterviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'interviewId' => 'required',
            'createdAt' => 'required|date',
            'finalized' => 'required|boolean',
            'level' => 'required|string',
            'role' => 'required|string',
            'techstack' => 'required|array',
            'type' => 'required|string',
            'questions' => 'required|array',
        ])->validate();

        $interview = Interview::create([
            'interview_id' => $validated['interviewId'],
            'user_id' => auth()->id(),
            'created_at' => $validated['createdAt'],
            'finalized' => $validated['finalized'],
            'level' => $validated['level'],
            'role' => $validated['role'],
            'techstack' => $validated['techstack'],
            'type' => $validated['type'],
            'questions' => $validated['questions'],
        ]);

        return response()->json([
            'message' => 'Interview created successfully.',
            'data' => $interview
        ], 201);
    }

    // Get one interview by ID
    public function show($id)
    {
        $interview = Interview::where('interview_id',$id)->first();

        return response()->json([
            'data' => $interview
        ]);
    }

    // Optional: Get all interviews for a user
    public function getByUser($userId)
    {
        $interviews = Interview::where('user_id', $userId)->get();

        return response()->json([
            'data' => $interviews
        ]);
    }
}

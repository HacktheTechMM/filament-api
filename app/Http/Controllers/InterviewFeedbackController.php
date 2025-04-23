<?php

namespace App\Http\Controllers;

use App\Models\InterviewFeedback;
use Illuminate\Http\Request;

class InterviewFeedbackController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'interviewId' => 'required',
            'totalScore' => 'required|integer',
            'categoryScores' => 'required|array',
            'categoryScores.*.name' => 'required|string',
            'categoryScores.*.score' => 'required|integer',
            'categoryScores.*.comment' => 'required|string',
            'strengths' => 'required|array',
            'areasForImprovement' => 'required|array',
            'finalAssessment' => 'required|string',
            'createdAt' => 'required|date',
        ]);

        $feedback = InterviewFeedback::create([
            'interview_id' => $data['interviewId'],
            'user_id' => auth()->id(),
            'total_score' => $data['totalScore'],
            'category_scores' => $data['categoryScores'],
            'strengths' => $data['strengths'],
            'areas_for_improvement' => $data['areasForImprovement'],
            'final_assessment' => $data['finalAssessment'],
            'created_at' => $data['createdAt'],
        ]);

        return response()->json(['message' => 'Interview Feedback saved', 'data' => $feedback], 201);
    }
}

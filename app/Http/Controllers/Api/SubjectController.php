<?php

namespace App\Http\Controllers\Api;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectResource;

class SubjectController extends Controller
{
    public function index(){
        $subjects=Subject::all();
        return response()->json([
            'message'=>'Subjects retrieved successfully',
            'data'=>SubjectResource::collection($subjects)
        ]);
    }

    public function show($id){
        $subject=Subject::findOrFail($id);
        return response()->json([
            'message'=>'Subject show successfully',
            'data'=>SubjectResource::make($subject)
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
        ]);
        $subject=Subject::create([
            'name'=>request('name'),
        ]);
        return response()->json([
            'message'=>'Subject created successfully',
            'data'=>SubjectResource::make($subject)
        ]);
    }
}

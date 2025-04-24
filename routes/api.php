<?php

use App\Http\Controllers\Api\SubjectController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\UserResource;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\MentorRequestController;
use App\Http\Controllers\Api\MentorSubjectController;
use App\Http\Controllers\InterviewFeedbackController;


Route::get("v1/auth/me", function () {
    $user = Auth::user();
    return response()->json([
        'data' =>[
           'user'=> UserResource::make($user)
        ],
    ]);
})->middleware(['auth:sanctum']);

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('signin', [AuthController::class, 'login'])->name('api.login');
        Route::post('register', [AuthController::class, 'register'])->name('api.register');
    });

    Route::prefix('users')->middleware('auth:sanctum')->group(function () {
        Route::get('/{id}/', [UserController::class, 'getUser'])->name('user.show');
        Route::put('update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::post('upload-image', [UserController::class, 'uploadImage'])->name('user.upload-image');
        Route::post('upgrade', [UserController::class, 'upgrade'])->name('user.upgrade');


        // Optional: Get all interviews by user
        Route::get('{userId}/interviews', [InterviewController::class, 'getByUser']);


    });

    Route::get('get-mentors',[UserController::class,'getMentors']);




    Route::get('subjects',[SubjectController::class,'index'])->name('subjects.index');
    Route::post('subjects',[SubjectController::class,'store'])->name('subjects.store')->middleware('auth:sanctum');
    Route::get('subjects/{id}',[SubjectController::class,'show'])->name('subjects.show');

    //for interview
    Route::prefix('interviews')->middleware('auth:sanctum')->group(function () {
        Route::post('/', [InterviewController::class, 'store'])->name('interview.store');
        // Get interview by ID
        Route::get('/{id}', [InterviewController::class, 'show']);

        //interview feedbacks
        Route::post('/feedbacks', [InterviewFeedbackController::class, 'store']);
    });

    Route::get('/feedbacks/interviews/{interviewId}', [InterviewFeedbackController::class, 'getByInterview']);

    Route::post('mentor-subject',[MentorSubjectController::class,'create'])->name('mentor-subject.create')->middleware('auth:sanctum');
    Route::post('mentor-request',[MentorRequestController::class,'create'])->name('mentor-request.create')->middleware('auth:sanctum');
    Route::patch('mentor-request/accept/{id}',[MentorRequestController::class, 'accept'])->name('mentor-request.accept')->middleware('auth:sanctum');




});

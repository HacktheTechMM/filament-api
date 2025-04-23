<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\InterviewFeedbackController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function(){
    Route::prefix('auth')->group(function(){
        Route::post('signin',[AuthController::class,'login'])->name('api.login');
        Route::post('register',[AuthController::class,'register'])->name('api.register');
    });

    Route::prefix('users')->middleware('auth:sanctum')->group(function(){
        Route::get('/{id}/',[UserController::class,'getUser'])->name('user.show');
        Route::put('update/{id}',[UserController::class,'update'])->name('user.update');
        Route::post('upload-image',[UserController::class,'uploadImage'])->name('user.upload-image');

        // Optional: Get all interviews by user
        Route::get('{userId}/interviews', [InterviewController::class, 'getByUser']);
    });

    //for interview
    Route::prefix('interviews')->middleware('auth:sanctum')->group(function(){
        Route::post('/',[InterviewController::class,'store'])->name('interview.store');
        // Get interview by ID
        Route::get('/{id}', [InterviewController::class, 'show']);

        //interview feedbacks
        Route::post('/feedbacks', [InterviewFeedbackController::class, 'store']);

    });

    Route::get('/feedbacks/interviews/{interviewId}', [InterviewFeedbackController::class, 'getByInterview']);
});




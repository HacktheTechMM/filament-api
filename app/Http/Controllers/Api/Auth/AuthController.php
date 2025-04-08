<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Traits\HttpResponse;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    use HttpResponse;
    public function register(RegisterRequest $request){
        try {
            $validatedData=$request->validated();
               $user= User::create([
                    'name'=>$validatedData['name'],
                    'email'=>$validatedData['email'],
                    'password'=>bcrypt($validatedData['password']),
                ]);

               $token= $user->createToken('auth_token')->plainTextToken;
                return $this->success('User registered successfully',['user'=>UserResource::make($user),'token'=>$token],true,201);
        } catch (Exception $e) {
            return $this->error($e->getMessage(),[],false,500);
        }
    }

    public function login(LoginRequest $request){
        try {
            $validatedData=$request->validated();

            $user= User::where('email',$validatedData['email'])->first();

            if(!$user || !password_verify($validatedData['password'], $user->password)){
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid credentials',
                ],401);
            }

            $token= $user->createToken('auth_token')->plainTextToken;

            return $this->success('User logged in successfully',['user'=>UserResource::make($user),'token'=>$token],true,200);
        } catch (Exception $e) {
            return $this->error($e->getMessage(),[],false,500);
        }
    }
}

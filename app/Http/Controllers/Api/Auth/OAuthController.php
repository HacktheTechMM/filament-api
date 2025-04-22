<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Role;

use App\Models\User;
use Illuminate\Support\Str;
use App\Mail\OAuthPasswordMail;
use App\Notifications\UserLogin;
use App\Permissions\V1\Abilities;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Notification;

class OAuthController extends Controller
{
    public function generatePassword()
    {
        $prefix = 'CS-';
        $spc = '!@#$%&*():?';
        $password = $prefix . Str::random(4) . $spc[rand(0, strlen($spc) - 1)] . rand(0, 999) . $spc[rand(0, strlen($spc) - 1)];

        // example password : CC-HM9e?947%
        return $password;
    }

    // Function to generate a unique username
    private function generateUniqueUsername($baseName)
    {
        $username = Str::slug($baseName, '_'); // Convert base name to a slug (e.g., 'John Doe' -> 'john_doe')
        $counter = 1;

        // Check if the username already exists and append a counter if needed
        while (User::where('username', $username)->exists()) {
            $username = Str::slug($baseName, '_') . '_' . $counter;
            $counter++;
        }

        return $username;
    }

    //
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            $existingUser = User::where('email', operator: $socialUser->email)->first();

            if ($existingUser && $existingUser->provider !== $provider) {
                return redirect(env('FRONTEND_URL') . '/socialite-callback/error?message=This email is already used by different method to login.');
            }

            $user = User::where([
                'provider' => $provider,
                'provider_id' => $socialUser->id,
            ])->first();

            if (!$user) {
                // // Generate a unique username
                // $username = $this->generateUniqueUsername($socialUser->name);
                $generated_password = $this->generatePassword();

                $user = User::create([
                    'name' => $socialUser->name,
                    'email' => $socialUser->email,
                    'password' =>Hash::make($generated_password),
                    'provider_token' => $socialUser->token,
                    // 'provider_refresh_token' => $socialUser->refreshToken,
                    'provider_avatar' => $socialUser->avatar,
                    'provider_id' => $socialUser->id,
                    'provider' => $provider,
                    'email_verified_at' => now()
                ]);

                //send generated email to user
               if($user->email){
                    $receiverEmail = $user->email;
                    Mail::to($receiverEmail)->queue(
                        new OAuthPasswordMail($generated_password),
                    );
               }
            }

            Notification::route('slack', env('SLACK_AUTH_WEBHOOK_URL'))
            ->notify(new UserLogin('Login Alert : ' . ($user->email ?? $user->name) . ' has logged in.' .'(via '.$provider . ')'));

            // Create a personal access token
            $token = $user->createToken('auth_token')->plainTextToken;

            // Include the user ID and token in the redirect URL
            $redirectUrl = env('FRONTEND_URL') . '/socialite-callback/' . $user->id . '?token=' . $token;

            return redirect($redirectUrl);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
            // return redirect(env('FRONTEND_URL') . '/socialite-callback/error');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZoomController extends Controller
{
    public function authorizeZoom()
    {
        $url = 'https://zoom.us/oauth/authorize?' . http_build_query([
            'response_type' => 'code',
            'client_id' => env('ZOOM_CLIENT_ID'),
            'redirect_uri' => env('ZOOM_REDIRECT_URI'),
        ]);

        return redirect($url);
    }

    public function handleCallback(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode(env('ZOOM_CLIENT_ID') . ':' . env('ZOOM_CLIENT_SECRET')),
        ])->asForm()->post('https://zoom.us/oauth/token', [
            'grant_type' => 'authorization_code',
            'code' => $request->code,
            'redirect_uri' => env('ZOOM_REDIRECT_URI'),
        ]);

        $data = $response->json();

        session(['zoom_access_token' => $data['access_token']]);
        return response()->json($data['access_token'], 200, );

        // return redirect('/zoom/meeting/create');
    }

    private function createMeeting()
    {
        $accessToken = session('zoom_access_token'); // Get token from session

        // Make API request to create a Zoom meeting
        $response = Http::withToken(token: $accessToken)->post("https://api.zoom.us/v2/users/me/meetings", [
            'topic' => 'Laravel Zoom Meeting', // Meeting topic
            'type' => 2, // Type 2 means scheduled meeting
            'start_time' => now()->addHour()->toIso8601String(), // Meeting start time (1 hour from now)
            'duration' => 30, // Meeting duration in minutes
            'timezone' => 'Asia/Yangon',
            'settings' => [
                'join_before_host' => true,
                'waiting_room' => false,
            ],
        ]);



        // Get meeting details from the API response
        $data = $response->json();
        $joinUrl = $data['join_url'];
        $startUrl = $data['start_url'];
        $startTime = $data['start_time'];

        return $joinUrl;
    }


}

<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class ZoomService
{
    protected $client;
    protected $access_token;

    public function __construct()
    {
        // You can store the access token in your cache or database and refresh it when needed
        $this->access_token = $this->getAccessToken();
        $this->client = new Client([
            'base_uri' => 'https://api.zoom.us/v2/',
        ]);
    }

    // Get access token (ensure it's valid)
    public function getAccessToken()
    {
        if (!cache()->has('zoom_access_token')) {
            $this->refreshAccessToken();
        }

        return cache('zoom_access_token');
    }

    public function createMeeting($topic, $start_time, $duration = 30)
    {
        try {
            $response = $this->client->post('users/me/meetings', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->access_token,
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'topic' => $topic,
                    'type' => 2, // Scheduled meeting type
                    'start_time' => $start_time, // Format: Y-m-d\TH:i:s
                    'duration' => $duration, // Duration in minutes
                    'timezone' => 'Asia/Yangon',
                    'password' => '123456', // Set meeting password if needed
                    'settings' => [
                        'join_before_host' => true,
                        'mute_upon_entry' => true,
                        'waiting_room' => false,
                    ],
                ],
            ]);

            $meeting = json_decode($response->getBody()->getContents(), true);
            return $meeting['join_url']; // Zoom join URL
        } catch (\Exception $e) {
            throw new \Exception('Error creating Zoom meeting: ' . $e->getMessage());
        }
    }

    // Call this method to refresh the access token when expired.
    public function refreshAccessToken()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode(
                config('services.zoom.client_id') . ':' . config('services.zoom.client_secret')
            ),
        ])->asForm()->post('https://zoom.us/oauth/token', [
            'grant_type' => 'account_credentials',
            'account_id' => config('services.zoom.account_id'),
        ]);

        if ($response->failed()) {
            throw new \Exception('Failed to get Zoom access token: ' . $response->body());
        }

        $data = $response->json();

        // Save the access token in cache for later use
        cache(['zoom_access_token' => $data['access_token']], $data['expires_in'] - 60);
    }

}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ZegoService
{
    protected $appId;
    protected $serverSecret;

    public function __construct()
    {
        $this->appId = config('services.zego.app_id');
        $this->serverSecret = config('services.zego.server_secret');
    }

    public function generateMeetingLink($roomID, $userName)
    {
        $userID = uniqid(); // unique per user

        // Generate token (JWT)
        $token = $this->generateToken($userID);

        // You can define the UI kit URL pattern based on ZegoCloud documentation
        $link = "http://localhost:3000/meeting?app_id={$this->appId}&room_id={$roomID}&user_id={$userID}&user_name={$userName}&token={$token}";

        return [
            'link' => $link,
            'room_id' => $roomID,
            'user_id' => $userID,
            'user_name' => $userName,
        ];
    }

    private function generateToken($userID)
    {
        $appID = (int) $this->appId;
        $serverSecret = $this->serverSecret;
        $effectiveTimeInSeconds = 3600; // 1 hour

        $payload = [
            'app_id' => $appID,
            'user_id' => $userID,
            'nonce' => random_int(100000, 999999),
            'ctime' => time(),
            'expire' => $effectiveTimeInSeconds,
        ];

        $payloadStr = json_encode($payload);
        $hash = hash_hmac('sha256', $payloadStr, $serverSecret, true);
        $token = base64_encode($payloadStr . $hash);

        return $token;
    }
}

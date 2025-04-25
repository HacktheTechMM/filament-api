<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\ZegoService;

class ZegoController extends Controller
{
    public function generate(Request $request, ZegoService $zegoService)
    {
        $meetingId = Str::uuid();
        // $hostEmail = $request->host_email;
        // $guestEmail = $request->guest_email;

        $link = "http://localhost:3000/meeting/{$meetingId}";

        // Store meeting info (optional)

        // Mail::to($hostEmail)->send(new MeetingInvite($link));
        // Mail::to($guestEmail)->send(new MeetingInvite($link));

        return response()->json(['meeting_link' => $link]);
    }
}

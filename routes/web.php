<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZoomController;
use Filament\Notifications\Notification;
use Illuminate\Console\Scheduling\Event;
use Filament\Notifications\Actions\Action;
use App\Http\Controllers\Api\Auth\OAuthController;
use App\Mail\Visualbuilder\EmailTemplates\UserWelcome;
use Filament\Notifications\Events\DatabaseNotificationsSent;

// routes/web.php

Route::get('/zoom/authorize', [ZoomController::class, 'authorizeZoom']);
Route::get('/zoom/callback', [ZoomController::class, 'handleCallback']);
Route::get('/zoom/meeting/create', [ZoomController::class, 'createMeeting']);



Route::get('/', function () {
    return redirect()->route('filament.admin.auth.login');
});

//for socialite login
Route::get('/auth/{provider}/redirect', [OAuthController::class, 'redirect']);

Route::get('/auth/{provider}/callback', [OAuthController::class, 'callback']);

// for email verification
// Route::get('/email/verify', function () {
//     return view('auth.verify-email');
// })->middleware(['auth'])->name('verification.notice');

Route::get('/send-welcome-email', function () {
    $user = User::find(1); // Replace with the appropriate user ID or logic to fetch the user

    Mail::to($user)->queue(
        new UserWelcome($user)
    );

    dd('Welcome email sent successfully');
});

Route::get('/test-notification/{message}', function ($message) {
    $recipient = User::find(1);

    Notification::make()
        ->title('New Alert') // main title
        ->body($message) // use the message from the URL
        ->icon('heroicon-o-bell') // optional icon
        ->color('info') // success, danger, warning, info, gray
        ->actions([
            Action::make('View')
            ->button()
            ->url(route('filament.admin.pages.dashboard')) // any route or external URL
        ])
        ->sendToDatabase($recipient);

    // Optional: trigger notification update broadcast
    event(new DatabaseNotificationsSent($recipient));

    dd('Notification sent successfully');
});

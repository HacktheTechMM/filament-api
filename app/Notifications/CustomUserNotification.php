<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class CustomUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public string $type;
    public string $title;
    public string $body;
    public ?string $url;
    public function __construct($type = 'info', $title, $body, $url = null)
    {
        $this->type = $type;
        $this->title = $title;
        $this->body = $body;
        $this->url = $url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'color' => $this->type, // 'info', 'success', 'danger', etc.
            'icon' => 'heroicon-o-bell',
            'actions' => $this->url ? [
                [
                    'name' => 'View',
                    'label' => 'View',
                    'url' => $this->url,
                    'view' => 'filament-actions::button-action',
                    'size' => 'sm',
                    "isOutlined" => false,
                    "isDisabled" => false,
                    "shouldClose" => false,
                    "shouldMarkAsRead" => false,
                    "shouldMarkAsUnread" => false,
                    "shouldOpenUrlInNewTab" => false,
                    'shouldOpenUrlInNewTab' => true,
                    "tooltip" => null
                ],
            ] : [],
            'format' => 'filament',
            "duration" => "persistent"
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'color' => $this->type, // 'info', 'success', 'danger', etc.
            'icon' => 'heroicon-o-bell',
            'actions' => $this->url ? [
                [
                    'name' => 'View',
                    'label' => 'View',
                    'url' => $this->url,
                    'view' => 'filament-actions::button-action',
                    'size' => 'sm',
                    "isOutlined" => false,
                    "isDisabled" => false,
                    "shouldClose" => false,
                    "shouldMarkAsRead" => false,
                    "shouldMarkAsUnread" => false,
                    "shouldOpenUrlInNewTab" => false,
                    'shouldOpenUrlInNewTab' => true,
                    "tooltip" => null
                ],
            ] : [],
            'format' => 'filament',
            "duration" => "persistent"
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'data' => $this->toArray($notifiable),
        ]);
    }
}

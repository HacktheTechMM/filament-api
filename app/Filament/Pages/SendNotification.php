<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Pages\Page;
use Filament\Facades\Filament;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CustomUserNotification;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Notifications\Notification as FilamentNotification;

class SendNotification extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-bell';
    protected static string $view = 'filament.pages.send-notification';
    protected static ?string $navigationLabel = 'Send Notification';

    public ?array $formData = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('title')
                ->required()
                ->label('Notification Title'),

            Textarea::make('body')
                ->required()
                ->label('Message'),

            TextInput::make('url')
                ->label('Optional URL')
                ->placeholder('/dashboard'),

            Select::make('type')
                ->label('Notification Type')
                ->options([
                    'info' => 'Info',
                    'success' => 'Success',
                    'warning' => 'Warning',
                    'error' => 'Error',
                ])
                ->default('info'),

            Select::make('users')
                ->label('Select Users')
                ->multiple()
                ->required()
                ->searchable()
                ->options(User::pluck('name', 'id')),
        ];
    }

    protected function getFormModel(): string
    {
        return '';
    }

    protected function getFormStatePath(): string
    {
        return 'formData'; // ✅ Form will bind to $formData
    }

    public function send(): void
    {
        $data = $this->form->getState();

        $users = User::whereIn('id', $data['users'])->get();

        Notification::send($users, new CustomUserNotification(
            type: $data['type'],
            title: $data['title'],
            body: $data['body'],
            url: $data['url'] ?? ''
        ));

        FilamentNotification::make()
            ->success()
            ->title('Notification Sent')
            ->body('Your message was queued to be sent to selected users.')
            ->send();

        foreach ($users as $user) {
            event(new \Filament\Notifications\Events\DatabaseNotificationsSent($user));
        }

        $this->form->fill(); // Reset form
    }
}

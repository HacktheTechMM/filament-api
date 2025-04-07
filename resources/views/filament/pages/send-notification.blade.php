<x-filament::page>
    {{ $this->form }}

    <x-filament::button wire:click="send" class="mt-4">
        Send Notification
    </x-filament::button>
</x-filament::page>

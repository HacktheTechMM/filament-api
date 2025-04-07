<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class Sample extends Component
{
    public function render()
    {
        return view('livewire.sample');
    }

    #[On('echo:publicChannel,Test')]
    public function dump()
    {
        dd('Event received');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;

class FlashComponent extends Component
{

    public function flash(){
    session()->flash('message', 'I am clicked the button ');

    }
    public function render()
    {
        return view('livewire.flash-component');
    }
}

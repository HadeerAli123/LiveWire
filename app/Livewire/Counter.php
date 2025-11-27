<?php

namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 0;
    
public $active =true;
    public function increment($param)
    {
        $this->count++;
        
        
        // dd('the parameter  you provieded is '.$param);
    }

    public function decrement()
    {
        $this->count--;
    }

    public function render()
    {
        return view('livewire.counter');
    }
}
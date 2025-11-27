<?php

namespace App\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Http;

class FetchComponent extends Component
{

    public function fetch(){
$data = Http::get('http://127.0.0.1:8000/api/all_ads')->body();
dd([$data]);
    }
    public function render()
    {
        return view('livewire.fetch-component');
    }
}

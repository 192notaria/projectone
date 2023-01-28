<?php

namespace App\Http\Livewire;

use App\Models\Interphone;

use Livewire\Component;

class Intercomunicador extends Component
{
    public $intercomunicadores = [];
    public function render()
    {
        return view('livewire.intercomunicador', [
            $this->intercomunicadores = Interphone::where("to", auth()->user()->id)->get()
        ]);
    }
}

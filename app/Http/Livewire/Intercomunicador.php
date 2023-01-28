<?php

namespace App\Http\Livewire;

use App\Models\Interphone;

use Livewire\Component;

class Intercomunicador extends Component
{
    public $intercomunicadores = [];

    // newinterfon
    protected $listeners = ['newinterfon' => 'refreshIntercomunicador'];

    public function render()
    {
        return view('livewire.intercomunicador', [
            $this->intercomunicadores = Interphone::where("to", auth()->user()->id)->orderBy("created_at", "ASC")->get()
        ]);
    }

    public function refreshIntercomunicador(){
        $this->intercomunicadores = Interphone::where("to", auth()->user()->id)->orderBy("created_at", "ASC")->get();
    }
}

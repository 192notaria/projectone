<?php

namespace App\Http\Livewire;

use App\Models\Bitacora;
use Livewire\Component;

class BitacoraDashboard extends Component
{
    public function render()
    {
        return view('livewire.bitacora-dashboard',[
            "registros_actividad" => Bitacora::orderBy("created_at", "DESC")->limit(9)->get()
        ]);
    }
}

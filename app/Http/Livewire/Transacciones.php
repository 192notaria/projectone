<?php

namespace App\Http\Livewire;

use App\Models\Cobros;
use App\Models\Egresos;
use Livewire\Component;

class Transacciones extends Component
{
    public $ingresos;
    public $egresos;

    public function mount(){
        $this->ingresos = Cobros::all();
        $this->egresos = Egresos::all();
    }

    public function render()
    {
        return view('livewire.transacciones',[
            "transacciones" => $this->ingresos->concat($this->egresos)->sortBy('created_at')->take(6),
        ]);
    }
}

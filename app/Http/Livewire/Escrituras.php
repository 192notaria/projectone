<?php

namespace App\Http\Livewire;

use App\Models\Proyectos;
use Livewire\Component;
use Livewire\WithPagination;

class Escrituras extends Component
{
    use WithPagination;

    public $cantidad_escrituras = 10;
    public function render()
    {
        return view('livewire.escrituras',[
            "escrituras" => Proyectos::orderBy("numero_escritura", "ASC")
                ->where("status", 1)
                ->paginate($this->cantidad_escrituras),
        ]);
    }
}

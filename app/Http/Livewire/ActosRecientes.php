<?php

namespace App\Http\Livewire;

use App\Models\Proyectos;
use Livewire\Component;

class ActosRecientes extends Component
{
    public function render()
    {
        return view('livewire.actos-recientes',[
            "actos" => Proyectos::orderBy("created_at", "DESC")->limit(7)->get()
        ]);
    }
}

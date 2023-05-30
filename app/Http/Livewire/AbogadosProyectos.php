<?php

namespace App\Http\Livewire;

use App\Models\Proyectos;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AbogadosProyectos extends Component
{
    public function render()
    {
        return view('livewire.abogados-proyectos',[
            "registros_abogados" => Proyectos::select('usuario_id', DB::raw('count(*) as cantidad'))->where("status", "!=", "5")->groupBy('usuario_id')->orderBy('cantidad', "DESC")->get()
        ]);
    }
}

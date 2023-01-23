<?php

namespace App\Http\Livewire;

use App\Models\Proyectos;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ActosTop extends Component
{
    public function render()
    {
        return view('livewire.actos-top',[
            "actos" => Proyectos::select('servicio_id', DB::raw('count(*) as cantidad'))->groupBy('servicio_id')->orderBy('cantidad', "DESC")->limit(10)->get()
        ]);
    }
}

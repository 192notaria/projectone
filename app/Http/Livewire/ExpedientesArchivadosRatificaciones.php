<?php

namespace App\Http\Livewire;

use App\Models\ExpedientesArchivados;
use Livewire\Component;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ExpedientesArchivadosRatificaciones extends Component
{
    public function render()
    {
        return view('livewire.expedientes-archivados-ratificaciones',[
            "archivados" => ExpedientesArchivados::orderBy("id", "ASC")
            ->whereHas('escritura.servicio.tipo_acto', function(Builder $serv){
                $serv->where('id', "%4%");
            })
            ->get(),
        ]);
    }
}

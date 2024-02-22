<?php

namespace App\Http\Livewire;

use App\Models\ExpedientesArchivados as ModelsExpedientesArchivados;
use Livewire\Component;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ExpedientesArchivados extends Component
{
    public function render()
    {
        return view('livewire.expedientes-archivados', [
            "archivados" => ModelsExpedientesArchivados::orderBy("id", "ASC")
            ->whereHas('escritura.servicio.tipo_acto', function(Builder $serv){
                $serv->where('id', "%1%");
            })
            ->get(),
        ]);
    }
}

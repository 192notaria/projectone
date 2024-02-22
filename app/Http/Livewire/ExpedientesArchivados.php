<?php

namespace App\Http\Livewire;

use App\Models\ExpedientesArchivados as ModelsExpedientesArchivados;
use Livewire\Component;

class ExpedientesArchivados extends Component
{
    public function render()
    {
        return view('livewire.expedientes-archivados', [
            "archivados" => ModelsExpedientesArchivados::orderBy("id", "ASC")->get(),
        ]);
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\ExpedientesArchivados;
use Livewire\Component;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;


class ExpedientesArchivadosActas extends Component
{
    use WithPagination;

    public $search;
    public $cantidad_escrituras = 10;

    public function render()
    {
        return view('livewire.expedientes-archivados-actas', [
            "archivados" => ExpedientesArchivados::orderBy("id", "ASC")
            ->whereHas('escritura.servicio.tipo_acto', function(Builder $q){
                $q->where('tipo_id', 2);
            })
            ->where(function($data){
                $data->orWhereHas('escritura', function(Builder $q){
                    $q->where('numero_escritura', "LIKE", "%" . $this->search . "%");
                })
                ->orWhereHas('escritura.cliente', function(Builder $q){
                    $q->where(DB::raw("CONCAT(nombre, ' ', apaterno, ' ', amaterno)"), 'LIKE', '%' . $this->search . '%');
                })
                ->orWhereHas('escritura.abogado', function(Builder $q){
                    $q->where(DB::raw("CONCAT(name, ' ', apaterno, ' ', amaterno)"), 'LIKE', '%' . $this->search . '%');
                });
            })
            ->paginate($this->cantidad_escrituras)
        ]);
    }
}

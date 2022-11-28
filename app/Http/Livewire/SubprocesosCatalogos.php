<?php

namespace App\Http\Livewire;

use App\Models\CatalogosTipo;
use App\Models\SubprocesosCatalogos as ModelsSubprocesosCatalogos;
use Livewire\Component;
use Livewire\WithPagination;


class SubprocesosCatalogos extends Component
{
    use WithPagination;
    public $buscarSubproceso;
    public $modalNewSubproceso = false;
    public $id_subproceso, $nombresubproceso, $tiposub;
    public $cantidadSubprocesos = 10;

    public function openModal(){
        $this->modalNewSubproceso = true;
    }

    public function closeModal(){
        $this->modalNewSubproceso = false;
        $this->clearinputs();
    }

    public function clearinputs(){
        $this->id_subproceso = ""; $this->nombresubproceso = "";
    }

    public function render()
    {
        return view('livewire.subprocesos-catalogos',[
            "subprocesosList" => ModelsSubprocesosCatalogos::orderBy("nombre", "ASC")
                ->where('nombre', 'LIKE', '%' . $this->buscarSubproceso . '%')
                ->paginate($this->cantidadSubprocesos),
            "tipos" => CatalogosTipo::orderBy("nombre", "ASC")->get()
        ]);
    }

    public function save(){
        $validatedData = $this->validate([
            'nombresubproceso' => 'required|min:3|unique:subprocesos_catalogos,nombre,' . $this->id_subproceso,
            'tiposub' => 'required',
        ]);
        $newsubproceso = new ModelsSubprocesosCatalogos();
        $newsubproceso->nombre = $this->nombresubproceso;
        $newsubproceso->tipo_id = $this->tiposub;
        $newsubproceso->updateOrCreate(['id' => $this->id_subproceso],[
            "nombre" => $this->nombresubproceso,
            "tipo_id" => $this->tiposub,
        ]);
        $this->closeModal();
    }
}

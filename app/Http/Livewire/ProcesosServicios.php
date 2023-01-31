<?php

namespace App\Http\Livewire;

use App\Models\CatalogosTipo;
use App\Models\CorrespondientesCatalogos;
use App\Models\Icons;
use App\Models\ProcesosServicios as ModelsProcesosServicios;
use App\Models\Subprocesos;
use App\Models\SubprocesosCatalogos;
use Livewire\Component;
use Livewire\WithPagination;

class ProcesosServicios extends Component
{
    use WithPagination;
    public $modalSuprocesos = false;
    public $modalNewProceso = false;
    public $modalBorrar = false;

    public $search;
    public $cantidadProcesos = 10;

    public $proceso_id, $subproceso_id = "";
    public $nombreProceso = "";
    public $modalTittle;
    public $icondata;

    public function openModalBorrar($id){
        $this->modalBorrar = true;
        $this->proceso_id = $id;
    }

    public function borrarProceso(){
        ModelsProcesosServicios::find($this->proceso_id)->delete();
        $this->closeModalBorrar();
    }

    public function closeModalBorrar(){
        $this->modalBorrar = false;
        $this->proceso_id = "";
    }

    public function openModalSubprocesos($id){
        $this->proceso_id = $id;
        $this->modalSuprocesos = true;
    }

    public function closeModalSubprocesos(){
        $this->modalSuprocesos = false;
        $this->clearInputs();
    }

    public function openModal($id, $tittle){
        if($id != ""){
            $proceso = ModelsProcesosServicios::find($id);
            $this->nombreProceso = $proceso->nombre;
            $this->proceso_id = $proceso->id;
        }
        $this->modalNewProceso = true;
        $this->modalTittle = $tittle;
    }

    public function closeModal(){
        $this->modalNewProceso = false;
        $this->proceso_id = "";
        $this->clearInputs();
    }

    public function removeSubprocess($id){
        Subprocesos::find($id)->delete();
    }

    public function clearInputs(){
        $this->subproceso_id = "";
        $this->proceso_id = "";
        $this->nombreProceso = "";
    }

    public function saveSubprocess(){
        $validateData = $this->validate([
            "subproceso_id" => "required"
        ]);

        Subprocesos::create([
            "subproceso_id" => $validateData['subproceso_id'],
            "proceso_id" => $this->proceso_id
        ]);
        $this->closeModalSubprocesos();
    }

    public function saveNewProcess(){
        $this->validate([
            "nombreProceso" => 'required|min:4|unique:procesos_servicios,nombre,' . $this->proceso_id,
        ]);

        if($this->proceso_id == ""){
            $proceso = new ModelsProcesosServicios();
            $proceso->nombre = $this->nombreProceso;
            $proceso->save();
            return $this->closeModal();
        }

        $proceso = ModelsProcesosServicios::find($this->proceso_id);
        $proceso->nombre = $this->nombreProceso;
        $proceso->save();
        return $this->closeModal();
    }

    public function render()
    {
        return view('livewire.procesos-servicios',[
            "proceos_servicios" => ModelsProcesosServicios::orderBy("nombre", "ASC")
                ->where('nombre', 'LIKE', '%' . $this->search . '%')
                ->paginate($this->cantidadProcesos),
            "catalogos_subprocesos" => SubprocesosCatalogos::orderBy("nombre", "ASC")->get(),
            "catalogos_correspondiente" => CorrespondientesCatalogos::orderBy("nombre", "ASC")->get(),
            "catalogos_tipo" => CatalogosTipo::orderBy("nombre", "ASC")->get(),
            "icons" => Icons::all()
        ]);
    }

    public function selectIcon($icon){
        dd($icon);
    }
}



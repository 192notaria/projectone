<?php

namespace App\Http\Livewire;

use App\Models\ProcesosServicios;
use App\Models\Servicios as ModelsServicios;
use App\Models\Servicios_Procesos_Servicio;
use Livewire\Component;
use Livewire\WithPagination;


class Servicios extends Component
{
    use WithPagination;
    public $modalProcesos = false;
    public $search;
    public $cantidadServicios = 5;
    public $servicio_id, $proceso_servicio_id;

    public $modalNuevo = false;
    public $modalborrar = false;
    public $nombre_del_servicio, $modalTittle, $tiempo_firma;

    public function openModalBorrar($id){
        $this->modalborrar = true;
        $this->servicio_id = $id;
    }
    public function closeModalBorrar(){
        $this->modalborrar = false;
    }
    public function borrarServicio(){
        ModelsServicios::find($this->servicio_id)->delete();
        $this->closeModalBorrar();
    }

    public function openModalNew($id, $modalTittle){
        $this->modalTittle = $modalTittle;
        $this->modalNuevo = true;
        $this->servicio_id = $id;
        if($id != ""){
            $servicio = ModelsServicios::find($id);
            $this->nombre_del_servicio = $servicio->nombre;
            $this->tiempo_firma = $servicio->tiempo_firma;
        }
    }

    public function save(){
        $this->validate([
            "nombre_del_servicio" => "required|min:3|unique:servicios,nombre," . $this->servicio_id,
            "tiempo_firma" => "required",
        ]);

        if($this->servicio_id != ""){
            $servicio = ModelsServicios::find($this->servicio_id);
            $servicio->nombre = $this->nombre_del_servicio;
            $servicio->tiempo_firma = $this->tiempo_firma;
            $servicio->save();
            return $this->closeModalNew();
        }

        $servicio = new ModelsServicios();
        $servicio->nombre = $this->nombre_del_servicio;
        $servicio->tiempo_firma = $this->tiempo_firma;
        $servicio->save();
        return $this->closeModalNew();
    }

    public function closeModalNew(){
        $this->modalNuevo = false;
        $this->nombre_del_servicio = "";
        $this->tiempo_firma = "";
    }

    public function openModalProcesos($id){
        $this->modalProcesos = true;
        $this->clearInput();
        $this->servicio_id = $id;
    }

    public function closeModalProcesos(){
        $this->clearInput();
        $this->modalProcesos = false;
    }

    public function clearInput(){
        $this->servicio_id = "";
        $this->proceso_servicio_id = "";
    }

    public function asignarProceso(){
        $buscarProceso = Servicios_Procesos_Servicio::where('servicio_id', $this->servicio_id)
            ->where('proceso_servicio_id', $this->proceso_servicio_id)
            ->get();

        if(count($buscarProceso) > 0){
            return $this->addError('ExisteProceso', 'Este proceso ya esta agregado');
        }

        $servicio = ModelsServicios::find($this->servicio_id);
        $servicio->procesos()->attach($this->proceso_servicio_id);
        $this->closeModalProcesos();
    }

    public function removerProceso($id, $servicio_id){
        $servicio = ModelsServicios::find($servicio_id);
        $servicio->procesos()->detach($id);
    }

    public function render()
    {
        return view('livewire.servicios',[
            "servicios" => ModelsServicios::orderBy("nombre", "ASC")
                ->where('nombre', 'LIKE', '%' . $this->search . '%')
                ->paginate($this->cantidadServicios),
            "procesos" => ProcesosServicios::orderBy("nombre", "ASC")->get(),
        ]);
    }
}

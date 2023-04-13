<?php

namespace App\Http\Livewire;

use App\Models\CatalogoPartes;
use App\Models\Catalogos_categoria_gastos;
use App\Models\Catalogos_conceptos_pago;
use App\Models\ProcesosServicios;
use App\Models\Servicios as ModelsServicios;
use App\Models\Servicios_Procesos_Servicio;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Database\Query\Sorter\OrderByKey;
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
    public $honorarios;
    public $conceptos_pago = [];
    public $partes_array = [];
    public $descripcion_parte;

    public function asignarParte(){
        $this->validate([
            "descripcion_parte" => "required"
        ]);

        $parte = [
            "descripcion" => $this->descripcion_parte,
        ];
        array_push($this->partes_array, $parte);
        return $this->descripcion_parte = '';
    }

    public function removerParte($id){
        unset($this->partes_array[$id]);
    }

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
            $this->conceptos_pago = DB::table('servicios_conceptos_pagos')->where('servicios_conceptos_pagos.servicio_id', $id)
                ->pluck('servicios_conceptos_pagos.concepto_pago_id','servicios_conceptos_pagos.concepto_pago_id')
                ->all();
            $this->honorarios = $servicio->honorarios;
            // $this->permisosCheck = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $id)
            //     ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            //     ->all();
            $partes = CatalogoPartes::where("servicio_id", $id)->get();
            foreach ($partes as $value) {
                $parte = [
                    "descripcion" => $value->descripcion
                ];
                array_push($this->partes_array, $parte);
            }
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
            $servicio->honorarios = $this->honorarios;
            // dd($this->conceptos_pago);
            foreach($this->conceptos_pago as $key => $concepto){
                if(!$concepto){
                    unset($this->conceptos_pago[$key]);
                }
            }

            $servicio->conceptos_pago()->sync(array_keys($this->conceptos_pago));
            $servicio->save();

            if(count($this->partes_array) > 0){
                DB::table('catalogo_partes')->where('servicio_id', $this->servicio_id)->delete();
                foreach ($this->partes_array as $value) {
                    $parte = new CatalogoPartes;
                    $parte->descripcion = $value['descripcion'];
                    $parte->servicio_id = $this->servicio_id;
                    $parte->save();
                }
            }

            $this->clearInput();
            return $this->closeModalNew();
        }

        $servicio = new ModelsServicios();
        $servicio->nombre = $this->nombre_del_servicio;
        $servicio->tiempo_firma = $this->tiempo_firma;
        $servicio->save();

        foreach($this->conceptos_pago as $key => $concepto){
            if(!$concepto){
                unset($this->conceptos_pago[$key]);
            }
        }

        $servicio->conceptos_pago()->sync($this->conceptos_pago);

        if(count($this->partes_array) > 0){
            foreach ($this->partes_array as $value) {
                $parte = new CatalogoPartes;
                $parte->descripcion = $value['descripcion'];
                $parte->servicio_id = $servicio->id;
                $parte->save();
            }
        }

        $this->clearInput();
        return $this->closeModalNew();
    }

    public function closeModalNew(){
        $this->modalNuevo = false;
        $this->nombre_del_servicio = "";
        $this->tiempo_firma = "";
        $this->partes_array = [];
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
        $this->honorarios;
        $this->conceptos_pago = [];
        $this->partes_array = [];
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
            "conceptos_pagos" => Catalogos_conceptos_pago::orderBy('categoria_gasto_id','ASC')
            ->orderBy('descripcion','ASC')
            ->get()
        ]);
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Proyectos;
use App\Models\Servicios;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class NumerosEscrituasGuardados extends Component
{
    use WithPagination;
    public $cantidad_escrituras = 20;

    public $escritura_id;
    public $numero_escritura;
    public $volumen;
    public $abogado_id = '';
    public $f_inicio;
    public $f_final;
    public $fecha;

    public $acto_juridico_id = '';
    public $acto_juridico;
    public $tipo_servicio = '';

    public function render()
    {
        return view('livewire.numeros-escrituas-guardados',[
            "escrituras" => Proyectos::orderBy("numero_escritura", "ASC")
                ->where("status", 5)
                ->paginate($this->cantidad_escrituras),
            "abogados" => User::orderBy("name", "ASC")
                ->where(function($query){
                    $query->whereHas("roles", function($data){
                        $data->where('name', '!=', 'ADMINISTRADOR');
                    });
                })->get(),
            "actos" => Servicios::orderBy("nombre", "ASC")->get()
        ]);
    }

    public function openModal(){
        return $this->dispatchBrowserEvent("open-modal-escrituras-guardadas");
    }

    public function clearInputs(){
        $this->escritura_id = '';
        $this->numero_escritura = '';
        $this->volumen = '';
        $this->abogado_id = '';
        $this->f_inicio = '';
        $this->f_final = '';
        $this->fecha = '';
        $this->acto_juridico_id = '';
        $this->acto_juridico = '';
        $this->tipo_servicio = '';
    }

    public function registrar(){
        $this->validate([
            "numero_escritura" => "required|unique:proyectos,numero_escritura," . $this->escritura_id,
            // "volumen" => "required",
            // "f_inicio" => "required",
            // "f_final" => "required",
            // "fecha" => "required",
        ],[
            "numero_escritura.required" => "Es necesario el numero de escritura",
            "numero_escritura.unique" => "Este numero de escritura ya esta registrado",
            "volumen.required" => "Es necesario el volumen",
            "f_inicio.required" => "Es necesario el folio de inicio",
            "f_final.required" => "Es necesario el folio final",
            "fecha.required" => "Es necesario la fecha de la escritura",
        ]);

        if($this->escritura_id){
            $escritura = Proyectos::find($this->escritura_id);
            $escritura->volumen = $this->volumen == '' ? null : $this->volumen;
            $escritura->numero_escritura = $this->numero_escritura;
            $escritura->usuario_id = $this->abogado_id == '' ? null : $this->abogado_id;
            $escritura->folio_inicio = $this->f_inicio;
            $escritura->folio_fin = $this->f_final;
            $escritura->created_at = $this->fecha == '' ? null : $this->fecha;
            $escritura->updated_at = $this->fecha == '' ? null : $this->fecha;
            $escritura->save();
            $this->clearInputs();
            $this->dispatchBrowserEvent("success-notify", "Numero editado");
            return $this->dispatchBrowserEvent("close-modal-escrituras-guardadas");
        }

        $escritura = new Proyectos;
        $escritura->status = 5;
        $escritura->volumen = $this->volumen == '' ? null : $this->volumen;
        $escritura->numero_escritura = $this->numero_escritura;
        $escritura->usuario_id = $this->abogado_id == '' ? null : $this->abogado_id;
        $escritura->folio_inicio = $this->f_inicio;
        $escritura->folio_fin = $this->f_final;
        $escritura->created_at = $this->fecha == '' ? null : $this->fecha;
        $escritura->updated_at = $this->fecha == '' ? null : $this->fecha;
        $escritura->save();
        $this->clearInputs();
        $this->dispatchBrowserEvent("success-notify", "Numero registrado");
        return $this->dispatchBrowserEvent("close-modal-escrituras-guardadas");
    }

    public function editarNumero($id){
        $escritura = Proyectos::find($id);
        $this->escritura_id = $id;
        $this->volumen = $escritura->volumen;
        $this->abogado_id = $escritura->usuario_id;
        $this->numero_escritura = $escritura->numero_escritura;
        $this->f_inicio = $escritura->folio_inicio;
        $this->f_final = $escritura->folio_fin;
        if($escritura->created_at){
            $this->fecha = date("Y-m-d H:m:i", strtotime($escritura->created_at));
        }
        return $this->openModal();
    }

    public function autorizar_escritura_modal(){
        $this->validate([
            "abogado_id" => "required",
            "fecha" => "required",
        ],[
            "abogado_id.required" => "Es necesario seleccionar un abogado",
            "fecha.required" => "Es necesario la fecha"
        ]);
        $this->dispatchBrowserEvent("close-modal-escrituras-guardadas");
        $this->dispatchBrowserEvent("open-modal-autorizar-escritura");
    }

    public function cambiar_acto(){
        $this->acto_juridico = Servicios::find($this->acto_juridico_id);
    }

    public function autorizar(){
        $this->validate([
            "acto_juridico_id" => "required"
        ],[
            "acto_juridico_id.required" => "Es necesario seleccionar el acto"
        ]);

        $escritura = Proyectos::find($this->escritura_id);
        $escritura->status = 0;
        $escritura->usuario_id = $this->abogado_id;
        $escritura->servicio_id = $this->acto_juridico_id;
        $escritura->tipo_servicio = $this->tipo_servicio == '' ? null : $this->tipo_servicio;
        $escritura->save();

        $this->dispatchBrowserEvent("success-notify", "Número de escritura autorizado");
        $this->dispatchBrowserEvent("close-modal-autorizar-escritura");
        create_firebase_project($escritura->id);
        return $this->clearInputs();
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Proyectos;
use App\Models\User;
use Livewire\Component;

class NumerosEscrituasGuardados extends Component
{
    public $escritura_id;
    public $numero_escritura;
    public $volumen;
    public $abogado_id = '';
    public $f_inicio;
    public $f_final;
    public $fecha;

    public function render()
    {
        return view('livewire.numeros-escrituas-guardados',[
            "escrituras" => Proyectos::orderBy("numero_escritura", "ASC")
                ->where("status", 5)
                ->get(),
            "abogados" => User::orderBy("name", "ASC")
                ->where(function($query){
                    $query->whereHas("roles", function($data){
                        $data->where('name', '!=', 'ADMINISTRADOR');
                    });
                })->get(),
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
            $escritura->volumen = $this->volumen;
            $escritura->numero_escritura = $this->numero_escritura;
            $escritura->usuario_id = $this->abogado_id == '' ? null : $this->abogado_id;
            $escritura->folio_inicio = $this->f_inicio;
            $escritura->folio_fin = $this->f_final;
            $escritura->created_at = $this->fecha;
            $escritura->updated_at = $this->fecha;
            $escritura->save();
            $this->clearInputs();
            $this->dispatchBrowserEvent("success-notify", "Numero editado");
            return $this->dispatchBrowserEvent("close-modal-escrituras-guardadas");
        }

        $escritura = new Proyectos;
        $escritura->status = 5;
        $escritura->volumen = $this->volumen;
        $escritura->numero_escritura = $this->numero_escritura;
        $escritura->usuario_id = $this->abogado_id == '' ? null : $this->abogado_id;
        $escritura->folio_inicio = $this->f_inicio;
        $escritura->folio_fin = $this->f_final;
        $escritura->created_at = $this->fecha;
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
        $this->fecha = date("Y-m-d H:m:i", strtotime($escritura->created_at));
        return $this->openModal();
    }
}

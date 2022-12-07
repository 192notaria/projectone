<?php

namespace App\Http\Livewire;

use App\Models\Ocupaciones as ModelsOcupaciones;
use Livewire\Component;
use Livewire\WithPagination;

class Ocupaciones extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $ocupacion_id, $nombre, $tipo = "";
    public $buscarOcupacion;
    public $cantidadOcupaciones = 10;

    public function updatingBuscarOcupacion(){
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.ocupaciones',[
            'ocupaciones' => ModelsOcupaciones::where('nombre', 'LIKE', '%' . $this->buscarOcupacion . '%')
                ->paginate($this->cantidadOcupaciones),
        ]);
    }

    public function clearInputs(){
        $this->ocupacion_id = "";
        $this->nombre = "";
    }

    public function editar($id){
        $ocupacion = ModelsOcupaciones::find($id);
        $this->ocupacion_id = $id;
        $this->nombre = $ocupacion->nombre;
        $this->tipo = $ocupacion->tipo;
    }

    public function saveOrEdit(){
        $this->validate([
            "nombre" => "required|unique:ocupaciones,nombre," . $this->ocupacion_id,
            "tipo" => "required"
        ]);

        if($this->ocupacion_id == ""){
            $ocupacion = new ModelsOcupaciones();
            $ocupacion->nombre = $this->nombre;
            $ocupacion->tipo = $this->tipo;
            $ocupacion->save();
            return $this->dispatchBrowserEvent('ocupacion_registrada', "$this->nombre" . " se ha registrado como nueva ocupacion");
        }

        $ocupacion = ModelsOcupaciones::find($this->ocupacion_id);
        $ocupacion->nombre = $this->nombre;
        $ocupacion->tipo = $this->tipo;
        $ocupacion->save();
        return $this->dispatchBrowserEvent('ocupacion_registrada', "$this->nombre" . " ha sido editada");
    }
}

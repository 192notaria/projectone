<?php

namespace App\Http\Livewire;

use App\Models\Estados;
use App\Models\Paises;
use Livewire\Component;
use Livewire\WithPagination;

class EstadosLW extends Component
{
    use WithPagination;
    public $buscarEstado;
    public $cantidadEstados = 10;
    public $modal = false;
    public $buscarpais;

    public $modalborrar = false;

    public $estado_id, $nombre, $pais_id, $pais_nombre;

    public function borrarEstadoModal($id){
        $this->estado_id = $id;
        $this->modalborrar = true;
    }

    public function closeBorrarEstadoModal(){
        $this->estado_id = "";
        $this->modalborrar = false;
    }

    public function borrarEstado(){
        Estados::find($this->estado_id)->delete();
        $this->modalborrar = false;
    }

    public function updatingBuscarEstado(){
        $this->resetPage();
    }

    public function updatingCantidadEstados(){
        $this->resetPage();
    }

    public function closeModal(){
        $this->modal = false;
        $this->estado_id = "";
        $this->nombre = "";
        $this->pais_id = "";
        $this->pais_nombre = "";

    }

    public function openModal($id){
        if($id != ""){
            $this->estado_id = $id;
            $getEstado = Estados::find($id);
            $this->nombre = $getEstado->nombre;
            $this->pais_nombre = $getEstado->getPais->nombre;
            $this->pais_id = $getEstado->pais;
        }

        $this->modal = true;
    }



    public function selectPais($id){
        $pais = Paises::find($id);
        $this->pais_nombre = $pais->nombre;
        $this->pais_id = $pais->id;
        $this->buscarpais = "";
    }

    public function save(){
        $this->validate([
            "nombre" => 'required|min:3',
            "pais_id" => 'required'
        ]);

        if($this->estado_id != ""){
            $estado = Estados::find($this->estado_id);
            $estado->nombre = $this->nombre;
            $estado->pais = $this->pais_id;
            $estado->save();
        }else{
            $newestado = new Estados();
            $newestado->nombre = $this->nombre;
            $newestado->pais = $this->pais_id;
            $newestado->save();
        }
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.estadosLW', [
            'estadosData' => Estados::orderBy('nombre', 'ASC')
                ->where('nombre', 'LIKE', '%' . $this->buscarEstado . '%')
                ->paginate($this->cantidadEstados),
            'paises' => $this->buscarpais == "" ? [] :
                Paises::orderBy('nombre', 'ASC')
                    ->where('nombre', 'LIKE', '%' . $this->buscarpais . '%')
                    ->get()
        ]);
    }
}

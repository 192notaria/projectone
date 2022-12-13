<?php

namespace App\Http\Livewire;

use App\Models\Estados;
use App\Models\Municipios as ModelsMunicipios;
use Livewire\Component;
use Livewire\WithPagination;

class Municipios extends Component
{
    use WithPagination;
    public $buscarMunicipio;
    public $cantidadMunicipios = 10;

    public $municipio_id, $nombre, $estado_id, $estado_nombre;
    public $buscarEstado;

    public $modal = false;
    public $modalborrar = false;

    public function openModal($id){
        if($id != ""){
            $municipio = ModelsMunicipios::find($id);
            $this->nombre = $municipio->nombre;
            if(isset($municipio->estado->nombre)){
                $this->estado_id = $municipio->estado;
                $this->estado_nombre = $municipio->getEstado->nombre;
            }
            $this->municipio_id = $id;
            return $this->modal = true;
        }
        return $this->modal = true;
    }
    public function closeModal(){
        $this->nombre = "";
        $this->estado_id = "";
        $this->estado_nombre = "";
        $this->municipio_id = "";
        $this->modal = false;
    }

    public function openModalBorrar($id){
        $this->municipio_id = $id;
        $this->modalborrar = true;
    }
    public function closeModalBorrar(){
        $this->municipio_id = "";
        $this->modalborrar = false;
    }
    public function borrarMunicipio(){
        ModelsMunicipios::find($this->municipio_id)->delete();
        $this->modalborrar = false;
    }

    public function selectEstado($id){
        $estado = Estados::find($id);
        $this->estado_nombre = $estado->nombre;
        $this->estado_id = $estado->id;
        $this->buscarEstado = "";
    }

    public function save(){
        $this->validate([
            'nombre' => 'required|min:3',
            'estado_id' => 'required',
        ]);

        if($this->municipio_id != ""){
            $municipio = ModelsMunicipios::find($this->municipio_id);
            $municipio->nombre = $this->nombre;
            $municipio->estado = $this->estado_id;
            $municipio->save();
            return $this->modal = false;
        }

        $newmunicipio = new ModelsMunicipios();
        $newmunicipio->nombre = $this->nombre;
        $newmunicipio->estado = $this->estado_id;
        $newmunicipio->save();
        return $this->modal = false;
    }


    public function updatingBuscarMunicipio(){
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.municipios', [
            'estados' => $this->buscarEstado == "" ? [] : Estados::orderBy('nombre','ASC')
                ->where('nombre', 'LIKE', '%' . $this->buscarEstado . '%')
                ->get(),
            'municipiosData' => ModelsMunicipios::orderBy('nombre','ASC')
                ->where('nombre', 'LIKE', '%' . $this->buscarMunicipio . '%')
                ->paginate($this->cantidadMunicipios)
        ]);
    }
}

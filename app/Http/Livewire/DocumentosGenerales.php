<?php

namespace App\Http\Livewire;

use App\Models\CatalogoDocumentosGenerales;
use Livewire\Component;
use Livewire\WithPagination;

class DocumentosGenerales extends Component
{
    use WithPagination;

    public $paginationRows = 10;
    public $search;

    public function render()
    {
        return view('livewire.documentos-generales',[
            "documentos" => CatalogoDocumentosGenerales::orderBy("nombre", "ASC")
                ->where("nombre", "LIKE", "%" . $this->search. "%")
                ->paginate($this->paginationRows),
        ]);
    }

    public function updatingSearch(){
        $this->resetPage();
    }

    public function updatingPaginationRows(){
        $this->resetPage();
    }


    public $registro_id;
    public $nombre;
    public $descripcion;

    public function abrir_modal_nuevo(){
        return $this->dispatchBrowserEvent("abrir-modal-crear-registro");
    }

    public function editar_registro($id){
        $registro = CatalogoDocumentosGenerales::find($id);
        $this->registro_id = $id;
        $this->nombre = $registro->nombre;
        $this->descripcion = $registro->descripcion;
        return $this->abrir_modal_nuevo();
    }

    public function guardar_registro(){
        $this->validate([
            "nombre" => "required|unique:catalogo_documentos_generales,nombre," . $this->registro_id
        ],[
            "nombre.required" => "Es necesario el nombre",
            "nombre.unique" => "Este nombre ya esta registrado",
        ]);

        if($this->registro_id){
            $registro = CatalogoDocumentosGenerales::find($this->registro_id);
            $registro->nombre = $this->nombre;
            $registro->descripcion = $this->descripcion;
            $registro->save();

            $this->nombre = "";
            $this->descripcion = "";

            $this->dispatchBrowserEvent("success-notify", "Registro editado");
            return $this->dispatchBrowserEvent("cerrar-modal-crear-registro");
        }

        $registro = new CatalogoDocumentosGenerales;
        $registro->nombre = $this->nombre;
        $registro->descripcion = $this->descripcion;
        $registro->save();

        $this->nombre = "";
        $this->descripcion = "";

        $this->dispatchBrowserEvent("success-notify", "Registro creado");
        return $this->dispatchBrowserEvent("cerrar-modal-crear-registro");
    }
}

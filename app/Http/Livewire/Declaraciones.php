<?php

namespace App\Http\Livewire;

use App\Models\Declaranot;
use App\Models\DocumentosDeclaranot;
use App\Models\Proyectos;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Declaraciones extends Component
{
    use WithPagination, WithFileUploads;
    public $cantidadDeclaraciones = 10;
    public $declaracion_id;
    public $documento_id;
    public $buscarEscrituraInput;
    public $escritura_data;
    public $fecha;
    public $observaciones;
    public $documentos = [];
    public $documentos_data = [];

    public function render()
    {
        return view('livewire.declaraciones', [
            "declaraciones" => Declaranot::orderBy("created_at", "DESC")->paginate($this->cantidadDeclaraciones),
            "escrituras" => $this->buscarEscrituraInput ? Proyectos::orderBY("numero_escritura", "ASC")
                ->where("numero_escritura", "LIKE", "%" . $this->buscarEscrituraInput . "%")
                ->get() : [],
        ]);
    }

    public function clearInputs(){
        $this->declaracion_id = '';
        $this->buscarEscrituraInput = '';
        $this->escritura_data = '';
        $this->fecha = '';
        $this->observaciones = '';
        $this->documentos = [];
    }

    public function abrir_modal_declaracion(){
        return $this->dispatchBrowserEvent("abrir-modal-registrar-declaracion");
    }

    public function asignar_escritura($escritura_id){
        $this->escritura_data = Proyectos::find($escritura_id);
        $this->buscarEscrituraInput = "";
    }

    public function remover_escritura(){
        $this->escritura_data = "";
        $this->buscarEscrituraInput = "";
    }

    public function abrir_modal_eliminar_documento($id){
        $this->documento_id = $id;
        return $this->dispatchBrowserEvent("abrir-modal-borrar-documento");
    }

    public function abrir_modal_eliminar_declaracion($id){
        $this->declaracion_id = $id;
        return $this->dispatchBrowserEvent("abrir-modal-borrar-declaracion");
    }

    public function eliminar_documento(){
        DocumentosDeclaranot::find($this->documento_id)->delete();
        $declaracion = Declaranot::find($this->declaracion_id);
        $this->documentos_data = $declaracion->documentos;
        $this->documento_id = '';
        $this->dispatchBrowserEvent("success-notify", "Documento borrado");
        return $this->dispatchBrowserEvent("cerrar-modal-borrar-documento");
    }

    public function eliminar_declaracion(){
        Declaranot::find($this->declaracion_id)->delete();
        $this->declaracion_id = '';
        $this->dispatchBrowserEvent("success-notify", "Declaracion eliminada");
        return $this->dispatchBrowserEvent("cerrar-modal-borrar-declaracion");
    }

    public function editar_declaracion($id){
        $declaracion = Declaranot::find($id);
        $this->declaracion_id = $id;
        $this->fecha = $declaracion->fecha;
        $this->observaciones = $declaracion->observaciones;
        $this->escritura_data = Proyectos::find($declaracion->proyecto_id);
        $this->documentos_data = $declaracion->documentos;
        $this->abrir_modal_declaracion();
    }

    public function registrar_declaracion(){
        $this->validate([
            'escritura_data' => 'required',
            'fecha' => 'required',
            'documentos.*' => count($this->documentos) > 0 ? 'mimes:pdf' : "",
        ],[
            "escritura_data.required" => "Es necesario seleccionar la escritura",
            "fecha.required" => "Es necesario la fecha",
            "documentos.mimes" => "Los documentos solo pueden ser en PDF",
        ]);

        if($this->declaracion_id){
            $declaracion = Declaranot::find($this->declaracion_id);
            $declaracion->fecha = $this->fecha;
            $declaracion->proyecto_id = $this->escritura_data->id;
            $declaracion->observaciones = $this->observaciones;
            $declaracion->save();
            foreach ($this->documentos as $key => $value) {
                $doc = new DocumentosDeclaranot;
                $storeas = $value->storeAs('uploads/declaraciones', $key . "_" . time() . "_" . $value->getClientOriginalName() , 'public');
                $doc->path = "storage/" . $storeas;
                $doc->declaracion_id = $declaracion->id;
                $doc->save();
            }

            $this->clearInputs();
            $this->dispatchBrowserEvent("success-notify", "Declaracion editada");
            return $this->dispatchBrowserEvent("cerrar-modal-registrar-declaracion");
        }

        $declaracion = new Declaranot;
        $declaracion->fecha = $this->fecha;
        $declaracion->proyecto_id = $this->escritura_data->id;
        $declaracion->observaciones = $this->observaciones;
        $declaracion->usuario_id = Auth::user()->id;
        $declaracion->save();

        foreach ($this->documentos as $key => $value) {
            $doc = new DocumentosDeclaranot;
            $storeas = $value->storeAs('uploads/declaraciones', $key . "_" . time() . "_" . $value->getClientOriginalName() , 'public');
            $doc->path = "storage/" . $storeas;
            $doc->declaracion_id = $declaracion->id;
            $doc->save();
        }

        $this->clearInputs();
        $this->dispatchBrowserEvent("success-notify", "Declaracion registrada");
        return $this->dispatchBrowserEvent("cerrar-modal-registrar-declaracion");
    }

}

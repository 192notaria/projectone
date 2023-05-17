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
    public $buscarEscrituraInput;
    public $escritura_data;
    public $fecha;
    public $observaciones;
    public $documentos = [];

    public function render()
    {
        return view('livewire.declaraciones',[
            "declaraciones" => Declaranot::orderBy("created_at", "DESC")->paginate($this->cantidadDeclaraciones),
            "escrituras" => $this->buscarEscrituraInput ? Proyectos::orderBY("numero_escritura", "ASC")
                ->where("numero_escritura", "LIKE", "%" . $this->buscarEscrituraInput . "%")
                ->get() : [],
        ]);
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

        $this->dispatchBrowserEvent("success-notify", "Declaracion registrada");
        return $this->dispatchBrowserEvent("cerrar-modal-registrar-declaracion");
    }

}

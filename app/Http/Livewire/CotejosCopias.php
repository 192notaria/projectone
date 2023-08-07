<?php

namespace App\Http\Livewire;

use App\Models\Clientes;
use App\Models\CotejosCopias as ModelsCotejosCopias;
use App\Models\Proyectos;
use App\Models\RegistroRecibos;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use PhpOffice\PhpWord\TemplateProcessor;
use Livewire\WithFileUploads;

class CotejosCopias extends Component
{
    use WithFileUploads;
    public $copia_id;
    public $costo_copias;
    public $cantidad_copias;
    public $juegos;
    public $cliente;
    public $path_copias;
    public $cliente_id;

    public $search;

    public $monto;
    public $descripcion;
    public $factura;
    public $metodo_pago = '';
    public $proyecto_id;
    public $recibo;
    public $recibo_input;

    public $pago_data;

    public function render(){
        return view('livewire.cotejos-copias', [
            "copias_certificadas" => ModelsCotejosCopias::orderBy("created_at", "DESC")->get(),
            "clientes" => Clientes::orderBy("nombre", "ASC")->get(),
        ]);
    }

    public function nueva_copia_modal(){
        return $this->dispatchBrowserEvent("abrir-modal-nueva-copia");
    }

    public function pagos_modal($id){
        $copia = ModelsCotejosCopias::find($id);

        if($copia->pago){
            $this->pago_data = RegistroRecibos::find($copia->pago->id);
            return $this->dispatchBrowserEvent("abrir-modal-recibo-pago");
        }

        $this->copia_id = $id;
        return $this->dispatchBrowserEvent("abrir-modal-pagos");
    }

    public function clear_inputs(){
        $this->copia_id = '';
        $this->costo_copias = '';
        $this->cantidad_copias = '';
        $this->juegos = '';
        $this->cliente = '';
        $this->path_copias = '';
        $this->cliente_id = '';
        $this->monto = '';
        $this->descripcion = '';
        $this->factura = '';
        $this->metodo_pago = '';
        $this->proyecto_id = '';
        $this->recibo = '';
    }

    public function registrar_copia(){
        $this->validate([
            "costo_copias" => "required",
            "cantidad_copias" => "required",
            "juegos" => "required",
        ],[
            "costo_copias.required" => "Es necesario el costo por copia",
            "cantidad_copias.required" => "Es necesario la cantidad de copias",
            "juegos.required" => "Es necesario la cantidad de juegos",
        ]);

        $proyecto = new Proyectos();
        $proyecto->servicio_id = 31;
        $proyecto->cliente_id = $this->cliente_id ?? null;
        $proyecto->usuario_id = Auth::user()->id;
        $proyecto->status = 0;
        $proyecto->save();

        $copia = new ModelsCotejosCopias();
        $copia->costo_copia = $this->costo_copias;
        $copia->cantidad_copias = $this->cantidad_copias;
        $copia->juegos = $this->juegos;
        $copia->proyecto_id = $proyecto->id;
        $copia->cliente_id = $this->cliente_id ?? null;;
        $copia->usuario_id = Auth::user()->id;
        $copia->save();

        $this->clear_inputs();
        return $this->dispatchBrowserEvent("cerrar-modal-nueva-copia");
    }

    public function registrar_pago(){
        $this->validate([
            "descripcion" => "required",
            "metodo_pago" => "required",
        ],[
            "descripcion.required" => "Es necesario ",
            "metodo_pago.required" => "Es necesario ",
        ]);

        $copia = ModelsCotejosCopias::find($this->copia_id);

        $recibo = new RegistroRecibos();
        $recibo->monto = $copia->costo_copia * $copia->cantidad_copias * $copia->juegos;
        $recibo->descripcion = $this->descripcion;
        $recibo->factura = $this->factura;
        $recibo->metodo_pago = $this->metodo_pago;
        $recibo->cliente_id = $copia->cliente_id;
        $recibo->proyecto_id = $copia->proyecto_id;
        $recibo->usuario_id = Auth::user()->id ?? "";
        $recibo->save();
        $this->clear_inputs();
        return $this->dispatchBrowserEvent("cerrar-modal-pagos");
    }

    public function descargar_recibo($id){
        $recibo = RegistroRecibos::find($id);
        $templateprocessor = new TemplateProcessor('word-template/new-recibo-pago.docx');
        $templateprocessor->setValue('fecha', date("d-m-Y", time()));
        $templateprocessor->setValue('monto', $recibo->monto);
        $templateprocessor->setValue('n_recibo', $recibo->id);
        $templateprocessor->setValue('cliente', $recibo->cliente->nombre . " " . $recibo->cliente->apaterno . " " . $recibo->cliente->amaterno);
        $templateprocessor->setValue('telefono_cliente', $recibo->cliente->telefono);
        $templateprocessor->setValue('correo_cliente', $recibo->cliente->email);
        $templateprocessor->setValue('fs', $recibo->factura ? "*" : " ");
        $templateprocessor->setValue('fn', !$recibo->factura ? "*" : " ");
        $templateprocessor->setValue('mpe', $recibo->metodo_pago == "Efectivo" ? "*" : " ");
        $templateprocessor->setValue('mpt', $recibo->metodo_pago == "Transferencia" ? "*" : " ");
        $templateprocessor->setValue('descripcion', $recibo->descripcion);
        $templateprocessor->setValue('usuario', $recibo->usuario->name . " " . $recibo->usuario->apaterno . " " . $recibo->usuario->amaterno);
        $filename = "Recibo de pago " . $recibo->cliente->nombre . " " . $recibo->cliente->apaterno . " " . $recibo->cliente->amaterno;
        $templateprocessor->saveAs($filename . '.docx');
        return response()->download($filename . ".docx")->deleteFileAfterSend(true);
    }

    public function registrar_recibo(){
        $this->validate([
            "recibo_input" => "required|mimes:pdf"
        ],[
            "recibo_input.required" => "Es necesario el cargar el recibo",
            "recibo_input.mimes" => "El recibo debe ser en formato PDF",
        ]);

        $path = "/recibos/copias_certificadas/" . $this->pago_data->id;
        $store_xml = $this->recibo_input->storeAs(mb_strtolower($path), "recibo_" . $this->pago_data->id . "_" . time() . "." . $this->recibo_input->extension(), 'public');

        $recibo = RegistroRecibos::find($this->pago_data->id);
        $recibo->recibo = "storage/" . $store_xml;
        $recibo->save();
        $this->clear_inputs();
        return $this->dispatchBrowserEvent("cerrar-modal-recibo-pago");
    }

}

<?php

namespace App\Http\Livewire;

use App\Models\Clientes;
use App\Models\Facturas as ModelsFacturas;
use App\Models\Proyectos;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Facturas extends Component
{
    use WithPagination, WithFileUploads;

    public $cantidadFacturas = 10;
    public $buscarEscrituraInput;

    public $escritura_data;
    public $cliente_data;

    public $clienteInput;
    public $escrituraInput;
    public $rfcInput;
    public $folio_input;
    public $monto_input;
    public $fecha_input;
    public $concepto_input;
    public $origen_input = '';
    public $observaciones_input;
    public $pdf_input;
    public $xml_input;
    public $search;

    public function render(){
        return view('livewire.facturas',[
            "facturas" => ModelsFacturas::orderBY("created_At", "DESC")
                ->where(function($q){
                    $q->whereHas("escritura", "LIKE", "%" . $this->search . "%");
                })
                ->paginate($this->cantidadFacturas),
            "buscar_escrituras" => !$this->buscarEscrituraInput ? [] : Proyectos::orderBy("numero_escritura", "ASC")
                ->where("numero_escritura", "LIKE", "%" . $this->buscarEscrituraInput . "%")
                ->take(10)
                ->get(),
            "buscar_clientes" => !$this->clienteInput && !$this->cliente_data ? [] : Clientes::orderBy("nombre", "ASC")
                ->where("nombre", "LIKE", "%". $this->clienteInput ."%")
                ->get(),
        ]);
    }

    public function clearInputs(){
        $this->clienteInput = "";
        $this->escrituraInput = "";
        $this->rfcInput = "";
        $this->folio_input = "";
        $this->monto_input = "";
        $this->fecha_input = "";
        $this->concepto_input = "";
        $this->origen_input = "";
        $this->observaciones_input = "";
        $this->pdf_input = "";
        $this->xml_input = "";
        $this->escritura_data = "";
        $this->cliente_data = "";
    }

    public function abrirModalFactura(){
        return $this->dispatchBrowserEvent("abrir-modal-new-factura");
    }

    public function asignar_escritura($escritura_id){
        $this->escritura_data = Proyectos::find($escritura_id);
        $this->cliente_data = $this->escritura_data->cliente;

        $nombreCliente = $this->escritura_data->cliente->nombre . " " . $this->escritura_data->cliente->apaterno . " " . $this->escritura_data->cliente->amaterno;
        $rfcCliente = $this->escritura_data->cliente->rfc;
        $escritura_cliente = $this->escritura_data->servicio->nombre . " - " . $this->escritura_data->numero_escritura;

        $this->clienteInput = $nombreCliente;
        $this->rfcInput = $rfcCliente;
        $this->escrituraInput = $escritura_cliente;

        $this->buscarEscrituraInput = "";
    }

    public function limpiarCliente(){
        $this->cliente_data = '';
    }

    public function cambiar_cliente($id){
        $this->cliente_data = Clientes::find($id);
        $nombreCliente = $this->cliente_data->nombre . " " . $this->cliente_data->apaterno . " " . $this->cliente_data->amaterno;
        $this->clienteInput = $nombreCliente;
    }

    public function registrar_factura(){
        $this->validate([
            "escritura_data" => "required",
            "cliente_data" => "required",
            "clienteInput" => "required",
            "escrituraInput" => "required",
            "rfcInput" => "required",
            "folio_input" => "required",
            "monto_input" => "required",
            "fecha_input" => "required",
            "concepto_input" => "required",
            "origen_input" => "required",
        ]);

        $factura = new ModelsFacturas;
        $factura->monto = $this->monto_input;
        $factura->folio_factura = $this->folio_input;
        $factura->rfc_receptor = $this->rfcInput;
        $factura->fecha = $this->fecha_input;
        $factura->origen = $this->origen_input;
        $factura->concepto = $this->concepto_input;
        $factura->observaciones = $this->observaciones_input;
        $factura->proyecto_id = $this->escritura_data['id'];
        $factura->usuario_id = Auth::user()->id;
        $factura->cliente_id = $this->cliente_data['id'];

        $path_xml = "/uploads/clientes/" . str_replace(" ", "_", $this->escritura_data['cliente']['nombre']) . "_" . str_replace(" ", "_", $this->escritura_data['cliente']['apaterno']) . "_" . str_replace(" ", "_", $this->escritura_data['cliente']['amaterno']) . "/documentos/facturas";
        if($this->pdf_input){
            $store_pdf = $this->pdf_input->storeAs(mb_strtolower($path_xml), $this->escritura_data['servicio']['nombre'] . "_PDF_" . time() . "." . $this->pdf_input->extension(), 'public');
            $factura->pdf = "storage/" . $store_pdf;
        }

        if($this->xml_input){
            $store_xml = $this->xml_input->storeAs(mb_strtolower($path_xml), $this->escritura_data['servicio']['nombre'] . "_XML_" . time() . "." . $this->xml_input->extension(), 'public');
            $factura->xml = "storage/" . $store_xml;
        }

        $factura->save();
        $this->clearInputs();
        return $this->dispatchBrowserEvent("cerrar-modal-new-factura");
    }
}

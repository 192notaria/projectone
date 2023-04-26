<?php

namespace App\Http\Livewire;

use App\Models\Costos;
use App\Models\Facturas;
use App\Models\Proyectos;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Escrituras extends Component
{
    use WithPagination, WithFileUploads;
    public $cantidad_escrituras = 10;
    public $escritura_id;

    // Pagos
    public $total_pago;
    public $total_impuestos;
    public $pagos_checkbox = [];
    public $vista_general = "general";

    // Generales de la escritura
    public $proyecto_id_general;
    public $numero_escritura_general;
    public $volumen_general;
    public $folio_inicio_general;
    public $folio_fin_general;

    // Egresos
    public $egreso_id;
    public $td_egreso = "info";
    public $file_egreso;

    // Facturas
    public $factura_id;
    public $concepto_factura = "";
    public $monto_factura = "";
    public $folio_factura = "";
    public $rfc_factura = "";
    public $fecha_factura = "";
    public $origen_factura = "";
    public $comentarios_factura = "";
    public $xml_factura = "";
    public $pdf_factura = "";

    public function render()
    {
        return view('livewire.escrituras',[
            "escritura_activa" => $this->escritura_id ? Proyectos::find($this->escritura_id) : "",
            "escrituras" => Proyectos::orderBy("numero_escritura", "ASC")
                ->where("status", 1)
                ->paginate($this->cantidad_escrituras),
        ]);
    }

    public function abrir_escritura($id){
        $this->escritura_id = $id;
        return $this->dispatchBrowserEvent("abrir-modal-escritura-detalles");
    }
    public function vista_general_modal($vista){
        $this->vista_general = $vista;
    }

    public function cambiar_info_proyecto($id){
        $proyecto = Proyectos::find($id);
        $this->proyecto_id_general = $proyecto->id;
        $this->numero_escritura_general = $proyecto->numero_escritura;
        $this->volumen_general = $proyecto->volumen;
        $this->folio_inicio_general = $proyecto->folio_inicio;
        $this->folio_fin_general = $proyecto->folio_fin;
        return $this->vista_general_modal("editar_escritura_volumen");
    }

    public function calcularTotalPago(){
        $this->total_pago = 0.0;
        $this->total_impuestos = 0.0;
        foreach ($this->pagos_checkbox as $key => $value) {
            if($value){
                $costo = Costos::find($key);
                $impuesto = $value * $costo->impuestos / 100;
                $this->total_impuestos = $this->total_impuestos + $impuesto;
                $this->total_pago = $this->total_pago + doubleval($value);
            }
        }
        return $this->dispatchBrowserEvent('open-side-box');
    }

    public function guardar_escritura_volumen(){
        $this->validate([
                "numero_escritura_general" => 'required|unique:proyectos,numero_escritura,' . $this->escritura_id,
                "volumen_general" => "required",
            ],
            [
                "numero_escritura_general.required" => "Es necesario el numero de escritura para continuar",
                "numero_escritura_general.unique" => "Este numero de escritura ya esta registrado",
                "volumen_general.required" => "Es necesario el volumen para continuar",
            ]
        );

        $proyecto = Proyectos::find($this->escritura_id);
        $proyecto->numero_escritura = $this->numero_escritura_general;
        $proyecto->numero_escritura = $this->numero_escritura_general;
        $proyecto->volumen = $this->volumen_general;
        $proyecto->folio_inicio = $this->folio_inicio_general;
        $proyecto->folio_fin = $this->folio_fin_general;
        $proyecto->save();

        $this->numero_escritura_general = "";
        $this->volumen_general = "";
        $this->folio_inicio_general = "";
        $this->folio_fin_general = "";

        $this->vista_general_modal("general");
        return $this->dispatchBrowserEvent("success-notify", "Informacion del proyecto registrada");
    }


    public function open_egreso_modal_doc($id){
        $this->egreso_id = $id;
        $this->td_egreso = "upload";
    }

    public function save_egreso_modal_doc(){
        $this->validate([
                "file_egreso" => "required|mimes:docx,doc,pdf"
            ],[
                "file_egreso.required" => "Es necesario cargar un archivo",
                "file_egreso.mimes" => "El archivo no es valido, porfavor ingrese un archivo doc, docx o pdf",
        ]);

        $egreso = Egresos::find($this->egreso_id);
        $path = "/uploads/clientes/" . str_replace(" ", "_", $this->escritura_activa['cliente']['nombre']) . "_" . str_replace(" ", "_", $this->escritura_activa['cliente']['apaterno']) . "_" . str_replace(" ", "_", $this->escritura_activa['cliente']['amaterno']) . "/documentos";
        $store_xml = $this->file_egreso->storeAs(mb_strtolower($path), "egreso_" . $egreso->id . "_" . time() . "." . $this->file_egreso->extension(), 'public');
        $egreso->path = "storage/" . $store_xml;
        $egreso->save();
        $this->td_egreso = "info";
        $this->egreso_id = "";
        $this->file_egreso = "";
    }

    public function open_modal_registrar_factura(){
        return $this->dispatchBrowserEvent("abrir-modal-registrar-facturas");
    }

    public function editar_factura($id){
        $fatura = Facturas::find($id);
        $this->factura_id = $fatura->id;
        $this->monto_factura = $fatura->monto;
        $this->folio_factura = $fatura->folio_factura;
        $this->rfc_factura = $fatura->rfc_receptor;
        $this->fecha_factura = $fatura->fecha;
        $this->origen_factura = $fatura->origen;
        $this->concepto_factura = $fatura->concepto_pago_id;
        $this->comentarios_factura = $fatura->observaciones;
        return $this->dispatchBrowserEvent("abrir-modal-registrar-facturas");
    }

    public function registrar_factura(){
        $this->validate([
            "concepto_factura" => "required",
            "monto_factura" => "required",
            "folio_factura" => "required",
            "rfc_factura" => "required",
            "fecha_factura" => "required",
            "origen_factura" => "required",
            'xml_factura' => $this->xml_factura != "" ? 'mimes:xml' : "",
            'pdf_factura' => $this->pdf_factura != "" ? 'mimes:pdf' : "",
        ]);

        if($this->factura_id){
            $escritura = Proyectos::find($this->escritura_id);
            $fatura = Facturas::find($this->factura_id);
            $fatura->monto = $this->monto_factura;
            $fatura->folio_factura = $this->folio_factura;
            $fatura->rfc_receptor = $this->rfc_factura;
            $fatura->fecha = $this->fecha_factura;
            $fatura->origen = $this->origen_factura;
            $fatura->concepto_pago_id = $this->concepto_factura;
            $fatura->observaciones = $this->comentarios_factura ?? "";

            if($this->xml_factura){
                $path_xml = "/uploads/clientes/" . str_replace(" ", "_", $escritura['cliente']['nombre']) . "_" . str_replace(" ", "_", $escritura->cliente->apaterno) . "_" . str_replace(" ", "_", $escritura->cliente->amaterno) . "/documentos/facturas";
                $store_xml = $this->xml_factura->storeAs(mb_strtolower($path_xml), $this->concepto_factura . "_" . time() . "." . $this->xml_factura->extension(), 'public');
                $fatura->xml = $store_xml;
            }

            if($this->pdf_factura){
                $path_pdf = "/uploads/clientes/" . str_replace(" ", "_", $escritura['cliente']['nombre']) . "_" . str_replace(" ", "_", $escritura->cliente->apaterno) . "_" . str_replace(" ", "_", $escritura->cliente->amaterno) . "/documentos/facturas";
                $store_pdf = $this->pdf_factura->storeAs(mb_strtolower($path_pdf), $this->concepto_factura . "_" . time() . "." . $this->pdf_factura->extension(), 'public');
                $fatura->pdf = $store_pdf;
            }

            $fatura->proyecto_id = $this->escritura_id;
            $fatura->usuario_id = Auth::user()->id;
            $fatura->save();

            $this->concepto_factura = "";
            $this->monto_factura = "";
            $this->folio_factura = "";
            $this->rfc_factura = "";
            $this->fecha_factura = "";
            $this->origen_factura = "";
            $this->comentarios_factura = "";
            $this->xml_factura = "";
            $this->pdf_factura = "";
            return $this->dispatchBrowserEvent("cerrar-modal-registrar-facturas", "Factura editada");
        }

        $escritura = Proyectos::find($this->escritura_id);

        $fatura = new Facturas;
        $fatura->monto = $this->monto_factura;
        $fatura->folio_factura = $this->folio_factura;
        $fatura->rfc_receptor = $this->rfc_factura;
        $fatura->fecha = $this->fecha_factura;
        $fatura->origen = $this->origen_factura;
        $fatura->concepto_pago_id = $this->concepto_factura;
        $fatura->observaciones = $this->comentarios_factura ?? "";

        if($this->xml_factura){
            $path_xml = "/uploads/clientes/" . str_replace(" ", "_", $escritura['cliente']['nombre']) . "_" . str_replace(" ", "_", $escritura->cliente->apaterno) . "_" . str_replace(" ", "_", $escritura->cliente->amaterno) . "/documentos/facturas";
            $store_xml = $this->xml_factura->storeAs(mb_strtolower($path_xml), $this->concepto_factura . "_" . time() . "." . $this->xml_factura->extension(), 'public');
            $fatura->xml = $store_xml;
        }

        if($this->pdf_factura){
            $path_pdf = "/uploads/clientes/" . str_replace(" ", "_", $escritura['cliente']['nombre']) . "_" . str_replace(" ", "_", $escritura->cliente->apaterno) . "_" . str_replace(" ", "_", $escritura->cliente->amaterno) . "/documentos/facturas";
            $store_pdf = $this->pdf_factura->storeAs(mb_strtolower($path_pdf), $this->concepto_factura . "_" . time() . "." . $this->pdf_factura->extension(), 'public');
            $fatura->pdf = $store_pdf;
        }

        $fatura->proyecto_id = $this->escritura_id;
        $fatura->usuario_id = Auth::user()->id;
        $fatura->save();

        $this->concepto_factura = "";
        $this->monto_factura = "";
        $this->folio_factura = "";
        $this->rfc_factura = "";
        $this->fecha_factura = "";
        $this->origen_factura = "";
        $this->comentarios_factura = "";
        $this->xml_factura = "";
        $this->pdf_factura = "";
        return $this->dispatchBrowserEvent("cerrar-modal-registrar-facturas", "Factura registrada");
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\ApoyoProyectos;
use App\Models\AutorizacionCatastro;
use App\Models\AvanceProyecto;
use App\Models\CatalogoMetodosPago;
use App\Models\Catalogos_conceptos_pago;
use App\Models\Catalogos_tipo_cuenta;
use App\Models\Catalogos_uso_de_cuentas;
use App\Models\Clientes;
use App\Models\Cobros;
use App\Models\Costos;
use App\Models\CostosCobrados;
use App\Models\Cuentas_bancarias;
use App\Models\Documentos;
use App\Models\Firmas;
use App\Models\Generales;
use App\Models\ProcesosServicios;
use App\Models\Proyectos;
use App\Models\RecibosPago;
use App\Models\RegistroFirmas;
use App\Models\Servicios;
use App\Models\Subprocesos;
use App\Models\SubprocesosCatalogos;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class EscriturasProceso extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $proyecto_id;
    public $subproceso_id;
    public $tipo_subproceso;
    public $proceso_activo;
    public $subproceso_activo;
    public $subprocesos_info;

    public $cantidad_escrituras = 5;
    public $procesos_data = [];
    public $subprocesos_data = [];
    public $documents_to_upload = [];

    public $search;
    public $buscar_cliente;
    public $catalogo_documentos = [];

    public $cliente_id;
    public $documento_pdf;
    public $tipo_documento = '';

    public $tipo_doc_sub;
    public $require_documents = false;
    public $documentos_completos = false;

    public $fecha_firma;
    public $fecha_a_registrar;
    public $upload_files = false;

    public $buscar_abogado;
    public $pagos_checkbox = [];

    public function render()
    {
        return view('livewire.escrituras-proceso', [
            "clientes" =>  $this->buscar_cliente == '' ? [] : Clientes::orderBy("nombre", "ASC")
                ->where('nombre', 'LIKE', '%' . $this->buscar_cliente . '%')
                ->orWhere('apaterno', 'LIKE', '%' . $this->buscar_cliente . '%')
                ->orWhere('amaterno', 'LIKE', '%' . $this->buscar_cliente . '%')
                ->get(),
            "abogados" =>  $this->buscar_abogado == '' ? [] : User::orderBy("name", "ASC")
                ->where(function($query){
                    $query->whereHas("roles", function($data){
                        $data->where('name', '!=', 'ADMINISTRADOR');
                    });
                })
                ->where(function($query){
                    $query->where('name', 'LIKE', '%' . $this->buscar_abogado . '%')
                        ->orwhere('apaterno', 'LIKE', '%' . $this->buscar_abogado . '%')
                        ->orwhere('amaterno', 'LIKE', '%' . $this->buscar_abogado . '%');
                })
                ->where('id', '!=', $this->proyecto_abogado['id'] ?? "")
                ->get(),
            "escrituras" => Auth::user()->hasRole('ADMINISTRADOR') || Auth::user()->hasRole('ABOGADO ADMINISTRADOR') ?
                Proyectos::orderBy("numero_escritura", "ASC")
                ->where('status', 0)
                ->where(function($query){
                    $query->whereHas('cliente', function($q){
                        $q->where('nombre', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('apaterno', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('amaterno', 'LIKE', '%' . $this->search . '%');
                    })
                    ->orWhereHas('servicio', function($serv){
                        $serv->where('nombre', 'LIKE', '%' . $this->search . '%');
                    })
                    ->orWhere('volumen', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('numero_escritura', 'LIKE', '%' . $this->search . '%');
                })
                ->paginate($this->cantidad_escrituras )
            :
                Proyectos::orderBy("numero_escritura", "ASC")
                    ->where('usuario_id', auth()->user()->id)
                    ->where('status', 0)
                    ->where(function($query){
                        $query->orWhereHas('cliente', function($q){
                            $q->where('nombre', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('apaterno', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('amaterno', 'LIKE', '%' . $this->search . '%');
                        })->orWhereHas('servicio', function($serv){
                            $serv->where('nombre', 'LIKE', '%' . $this->search . '%');
                        })->orWhere('volumen', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('numero_escritura', 'LIKE', '%' . $this->search . '%');
                    })
                    ->paginate($this->cantidad_escrituras ),
            "generales" => Generales::where("proyecto_id", $this->proyecto_id)
                // ->where(function($query){
                //     $query->where('tipo', 'Generales del comprador')
                //         ->orWhere('tipo', 'Generales del vendedor');
                // })
                ->where('tipo_id', $this->subprocesos_info->id ?? 0)
                ->get(),
            "documentos" => Documentos::where("proyecto_id", $this->proyecto_id)
                ->where("catalogo_id", $this->subprocesos_info->id ?? 0)
                ->get(),
            "firmas" => Firmas::where("proyecto_id", $this->proyecto_id)
                ->where("proceso_id", $this->proceso_activo)
                ->first(),
            "recibos_pagos" => RecibosPago::where("proyecto_id", $this->proyecto_id)
                ->where("proceso_id", $this->proceso_activo)
                ->where("subproceso_id", $this->subprocesos_info->id ?? 0)
                ->get(),
            "fechas_registradas" => RegistroFirmas::where("proyecto_id", $this->proyecto_id)
                ->where("proceso_id", $this->proceso_activo)
                ->where("subproceso_id", $this->subprocesos_info->id ?? 0)
                ->first(),
            "autorizacion_catastro" => AutorizacionCatastro::where("proyecto_id", $this->proyecto_id)
                ->where("proceso_id", $this->proceso_activo)
                ->where("subproceso_id", $this->subprocesos_info->id ?? 0)
                ->first(),
            "actos" => Servicios::orderBy('nombre', 'ASC')->get(),
            "uso_de_cuentas" => Catalogos_uso_de_cuentas::orderBy("nombre", "ASC")->get(),
            "tipo_cuentas" => Catalogos_tipo_cuenta::orderBy("nombre", "ASC")->get(),
            "metodos_pago" => CatalogoMetodosPago::orderBy("nombre", "ASC")->get(),
            "cuentas_bancarias" => Cuentas_bancarias::orderBy("banco_id", "ASC")->get(),
        ]);
    }

//================================================== PAGOS ==================================================
    public $total_pago = 0.0;
    public $total_impuestos = 0.0;
    public $fecha_cobro;
    public $nombre_cliente_cobro;
    public $monto_cobro;
    public $metodo_pago_id = '';
    public $factura_id = '';
    public $cuenta_id = '';
    public $observaciones_cobro;

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

    public function abrirModalPagos($monto){
        $this->monto_cobro = $monto;
        return $this->dispatchBrowserEvent('abrir-modal-registrar-pagos');
    }

    public function registrarPago(){
        $this->validate([
            "fecha_cobro" => "required",
            "monto_cobro" => "required",
            "metodo_pago_id" => "required",
        ]);

        $monto_pago = $this->total_pago + $this->total_impuestos;
        if($this->monto_cobro != $monto_pago){
            return$this->addError('monto-no-valido', 'El monto del pago debe ser de $' . number_format($monto_pago, 2));
        }

        $nuevo_cobro = new Cobros;
        $nuevo_cobro->fecha = $this->fecha_cobro;
        $nuevo_cobro->cliente = $this->nombre_cliente_cobro;
        $nuevo_cobro->monto = $this->monto_cobro;
        $nuevo_cobro->metodo_pago_id = $this->metodo_pago_id;
        // $nuevo_cobro->factura_id = $this->factura_id;
        $nuevo_cobro->cuenta_id = $this->cuenta_id;
        $nuevo_cobro->proyecto_id = $this->proyecto_activo['id'];
        $nuevo_cobro->observaciones = $this->observaciones_cobro;
        $nuevo_cobro->usuario_id = auth()->user()->id;
        $nuevo_cobro->save();

        foreach ($this->pagos_checkbox as $key => $value) {
            if($value){
                $costo = Costos::find($key);
                $impuesto = $value * $costo->impuestos / 100;

                $new_costo_cobrado = new CostosCobrados;
                $new_costo_cobrado->monto = $value + $impuesto;
                $new_costo_cobrado->costo_id = $key;
                $new_costo_cobrado->cobro_id = $nuevo_cobro->id;
                $new_costo_cobrado->save();
            }
        }

        $this->pagos_checkbox = [];
        $this->fecha_cobro = '';
        $this->nombre_cliente_cobro = '';
        $this->monto_cobro = '';
        $this->metodo_pago_id = '';
        $this->cuenta_id = '';
        $this->observaciones_cobro = '';

        $this->resetProyect();
        return $this->dispatchBrowserEvent('cerrar-modal-registrar-pagos', 'Pago registrado con exito');
    }

    public function resetProyect(){
        $proyecto = Proyectos::find($this->proyecto_activo['id']);
        $this->proyecto_activo = [];
        $this->proyecto_activo = $proyecto;
    }

//================================================== NUEVO PROYECTO ==================================================
    public $proyecto_abogado;
    public $proyecto_asistentes = [];
    public $proyecto_cliente;
    public $proyecto_descripcion;
    public $proyecto_acto;

    public $acto_juridico_id;
    public $acto_honorarios;
    public $costos_proyecto = [];
    public $conceptos_pago;
    public $acto_descuento;

    public function buscarHonorarios(){
        $actos = Servicios::find($this->acto_juridico_id);
        $this->conceptos_pago = $actos->conceptos_pago;
        $this->acto_honorarios = $actos->honorarios ?? 0.0;
    }

    public function asignar_abogado($abogado){
        $this->proyecto_abogado = $abogado;
        return $this->buscar_abogado = '';
    }

    public function remover_abogado(){
        $this->proyecto_abogado = '';
        return $this->buscar_abogado = '';
    }

    public function agregar_asistente($asistente){
        foreach($this->proyecto_asistentes as $data){
            if($asistente['id'] == $data['id']){
                $this->buscar_abogado = '';
                return $this->addError('asistente-registrado', 'Este usuario ya esta asignado como asistente');
            }
        }
        array_push($this->proyecto_asistentes, $asistente);
        return $this->buscar_abogado = '';
    }

    public function remover_asistente($key){
        unset($this->proyecto_asistentes[$key]);
        return null;
    }

    public function asignar_cliente($cliente){
        $this->proyecto_cliente = $cliente;
        return $this->buscar_cliente = '';
    }

    public function remover_cliente(){
        return $this->proyecto_cliente = '';
    }

    public function modalNuevoProyecto(){
        return $this->dispatchBrowserEvent("abrir-modal-nuevo-proyecto");
    }

    public function crear_proyecto(){
        $this->validate([
            "acto_honorarios" => "required",
            "acto_juridico_id" => "required",
            "proyecto_cliente" => "required",
            "proyecto_abogado" => "required"
        ]);

        $this->acto_honorarios;
        $this->acto_descuento;
        $this->conceptos_pago;

        $nuevo_proyecto = new Proyectos;
        $nuevo_proyecto->servicio_id = $this->acto_juridico_id;
        $nuevo_proyecto->cliente_id = $this->proyecto_cliente['id'];
        $nuevo_proyecto->usuario_id = $this->proyecto_abogado['id'];
        $nuevo_proyecto->honorarios = $this->acto_honorarios;
        $nuevo_proyecto->descuento = $this->acto_descuento ?? 0;
        $nuevo_proyecto->observaciones = $this->proyecto_descripcion;
        $nuevo_proyecto->status = 0;
        $nuevo_proyecto->save();

        if(count($this->proyecto_asistentes) > 0){
            foreach ($this->proyecto_asistentes as $value) {
                $asistentes = new ApoyoProyectos;
                $asistentes->abogado_id = $this->proyecto_abogado['id'];
                $asistentes->abogado_apoyo_id = $value['id'];
                $asistentes->proyecto_id = $nuevo_proyecto->id;
                $asistentes->save();
            }
        }

        if($this->acto_honorarios && $this->acto_honorarios > 0){
            $findConcepto = Catalogos_conceptos_pago::find(22);
            $nuevo_costo = new Costos;
            $nuevo_costo->concepto_id = 22;
            $nuevo_costo->subtotal = $this->acto_honorarios;
            $nuevo_costo->impuestos = $findConcepto->impuestos;
            $nuevo_costo->proyecto_id = $nuevo_proyecto->id;
            $nuevo_costo->save();
        }

        if(count($this->costos_proyecto) > 0){
            foreach ($this->costos_proyecto as $key => $costo) {
                if($costo || $costo > 0){
                    $findConcepto = Catalogos_conceptos_pago::find($key);
                    $nuevo_costo = new Costos;
                    $nuevo_costo->concepto_id = $key;
                    $nuevo_costo->subtotal = $costo;
                    $nuevo_costo->impuestos = $findConcepto->impuestos;
                    $nuevo_costo->proyecto_id = $nuevo_proyecto->id;
                    $nuevo_costo->save();
                }
            }
        }

        return $this->dispatchBrowserEvent('cerrar-modal-nuevo-proyecto', 'Nuevo proyecto creado exitosamente');
    }





//================================================== REGISTROS DE GENERALES ==================================================
    public function registrarGeneral($id){
        $buscar = Generales::where("cliente_id", $id)
            ->where("proyecto_id", $this->proyecto_id)
            ->get();

        if(count($buscar) > 0){
            $this->buscar_cliente = '';
            return $this->addError('cliente-ya-asignado', 'Esta persona ya esta asignada en este proyecto');
        }

        $registrar = new Generales;
        $registrar->cliente_id = $id;
        $registrar->proyecto_id = $this->proyecto_id;
        $registrar->tipo = $this->subprocesos_info->nombre;
        $registrar->tipo_id = $this->subprocesos_info->id;
        $registrar->save();
        $this->buscar_cliente = '';

        return $this->dispatchBrowserEvent('registro-generales', 'Cliente registrado');
    }

    public function removerGenerales($id){
        Generales::find($id)->delete();
        return $this->dispatchBrowserEvent('remover-registro-generales', 'Cliente removido');
    }

    public function subirDocumentoModalGeneral($id){
        // $this->tipo_doc_sub = $tipo;
        $this->cliente_id = $id;
        $this->catalogo_documentos = SubprocesosCatalogos::orderBy("nombre", "ASC")->where("tipo_id", 6)->get();
        return $this->dispatchBrowserEvent('abrir-modal-subir-documentos');
    }

    public function importarDocumentoGeneral(){
        $this->validate([
            'cliente_id' => 'required',
            'proyecto_id' => 'required',
            'documento_pdf' => 'required|mimes:pdf,docx,doc',
            'tipo_documento' => 'required',
        ]);

        $proyecto = Proyectos::find($this->proyecto_id);
        $tipo_doc = SubprocesosCatalogos::find($this->tipo_documento);

        $path = "/uploads/clientes/" . str_replace(" ", "_", $proyecto->cliente->nombre) . "_" . str_replace(" ", "_", $proyecto->cliente->apaterno) . "_" . str_replace(" ", "_", $proyecto->cliente->amaterno) . "/documentos";
        $storeas = $this->documento_pdf->storeAs(mb_strtolower($path), $tipo_doc->nombre . "_" . time() . "." . $this->documento_pdf->extension(), 'public');

        $documento = new Documentos;
        $documento->cliente_id = $this->cliente_id;
        $documento->nombre = $this->documento_pdf->getClientOriginalName();
        $documento->storage = "/storage/" . $storeas;
        $documento->catalogo_id = $this->tipo_documento;
        $documento->proceso_id = $this->proceso_activo;
        $documento->save();

        $this->documento_pdf = '';
        $this->tipo_documento = '';
        $this->cliente_id = '';
        return $this->dispatchBrowserEvent('cerrar-modal-subir-documentos', "Documento registrado");
    }

//================================================== REGISTROS DE DOCUMENTOS ESCRITURA ==================================================

    public function subirDocumentoModalEscritura($tipo){
        $this->tipo_doc_sub = $tipo;
        $array_tipo = [];
        foreach($this->subprocesos_data as $data){
            array_push($array_tipo, $data->catalogosSubprocesos->id);
        }
        $this->catalogo_documentos = SubprocesosCatalogos::orderBy("nombre", "ASC")
            ->where("tipo_id", 6)
            ->whereIn("id", $array_tipo)
            ->get();

        return $this->dispatchBrowserEvent('abrir-modal-subir-documentos');
    }

    public function uploadDocuments(){
        $this->validate([
            'proyecto_id' => 'required',
            'documents_to_upload.*' => 'required|mimes:pdf,docx,doc',
        ]);

        $proyecto = Proyectos::find($this->proyecto_id);
        $path = "/uploads/proyectos/". str_replace(" ", "_", $proyecto->servicio->nombre) . "/" . str_replace(" ", "_", $proyecto->cliente->nombre) . "_" . str_replace(" ", "_", $proyecto->cliente->apaterno) . "_" . str_replace(" ", "_", $proyecto->cliente->amaterno) . "/" . str_replace(" ", "_", $proyecto->servicio->nombre) . "_" .$proyecto->servicio->id . "/documentos";

        foreach($this->documents_to_upload as $document){
            $documento = new Documentos;
            $storeas = $document->storeAs(mb_strtolower($path), $this->subprocesos_info->nombre . "_" . time() . "." . $document->extension(), 'public');
            sleep(1);
            $documento->cliente_id = $proyecto->cliente->id;
            $documento->proyecto_id = $this->proyecto_id;
            $documento->nombre = $document->getClientOriginalName();
            $documento->storage = "/storage/" . $storeas;
            $documento->catalogo_id = $this->subprocesos_info->id;
            $documento->proceso_id = $this->proceso_activo;
            $documento->save();
        }
        return $this->documents_to_upload = [];
    }

    public function removerDocumento($id){
        Documentos::find($id)->delete();
        return $this->dispatchBrowserEvent('remover-documento-escritura', 'Documento borrado');
    }

//================================================== AGENDAR FIRMA DEL POYECTO ==================================================

    public function agendarFirma(){
         $proyecto = Proyectos::find($this->proyecto_id);
         $agregarMinutos = strtotime('+' . $proyecto->servicio->tiempo_firma . ' minute', strtotime($this->fecha_firma));
         $agregarMinutos = date("Y-m-d H:i:s", $agregarMinutos);
         $buscarFirmas = Firmas::where('fecha_inicio', 'LIKE', '%' . date("Y-m-d", strtotime($this->fecha_firma)) . '%')->get();
         $firmasignada = false;
         $i = 0;
         $errorMessage = "";

         if(count($buscarFirmas) > 0){
             do {
                 $firmas = $buscarFirmas[$i];
                 $firstCheck = $this->checkTimeRange(date("H:i", strtotime($firmas['fecha_inicio'])), date("H:i", strtotime($firmas['fecha_fin'])), date("H:i", strtotime($this->fecha_firma)));
                 $secondCheck = $this->checkTimeRange(date("H:i", strtotime($firmas['fecha_inicio'])), date("H:i", strtotime($firmas['fecha_fin'])), date("H:i", strtotime($agregarMinutos)));
                 if($firstCheck == true || $secondCheck == true){
                    $firmasignada = true;
                    $errorMessage = "Esta fecha y hora no esta disponible ya que existe una firma para " . $firmas['nombre'] . " de " . date("H:i", strtotime($firmas['fecha_inicio'])) . " a " . date("H:i", strtotime($firmas['fecha_fin']));
                    $this->fecha_firma = "";
                    return $this->addError('invalidDate', $errorMessage);
                 }else{
                     if($i == count($buscarFirmas) -1){
                         $firmasignada = true;
                     }else{
                         $i++;
                     }
                 }
             } while ($firmasignada == false);
         }
    }

    function checkTimeRange($from, $to, $input){
        $dateFrom = DateTime::createFromFormat('!H:i', $from);
        $dateTo = DateTime::createFromFormat('!H:i', $to);
        $dateInput = DateTime::createFromFormat('!H:i', $input);
        if($dateFrom > $dateTo) $dateTo->modify('+1 day');
        return ($dateFrom <= $dateInput && $dateInput <= $dateTo) || ($dateFrom <= $dateInput->modify('+1 day') && $dateInput <= $dateTo);
    }

    function guardarFechaFirma(){
        $this->validate([
            "fecha_firma" => "required"
        ]);

        if($this->fecha_firma != ""){
            $proyecto = Proyectos::find($this->proyecto_id);
            $agregarMinutos = strtotime('+' . $proyecto->servicio->tiempo_firma . ' minute', strtotime($this->fecha_firma));
            $agregarMinutos = date("Y-m-d H:i:s", $agregarMinutos);

            $newfirma = new Firmas;
            $newfirma->nombre = $proyecto->servicio->nombre;
            $newfirma->fecha_inicio = $this->fecha_firma;
            $newfirma->fecha_fin = $agregarMinutos;
            $newfirma->proceso_id = $this->proceso_activo;
            $newfirma->cliente_id = $proyecto->cliente->id;
            $newfirma->proyecto_id = $proyecto->id;
            $newfirma->save();

            return $this->dispatchBrowserEvent('success-method');
        }
    }

    function cancelarFirma($id){
        Firmas::find($id)->delete();
        return $this->dispatchBrowserEvent('success-method', 'Fecha de firma cancelada');
    }


//================================================== REGISTRAR FECHAS ==================================================
    public function registrarFecha(){
        $this->validate([
            "fecha_a_registrar" => "required"
        ]);

        $proyecto = Proyectos::find($this->proyecto_id);

        $fecha_data = new RegistroFirmas;
        $fecha_data->fechayhora = $this->fecha_a_registrar;
        $fecha_data->nombre = $this->subprocesos_info->nombre;
        $fecha_data->proceso_id = $this->proceso_activo;
        $fecha_data->subproceso_id = $this->subprocesos_info->id;
        $fecha_data->proyecto_id = $this->proyecto_id;
        $fecha_data->cliente_id = $proyecto->cliente->id;
        $fecha_data->save();

        return $this->dispatchBrowserEvent('alert-success', 'Fecha registrada');
    }

    public function eliminarFecha($id){
        RegistroFirmas::find($id)->delete();
        return $this->dispatchBrowserEvent('alert-success', 'Fecha removida');
    }

//================================================== GUARDAR RECIBOS DE PAGO ==================================================
    public $gasto_recibo = 0.0;
    public $gasto_gestoria = 0.0;
    public $gasto_total = 0.0;
    public $recibo_de_pago;
    public $observaciones_pago;
    public $fecha_pago;
    public $concepto_pago;

    public function nuevoRecibo(){
        $array_tipo = [];
        foreach($this->subprocesos_data as $data){
            if ($data->catalogosSubprocesos->tipo_id == 10){
                array_push($array_tipo, $data->catalogosSubprocesos->id);
            }
        }

        $this->catalogo_documentos = SubprocesosCatalogos::orderBy("nombre", "ASC")
            ->where("tipo_id", 10)
            ->whereIn("id", $array_tipo)
            ->get();

        return $this->dispatchBrowserEvent('abrir-modal-subir-recibos-pago');
    }

    public function calcularTotal(){
        if($this->gasto_gestoria == '') $this->gasto_gestoria = 0.0;
        if($this->gasto_recibo == '') $this->gasto_recibo = 0.0;
        $this->gasto_total = $this->gasto_recibo + $this->gasto_gestoria;
    }

    public function guardarRecbio(){
        $this->validate([
            "gasto_recibo" => "required",
            "gasto_gestoria" => "required",
            "fecha_pago" => "required",
            "recibo_de_pago" => $this->recibo_de_pago == '' ? "" : "mimes:pdf",
        ]);

        $proyecto = Proyectos::find($this->proyecto_id);
        $sub = SubprocesosCatalogos::find($this->subprocesos_info->id);
        $path = "/uploads/proyectos/". str_replace(" ", "_", $proyecto->servicio->nombre) . "/" . str_replace(" ", "_", $proyecto->cliente->nombre) . "_" . str_replace(" ", "_", $proyecto->cliente->apaterno) . "_" . str_replace(" ", "_", $proyecto->cliente->amaterno) . "/"  . str_replace(" ", "_", $proyecto->servicio->nombre) . "_" . $proyecto->servicio->id . "/documentos";
        sleep(1);
        $storeas = $this->recibo_de_pago->storeAs(mb_strtolower($path), str_replace(" ", "_", $sub->nombre) . "_" . time() . "." . $this->recibo_de_pago->extension(), 'public');
        $recibo_pago = new RecibosPago;
        if($this->concepto_pago != ''){
            $recibo_pago->nombre = $this->recibo_de_pago->getClientOriginalName();
        }else{
            $recibo_pago->nombre = $this->concepto_pago;
        }
        $recibo_pago->path = "/storage/" . $storeas;
        $recibo_pago->costo_recibo = $this->gasto_recibo;
        $recibo_pago->gastos_gestoria = $this->gasto_gestoria;
        $recibo_pago->proyecto_id = $this->proyecto_id;
        $recibo_pago->proceso_id = $this->proceso_activo;
        $recibo_pago->subproceso_id = $this->subprocesos_info->id;
        $recibo_pago->fecha_pago = $this->fecha_pago;
        $recibo_pago->observaciones = $this->observaciones_pago;
        $recibo_pago->save();

        $this->recibo_de_pago = "";
        $this->tipo_documento = "";
        $this->gasto_recibo = 0;
        $this->gasto_gestoria = 0;
        $this->gasto_total = 0;
        $this->observaciones_pago = '';
        $this->fecha_pago = '';

        return $this->dispatchBrowserEvent("alert-success", "Recibo de pago guardado con exito");
    }

    public function borrarRecibo($id){
        RecibosPago::find($id)->delete();
    }

//================================================== GUARDAR AUTORIZACION CATASTRO ==================================================
    public $numero_comprobante;
    public $cuenta_predial;
    public $clave_catastral;

    public function registrar_autorizacion(){
        $autorizacion = new AutorizacionCatastro;
        $autorizacion->comprobante = $this->numero_comprobante;
        $autorizacion->cuenta_predial = $this->cuenta_predial;
        $autorizacion->clave_catastral = $this->clave_catastral;
        $autorizacion->proceso_id = $this->proceso_activo;
        $autorizacion->subproceso_id = $this->subprocesos_info->id;
        $autorizacion->proyecto_id = $this->proyecto_id;
        $autorizacion->save();
        return $this->dispatchBrowserEvent("alert-success", "Autorizacion registrada");
    }

    public function borrar_autorizacion($id){
        AutorizacionCatastro::find($id)->delete();
    }

//================================================== GUARDAR AVANCE DE LA ESCRITURA ==================================================

    public function guardarAvance(){
        $avance = new AvanceProyecto;
        $avance->proyecto_id = $this->proyecto_id;
        $avance->proceso_id = $this->proceso_activo;
        $avance->subproceso_id = $this->subproceso_activo->subproceso_id;
        $avance->save();
        return $this->dispatchBrowserEvent('registrar-avance', "Avance registrado");
    }

    public function guardarAvanceDocumentos(){
        $documentos = Documentos::where("proyecto_id", $this->proyecto_id)->get();
        $guardardo = false;
        if(count($documentos) > 0){
            foreach($this->subprocesos_data as $data){
                foreach($documentos as $documento){
                    if($data->catalogosSubprocesos->id == $documento->catalogo_id){
                        $buscarAvance = AvanceProyecto::where("proyecto_id", $this->proyecto_id)
                            ->where("proceso_id", $data->proceso_id)
                            ->where("subproceso_id", $data->subproceso_id)
                            ->first();
                        if(!$buscarAvance){
                            $avance = new AvanceProyecto;
                            $avance->proyecto_id = $this->proyecto_id;
                            $avance->proceso_id = $data->proceso_id;
                            $avance->subproceso_id = $data->subproceso_id;
                            $avance->save();
                            $guardardo = true;
                        }
                    }
                }
            }
        }

        // $this->subprocesosData($this->proceso_activo);

        if($guardardo){
            return $this->dispatchBrowserEvent('documentacion-guardada', "Documentos guardados");
        }
        return $this->dispatchBrowserEvent('documentacion-no-guardada', "Ningun documento guardado");
    }

    public function guardarAvanceRecibosPago(){
        $documentos = RecibosPago::where("proyecto_id", $this->proyecto_id)->get();
        $guardardo = false;
        if(count($documentos) > 0){
            foreach($this->subprocesos_data as $data){
                foreach($documentos as $documento){
                    if($data->catalogosSubprocesos->id == $documento->subproceso_id){
                        $buscarAvance = AvanceProyecto::where("proyecto_id", $this->proyecto_id)
                            ->where("proceso_id", $data->proceso_id)
                            ->where("subproceso_id", $data->subproceso_id)
                            ->first();
                        if(!$buscarAvance){
                            $avance = new AvanceProyecto;
                            $avance->proyecto_id = $this->proyecto_id;
                            $avance->proceso_id = $data->proceso_id;
                            $avance->subproceso_id = $data->subproceso_id;
                            $avance->save();
                            $guardardo = true;
                        }
                    }
                }
            }
        }

        // $this->subprocesosData($this->proceso_activo);
        if($guardardo){
            return $this->dispatchBrowserEvent('alert-success', "Avance registrado");
        }
        return $this->dispatchBrowserEvent('alert-error', "Ningun registro para el avance");
    }
//================================================== PROCESOS Y SUBPROCESOS ==================================================
    public $active_sub = 1;
    public $proyecto_activo = [];
    public function openProcesos($proyecto_id){
        $this->active_sub = 1;
        $this->proyecto_id = $proyecto_id;
        $this->proyecto_activo = Proyectos::find($proyecto_id);
        $this->procesos_data = $this->proyecto_activo->servicio->procesos;
        $this->subprocesos_data = $this->procesos_data[0]->subprocesos;
        $this->proceso_activo = $this->procesos_data[0]->id;
        $this->subproceso_activo = Subprocesos::find($this->subprocesos_data[0]->id);
        $this->subprocesos_info = SubprocesosCatalogos::find($this->subproceso_activo->catalogosSubprocesos->id);
        $this->tipo_subproceso = $this->subprocesos_info->tipo_id;
    }

    public function closeProcesos(){
        $this->procesos_data = [];
        $this->subprocesos_data = [];
        $this->documents_to_upload = [];
        $this->subproceso_activo = [];
        $this->subprocesos_info = [];
        $this->proyecto_activo = [];
        $this->proceso_activo = "";
        $this->tipo_subproceso = '';
        return $this->dispatchBrowserEvent('cerrar-modal-procesos-escritura');
    }

    public function subprocesosTimeline($proceso_id){
        $this->active_sub = 1;
        $this->subprocesos_data = [];
        $this->documents_to_upload = [];
        $this->subproceso_activo = [];
        $this->subprocesos_info = [];

        $this->proceso_activo = $proceso_id;
        $proceso = ProcesosServicios::find($proceso_id);
        $this->subprocesos_data = $proceso->subprocesos;

        $this->subproceso_activo = Subprocesos::find($this->subprocesos_data[0]->id);
        $this->subprocesos_info = SubprocesosCatalogos::find($this->subproceso_activo->catalogosSubprocesos->id);
        $this->tipo_subproceso = $this->subprocesos_info->tipo_id;
    }

    public function subprocesosData($id, $active){
        $this->active_sub = $active;
        $this->documents_to_upload = [];
        $this->subproceso_activo = Subprocesos::find($id);
        $this->subprocesos_info = SubprocesosCatalogos::find($this->subproceso_activo->catalogosSubprocesos->id);
        $this->tipo_subproceso = $this->subprocesos_info->tipo_id;
    }

}

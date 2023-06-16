<?php

namespace App\Http\Livewire;

use App\Models\ApoyoProyectos;
use App\Models\AutorizacionCatastro;
use App\Models\AvanceProyecto;
use App\Models\CatalogoMetodosPago;
use App\Models\Catalogos_conceptos_pago;
use App\Models\Catalogos_tipo_cuenta;
use App\Models\Catalogos_uso_de_cuentas;
use App\Models\CatalogoTipoActos;
use App\Models\Clientes;
use App\Models\Cobros;
use App\Models\Comisiones;
use App\Models\Costos;
use App\Models\CostosCobrados;
use App\Models\Cuentas_bancarias;
use App\Models\Documentos;
use App\Models\Egresos;
use App\Models\Facturas;
use App\Models\Firmas;
use App\Models\Generales;
use App\Models\ObservacionesProyectos;
use App\Models\Partes;
use App\Models\ProcesosServicios;
use App\Models\Promotores;
use App\Models\Proyectos;
use App\Models\RecibosPago;
use App\Models\RegistroFirmas;
use App\Models\Servicios;
use App\Models\Subprocesos;
use App\Models\SubprocesosCatalogos;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Luecano\NumeroALetras\NumeroALetras;
use PhpOffice\PhpWord\TemplateProcessor;

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

    public $vistaComisiones = 0;
    public $abogado_proyecto = "";
    public $tipo_acto_id = "";

    public function render()
    {
        return view('livewire.escrituras-proceso', [
            "clientes" =>  $this->buscar_cliente == '' ? [] : Clientes::orderBy("nombre", "ASC")
                ->where('nombre', 'LIKE', '%' . $this->buscar_cliente . '%')
                ->orWhere('apaterno', 'LIKE', '%' . $this->buscar_cliente . '%')
                ->orWhere('amaterno', 'LIKE', '%' . $this->buscar_cliente . '%')
                ->get(),
            "abogados_proyectos" => User::orderBy("name", "ASC")
                ->whereHas("roles", function($data){
                    $data->where('name', '!=', 'ADMINISTRADOR');
            })->get(),
            "tipo_actos" => CatalogoTipoActos::orderBy("nombre", "ASC")->get(),
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
            "escrituras" =>
                Proyectos::orderBy("numero_escritura", "ASC")
                ->whereHas('servicio.tipo_acto', function(Builder $serv){
                    $serv->where('id', 'LIKE', '%'. $this->tipo_acto_id .'%');
                })
                // ->where('status', '!=', 5)
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
                ->paginate($this->cantidad_escrituras ),
            "generales" => Generales::where("proyecto_id", $this->proyecto_id)
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
            "catalogo_conceptos" => Catalogos_conceptos_pago::orderBy("descripcion", "ASC")->get(),
            "cliente_partes" => $this->buscarClienteParte != '' ? Clientes::orderBy("nombre", "ASC")
                ->where("nombre", "LIKE", "%" . $this->buscarClienteParte . "%")
                ->orwhere("apaterno", "LIKE", "%" . $this->buscarClienteParte . "%")
                ->orwhere("amaterno", "LIKE", "%" . $this->buscarClienteParte . "%")
                ->get()
            : [],
            "tipo_docs" => SubprocesosCatalogos::orderBy("nombre", "ASC")->where("tipo_id", "6")->get()
        ]);
    }

// Partes
public $vistaPartes = 0;
public $clienteParte;
public $buscarClienteParte;
public $copropietario_parte = false;
public $persona_moral = false;
public $nombre_parte;
public $paterno_parte;
public $materno_parte;
public $curp_parte;
public $rfc_parte;
public $tipo_parte = "";
public $porcentaje_copropietario;


public function cambiarVistaPartes($vista){
    $this->vistaPartes = $vista;
}

public function asignarCliente($cliente){
    $this->clienteParte = $cliente;
    $this->nombre_parte = $cliente['nombre'];
    $this->paterno_parte = $cliente['apaterno'];
    $this->materno_parte = $cliente['amaterno'];
    $this->curp_parte = $cliente['curp'];
    $this->rfc_parte = $cliente['rfc'];
    $this->buscarClienteParte = "";
}

public function limpiarVariablesPartes(){
    $this->nombre_parte = '';
    $this->paterno_parte = '';
    $this->materno_parte = '';
    $this->curp_parte = '';
    $this->rfc_parte = '';
    $this->tipo_parte = '';
    $this->porcentaje_copropietario = '';
    $this->persona_moral = false;
    $this->copropietario_parte = false;
    $this->clienteParte = '';
}

public $nuevoCliente = false;
public function cambiarRegistroCliente($id){
    $this->nuevoCliente = $id == 1 ? true : false;
}

public function registrarParte(){
    $this->validate([
        "nombre_parte" => "required",
        "porcentaje_copropietario" => $this->copropietario_parte ? "required" : "",
        "tipo_parte" => "required"
    ]);

    $parte = new Partes;
    $parte->nombre = $this->nombre_parte;
    $parte->apaterno = $this->paterno_parte;
    $parte->amaterno = $this->materno_parte;
    $parte->tipo_persona = !$this->persona_moral ? "Persona Fisica" : "Persona Moral";
    $parte->curp = $this->curp_parte;
    $parte->rfc = $this->rfc_parte;
    $parte->tipo = $this->tipo_parte;
    $parte->porcentaje = $this->porcentaje_copropietario == '' ? 0 : $this->porcentaje_copropietario;
    $parte->proyecto_id = $this->proyecto_activo['id'];
    $parte->cliente_id = $this->clienteParte['id'];
    $parte->save();

    $this->limpiarVariablesPartes();
    $this->resetProyect();
    $this->dispatchBrowserEvent('success-event', 'Parte agregada');
    return $this->cambiarVistaPartes(0);
}

public function removerParte($id){
    Partes::find($id)->delete();
    return $this->resetProyect();
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
    public $costos_a_egresar = [];

    public $concepto_factura = "";
    public $monto_factura;
    public $folio_factura;
    public $rfc_factura;
    public $fecha_factura;
    public $origen_factura = "";
    public $comentarios_factura;
    public $xml_factura;
    public $pdf_factura;

    public $observaciones_proyecto;

    public $nombre_promotor;
    public $apaterno_promotor;
    public $amaterno_promotor;
    public $telefono_promotor;
    public $email_promotor;
    public $promotores = [];
    public $promotor_asignado;
    public $buscarPromotor;

    public $cantidad_comision;
    public $observaciones_comision;

    public function updatingBuscarPromotor(){
        $this->promotores = $this->buscarPromotor ? Promotores::orderBy("nombre", "asc")
            ->where('nombre', 'like', '%' . $this->buscarPromotor . '%')
            ->orwhere('apaterno', 'like', '%' . $this->buscarPromotor . '%')
            ->orwhere('amaterno', 'like', '%' . $this->buscarPromotor . '%')
            ->get() : [];
    }

    public function asignarPromotor($promotor){
        $this->promotor_asignado = $promotor;
        $this->buscarPromotor = "";
    }

    public function registrarComision(){
        $this->validate([
            "promotor_asignado" => "required",
            "cantidad_comision" => "required",
        ]);

        $comision = new Comisiones;
        $comision->promotor_id = $this->promotor_asignado['id'];
        $comision->proyecto_id = $this->proyecto_activo['id'];
        $comision->cantidad = $this->cantidad_comision;
        $comision->observaciones = $this->observaciones_comision ?? "";
        $comision->save();

        $this->promotor_asignado = '';
        $this->observaciones_comision = '';
        $this->cantidad_comision = '';
        $this->dispatchBrowserEvent('success-event', 'Comisión registrada');
        $this->resetProyect();
        return $this->cambiarVistaComision(0);
    }

    public function editarComision($id){
        $comision = Comisiones::find($id);
        $this->promotor_asignado = $comision->promotor;
        $this->observaciones_comision = $comision->observaciones;
        $this->cantidad_comision = $comision->cantidad;
        return $this->cambiarVistaComision(1);
    }

    public function removerPromotor(){
        $this->promotor_asignado = "";
    }

    public function cambiarVistaComision($vista){
        if($vista == 0){
            $this->promotor_asignado = '';
            $this->observaciones_comision = '';
            $this->cantidad_comision = '';
        }

        return $this->vistaComisiones = $vista;
    }

    public function open_modal_registrar_factura(){
        return $this->dispatchBrowserEvent("abrir-modal-registrar-facturas");
    }

    public function open_modal_observaciones(){
        return $this->dispatchBrowserEvent("abrir-modal-registrar-observaciones");
    }

    public function registrarPromotor(){
        $this->validate([
            "nombre_promotor" => "required",
            "apaterno_promotor" => "required",
            "email_promotor" => $this->email_promotor ? "email" : ""
        ]);

        $promotor = new Promotores;
        $promotor->nombre = $this->nombre_promotor;
        $promotor->apaterno = $this->apaterno_promotor;
        $promotor->amaterno = $this->amaterno_promotor ?? "";
        $promotor->telefono = $this->telefono_promotor ?? "";
        $promotor->email = $this->email_promotor ?? "";
        $promotor->save();

        $this->nombre_promotor = '';
        $this->apaterno_promotor = '';
        $this->amaterno_promotor = '';
        $this->telefono_promotor = '';
        $this->email_promotor = '';
        $this->dispatchBrowserEvent('success-event', 'Promotor registrado');
        return $this->cambiarVistaComision(1);
    }

    public function registrar_observaciones(){
        $this->validate([
            "observaciones_proyecto" => "required",
        ]);
        $new_observacion = new ObservacionesProyectos;
        $new_observacion->comentarios = $this->observaciones_proyecto;
        $new_observacion->user_id = Auth::user()->id;
        $new_observacion->proyecto_id = $this->proyecto_activo['id'];
        $new_observacion->save();
        $this->resetProyect();
        agregar_observaciones_firebase($new_observacion->id);
        return $this->dispatchBrowserEvent("cerrar-modal-registrar-observaciones", "Observaciones registradas");
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

        $fatura = new Facturas;
        $fatura->monto = $this->monto_factura;
        $fatura->folio_factura = $this->folio_factura;
        $fatura->rfc_receptor = $this->rfc_factura;
        $fatura->fecha = $this->fecha_factura;
        $fatura->origen = $this->origen_factura;
        $fatura->concepto_pago_id = $this->concepto_factura;
        $fatura->observaciones = $this->comentarios_factura ?? "";

        if($this->xml_factura){
            $path_xml = "/uploads/clientes/" . str_replace(" ", "_", $this->proyecto_activo['cliente']['nombre']) . "_" . str_replace(" ", "_", $this->proyecto_activo['cliente']['apaterno']) . "_" . str_replace(" ", "_", $this->proyecto_activo['cliente']['amaterno']) . "/documentos/facturas";
            $store_xml = $this->xml_factura->storeAs(mb_strtolower($path_xml), $this->concepto_factura . "_" . time() . "." . $this->xml_factura->extension(), 'public');
            $fatura->xml = $store_xml;
        }

        if($this->pdf_factura){
            $path_pdf = "/uploads/clientes/" . str_replace(" ", "_", $this->proyecto_activo['cliente']['nombre']) . "_" . str_replace(" ", "_", $this->proyecto_activo['cliente']['apaterno']) . "_" . str_replace(" ", "_", $this->proyecto_activo['cliente']['amaterno']) . "/documentos/facturas";
            $store_pdf = $this->pdf_factura->storeAs(mb_strtolower($path_pdf), $this->concepto_factura . "_" . time() . "." . $this->pdf_factura->extension(), 'public');
            $fatura->pdf = $store_pdf;
        }

        $fatura->proyecto_id = $this->proyecto_activo['id'];
        $fatura->proyecto_id = $this->proyecto_activo['id'];
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
        $this->resetProyect();
        return $this->dispatchBrowserEvent("cerrar-modal-registrar-facturas", "Factura registrada");
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

    public function abrirModalPagos(){
        return $this->dispatchBrowserEvent('abrir-modal-registrar-pagos');
    }

    public function registrarPago(){
        $this->validate([
            "fecha_cobro" => "required",
            "monto_cobro" => "required",
            "metodo_pago_id" => "required",
        ]);

        $nuevo_cobro = new Cobros;
        $nuevo_cobro->fecha = $this->fecha_cobro;
        $nuevo_cobro->cliente = $this->nombre_cliente_cobro == '' ? null : $this->nombre_cliente_cobro;
        $nuevo_cobro->monto = $this->monto_cobro;
        $nuevo_cobro->metodo_pago_id = $this->metodo_pago_id;
        $nuevo_cobro->cuenta_id = $this->cuenta_id == '' ? null : $this->cuenta_id;
        $nuevo_cobro->proyecto_id = $this->proyecto_activo['id'];
        $nuevo_cobro->observaciones = $this->observaciones_cobro;
        $nuevo_cobro->usuario_id = Auth::user()->id;
        $nuevo_cobro->save();

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

    public $costo_id;
    public $concepto_costo_id = '';
    public $monto_costo;
    public $gestoria_costo;
    public $impuestos_costo;

    public function clearCostosForm(){
        $this->costo_id = '';
        $this->concepto_costo_id = '';
        $this->monto_costo = '';
        $this->gestoria_costo = '';
        $this->impuestos_costo = '';
    }

    public function abrirModalNuevoCosto(){
        return $this->dispatchBrowserEvent("abrir-modal-registrar-costo");
    }

    public function editarCosto($id){
        $costo = Costos::find($id);
        $this->costo_id = $costo->id;
        $this->concepto_costo_id = $costo->concepto_id;
        $this->monto_costo = $costo->subtotal;
        $this->gestoria_costo = $costo->gestoria;
        $this->impuestos_costo = $costo->impuestos;
        return $this->dispatchBrowserEvent("abrir-modal-registrar-costo");
    }

    public function agregarCosto(){
        $this->validate([
            "concepto_costo_id" => "required",
            "monto_costo" => "required",
        ]);

        if($this->costo_id != ""){
            $costo = Costos::find($this->costo_id);
            $costo->concepto_id = $this->concepto_costo_id;
            $costo->subtotal = doubleval($this->monto_costo);
            $costo->gestoria = doubleval($this->gestoria_costo);
            $costo->impuestos = doubleval($this->impuestos_costo);
            $costo->save();
            $this->clearCostosForm();
            $this->resetProyect();
            return $this->dispatchBrowserEvent('cerrar-modal-registrar-costo', 'Costo editado');
        }

        $costo = new Costos;
        $costo->concepto_id = $this->concepto_costo_id;
        $costo->subtotal = doubleval($this->monto_costo);
        $costo->gestoria = doubleval($this->gestoria_costo ?? 0);
        $costo->impuestos = doubleval($this->impuestos_costo ?? 0);
        $costo->proyecto_id = $this->proyecto_activo['id'];
        $costo->save();
        $this->resetProyect();
        $this->clearCostosForm();
        return $this->dispatchBrowserEvent('cerrar-modal-registrar-costo', 'Costo agregado');
    }

    public function clearEgresos(){
        $this->costos_a_egresar = [];
    }

    public $metodo_pago_egreso = '';
    public $fecha_egreso;
    public $comentarios_egreso;

    public function registrarEgreso(){
        $this->validate([
            'metodo_pago_egreso' => 'required',
            'fecha_egreso' => 'required',
        ]);

        foreach ($this->costos_a_egresar as $key => $value) {
            $nuevoEgreso = new Egresos;
            $nuevoEgreso->costo_id = $value['id'];
            $nuevoEgreso->proyecto_id = $this->proyecto_activo['id'];
            $nuevoEgreso->monto = $value['subtotal'];
            $nuevoEgreso->gestoria = $value['gestoria'];
            $nuevoEgreso->impuestos = $value['subtotal'] * $value['impuestos'] / 100;
            $nuevoEgreso->fecha_egreso = $this->fecha_egreso;
            $nuevoEgreso->comentarios = $this->comentarios_egreso ?? null;
            $nuevoEgreso->save();
        }

        $this->resetProyect();
        return $this->dispatchBrowserEvent('cerrar-modal-registrar-egresos');
    }

    public function abrirModalEgresos(){
        $this->costos_a_egresar = [];


        foreach($this->pagos_checkbox as $key => $concepto){
            if($concepto){
                $buscarConcepto = Costos::find($key);
                if(isset($buscarConcepto->egreso->id)){
                    return $this->dispatchBrowserEvent('dangert-notify', "Ya existe egreso de un costo seleccionado, porfavor verifique");
                }
                array_push($this->costos_a_egresar, $buscarConcepto);
            }
        }
        return $this->dispatchBrowserEvent('abrir-modal-registrar-egresos');
    }

//================================================== NUEVO PROYECTO ==================================================
    public $proyecto_abogado;
    public $proyecto_asistentes = [];
    public $proyecto_cliente;
    public $proyecto_descripcion;
    public $proyecto_acto;
    public $tipo_servicio = '';

    public $acto_juridico_id = '';
    public $acto_honorarios;
    public $costos_proyecto = [];
    public $conceptos_pago;

    public $numero_escritura;
    public $volumen_escritura;

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

    public function modalAgregarConcepto(){
        return $this->dispatchBrowserEvent("abrir-modal-agregar-concepto-pago");
    }

    public function agregarConcepto(){
        $this->validate([
            "concepto_costo_id" => "required"
        ]);
        $buscarConcepto = Catalogos_conceptos_pago::find($this->concepto_costo_id);
        $array_temp = [];
        if($buscarConcepto){
            foreach ($this->conceptos_pago as $value) {
                array_push($array_temp, $value);
            }
            array_push($array_temp, $buscarConcepto);
        }
        $this->conceptos_pago = $array_temp;

        $this->concepto_costo_id = "";
        return $this->dispatchBrowserEvent("cerrar-modal-agregar-concepto-pago", "Concepto de pago agregado");
    }

    public $acto_juridico_data;
    public function crear_proyecto(){
        $this->validate([
            "acto_honorarios" => "required",
            "acto_juridico_id" => "required",
            "proyecto_cliente" => "required",
            "proyecto_abogado" => "required",
            "tipo_servicio" => $this->acto_juridico_id == 25 ? "required" : "",
        ],[
            "acto_honorarios.required" => "Es necesario colocar los honorarios",
            "acto_juridico_id.required" => "Es necesario seleccionar el acto juridico",
            "proyecto_cliente.required" => "Es necesario seleccionar el cliente",
            "proyecto_abogado.required" => "Es necesario seleccionar el abogado",
            "numero_escritura.required" => "Es necesario el número de escritura",
            "volumen_escritura.required" => "Es necesario el volumen de la escritura",
            "tipo_servicio.required" => "Es necesario el tipo de acta",
        ]);

        // $this->acto_juridico_data = Servicios::find($this->acto_juridico_id);
        // $buscar_proyecto = Proyectos::whereHas('servicio.tipo_acto', function(Builder $serv){
        //     $serv->where('id', $this->acto_juridico_data['tipo_id']);
        // })
        // ->where("numero_escritura", $this->numero_escritura)->first();
        // if($buscar_proyecto){
        //     return $this->addError("numero_escritura", "El numero de escritura ya esta registrado");
        // }

        $nuevo_proyecto = new Proyectos;
        $nuevo_proyecto->servicio_id = $this->acto_juridico_id;
        $nuevo_proyecto->tipo_servicio = $this->tipo_servicio;
        $nuevo_proyecto->cliente_id = $this->proyecto_cliente['id'];
        $nuevo_proyecto->usuario_id = $this->proyecto_abogado['id'];
        $nuevo_proyecto->honorarios = $this->acto_honorarios;
        $nuevo_proyecto->observaciones = $this->proyecto_descripcion;
        $nuevo_proyecto->status = 0;
        // $nuevo_proyecto->numero_escritura = $this->numero_escritura;
        // $nuevo_proyecto->volumen = $this->volumen_escritura;
        $nuevo_proyecto->save();

        // if(count($this->proyecto_asistentes) > 0){
        //     foreach ($this->proyecto_asistentes as $value) {
        //         $asistentes = new ApoyoProyectos;
        //         $asistentes->abogado_id = $this->proyecto_abogado['id'];
        //         $asistentes->abogado_apoyo_id = $value['id'];
        //         $asistentes->proyecto_id = $nuevo_proyecto->id;
        //         $asistentes->save();
        //     }
        // }

        if($this->acto_honorarios && $this->acto_honorarios > 0){
            $findConcepto = Catalogos_conceptos_pago::find(22);
            $nuevo_costo = new Costos;
            $nuevo_costo->concepto_id = 35;
            $nuevo_costo->subtotal = $this->acto_honorarios;
            $nuevo_costo->impuestos = $findConcepto->impuestos ?? 0;
            $nuevo_costo->proyecto_id = $nuevo_proyecto->id;
            $nuevo_costo->gestoria = 0.0;
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
                    $nuevo_costo->gestoria = 0.0;
                    $nuevo_costo->save();
                }
            }
        }

        $this->acto_juridico_id = '';
        $this->proyecto_cliente = '';
        $this->proyecto_abogado = '';
        $this->acto_honorarios = '';
        $this->proyecto_descripcion = '';
        $this->numero_escritura = '';
        $this->volumen_escritura = '';
        $this->costos_proyecto = [];

        create_firebase_project($nuevo_proyecto->id);
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
        $avance->usuario_id = Auth::user()->id;
        $avance->save();
        return $this->dispatchBrowserEvent('registrar-avance', "Avance registrado");
    }

    public function open_moda_omitir(){
        return $this->dispatchBrowserEvent('abrir-modal-omitir-subproceso');
    }

    public function omitir_subproceso(){
        $avance = new AvanceProyecto;
        $avance->proyecto_id = $this->proyecto_id;
        $avance->proceso_id = $this->proceso_activo;
        $avance->subproceso_id = $this->subproceso_activo->subproceso_id;
        $avance->omitido = 1;
        $avance->usuario_id = Auth::user()->id;
        $avance->save();
        $this->dispatchBrowserEvent('cerrar-modal-omitir-subproceso');
        return $this->dispatchBrowserEvent('registrar-avance', "Subproceso omitido");
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
                            $avance->usuario_id = Auth::user()->id;
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
                            $avance->usuario_id = Auth::user()->id;
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
        return $this->dispatchBrowserEvent("abrir-modal-procesos-escritura");
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
        $this->vista_general = "general";

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

    public function crear_recibo($id){
        $pago = Cobros::find($id);
        // $fecha_escrita = Carbon::parse($pago->fecha)->isoFormat('dddd D \d\e MMMM \d\e\l Y \a \l\a\s h:m A');
        $fecha_escrita = Carbon::parse($pago->fecha)->isoFormat('dddd D \d\e MMMM');
        $cliente = $pago->cliente == '' ? $pago->proyecto->cliente->nombre . " " . $pago->proyecto->cliente->apaterno . " " . $pago->proyecto->cliente->amaterno : $pago->cliente;
        $cantidad = number_format($pago->monto, 2);
        $cantidad_escrita = new NumeroALetras();
        $cantidad_esc = $cantidad_escrita->toWords($pago->monto);
        $acto = $pago->proyecto->servicio->nombre;

        $dia = date("d", strtotime($pago->fecha));
        $mes = date("m", strtotime($pago->fecha));
        $year = date("Y", strtotime($pago->fecha));

        $dia_escrito = Carbon::parse($pago->fecha)->isoFormat('dddd');
        $mes_escrito = Carbon::parse($pago->fecha)->isoFormat('MMMM');

        $new_year = new NumeroALetras();
        $year_escrito = $new_year->toWords($year);

        $templateprocessor = new TemplateProcessor('word-template/recibo_pago.docx');
        $templateprocessor->setValue('fecha_escrita', $fecha_escrita);
        $templateprocessor->setValue('nombre', $cliente);
        $templateprocessor->setValue('acto', $acto);
        $templateprocessor->setValue('cantidad', $cantidad);
        $templateprocessor->setValue('cantidad_escrita', $cantidad_esc);
        $templateprocessor->setValue('dia', $dia);
        $templateprocessor->setValue('dia_escrito', $dia_escrito);
        $templateprocessor->setValue('mes', $mes);
        $templateprocessor->setValue('mes_escrito', $mes_escrito);
        $templateprocessor->setValue('year', $year);
        $templateprocessor->setValue('year_escrito', $year_escrito);
        $templateprocessor->setValue('usuario_receptor', Auth::user()->name . " " . Auth::user()->apaterno . " " . Auth::user()->amaterno);

        $filename = "Recibo de pago " . $cliente;
        $templateprocessor->saveAs($filename . '.docx');
        return response()->download($filename . ".docx")->deleteFileAfterSend(true);
    }


    public $check_cliente = true;
    public $nombre_quien_recibe;

    public function crear_recibo_entrega(){
        if(!$this->check_cliente){
            $this->validate([
                    "nombre_quien_recibe" => "required"
                ],
                ['nombre_quien_recibe.required' => "Es necesario el nombre de la persona que recibe la escritura"]
            );
        }

        $fecha_escrita = Carbon::parse(now())->isoFormat('dddd D \d\e MMMM');

        if($this->check_cliente){
            $cliente = $this->proyecto_activo['cliente']['nombre'] . " " . $this->proyecto_activo['cliente']['apaterno'] . " " . $this->proyecto_activo['cliente']['amaterno'];
        }else{
            $cliente = $this->nombre_quien_recibe;
        }

        $acto = $this->proyecto_activo['servicio']['nombre'];
        $dia = date("d", strtotime(now()));
        $mes = date("m", strtotime(now()));
        $year = date("Y", strtotime(now()));

        $dia_escrito = Carbon::parse(now())->isoFormat('dddd');
        $mes_escrito = Carbon::parse(now())->isoFormat('MMMM');

        $new_year = new NumeroALetras();
        $year_escrito = $new_year->toWords($year);

        $templateprocessor = new TemplateProcessor('word-template/recibo_entrega.docx');
        $templateprocessor->setValue('fecha_escrita', $fecha_escrita);
        $templateprocessor->setValue('nombre', $cliente);
        $templateprocessor->setValue('acto', $acto);
        $templateprocessor->setValue('dia', $dia);
        $templateprocessor->setValue('dia_escrito', $dia_escrito);
        $templateprocessor->setValue('mes', $mes);
        $templateprocessor->setValue('mes_escrito', $mes_escrito);
        $templateprocessor->setValue('year', $year);
        $templateprocessor->setValue('year_escrito', $year_escrito);

        $filename = "Recibo de entrega " . $cliente;
        $templateprocessor->saveAs($filename . '.docx');
        return response()->download($filename . ".docx")->deleteFileAfterSend(true);
    }

    public $vista_general = "general";

    public function vista_general_modal($vista){
        $this->vista_general = $vista;
    }

    public $proyecto_id_general;
    public $numero_escritura_general;
    public $volumen_general;
    public $folio_inicio_general;
    public $folio_fin_general;

    public function cambiar_info_proyecto($id){
        $proyecto = Proyectos::find($id);
        $this->proyecto_id_general = $proyecto->id;
        $this->numero_escritura_general = $proyecto->numero_escritura;
        $this->volumen_general = $proyecto->volumen;
        $this->folio_inicio_general = $proyecto->folio_inicio;
        $this->folio_fin_general = $proyecto->folio_fin;
        $this->abogado_proyecto = $proyecto->usuario_id;
        return $this->vista_general_modal("editar_escritura_volumen");
    }


    public $acto_juridico_tipo;
    public function guardar_escritura_volumen(){
        $this->validate([
                "numero_escritura_general" => 'required',
                "volumen_general" => "required",
                "abogado_proyecto" => "required",
            ],
            [
                "numero_escritura_general.required" => "Es necesario el numero de escritura para continuar",
                "numero_escritura_general.unique" => "Este numero de escritura ya esta registrado",
                "volumen_general.required" => "Es necesario el volumen para continuar",
                "abogado_proyecto.required" => "Es necesario seleccionar un abogado para continuar",
            ]
        );

        $this->acto_juridico_tipo = Servicios::find($this->proyecto_activo['servicio']['id']);
        $buscar_proyecto = Proyectos::whereHas('servicio.tipo_acto', function(Builder $serv){
            $serv->where('id', $this->acto_juridico_tipo['tipo_id']);
        })
        ->where("numero_escritura", $this->numero_escritura_general)->first();

        if($buscar_proyecto && $buscar_proyecto->numero_escritura != $this->proyecto_activo['numero_escritura']){
            return $this->addError("numero_escritura_general", "Este número ya esta registrado");
        }

        $buscar_pendiente = Proyectos::where("numero_escritura", $this->numero_escritura_general)
            ->where("status", 5)
            ->first();

        if($buscar_pendiente){
            return $this->addError("numero_escritura_general", "Este número ya esta registrado");
        }

        $proyecto = Proyectos::find($this->proyecto_activo['id']);
        $proyecto->numero_escritura = $this->numero_escritura_general;
        $proyecto->volumen = $this->volumen_general;
        $proyecto->folio_inicio = $this->folio_inicio_general;
        $proyecto->folio_fin = $this->folio_fin_general;
        $proyecto->usuario_id = $this->abogado_proyecto;
        $proyecto->save();

        $this->numero_escritura_general = "";
        $this->volumen_general = "";
        $this->folio_inicio_general = "";
        $this->folio_fin_general = "";

        $this->resetProyect();
        $this->vista_general_modal("general");
        edit_firebase_project($proyecto->id);
        return $this->dispatchBrowserEvent("alert-success", "Informacion del proyecto registrada");
    }

    public function terminarProyecto(){
        if($this->proyecto_activo['numero_escritura'] == '' || !$this->proyecto_activo['numero_escritura']){
            return $this->dispatchBrowserEvent("dangert-notify", "El proyecto necesita tener numero de escritura");
        }

        if($this->proyecto_activo['volumen'] == '' || !$this->proyecto_activo['volumen']){
            return $this->dispatchBrowserEvent("dangert-notify", "El proyecto necesita tener volumen asignado");
        }

        if(!$this->proyecto_activo['folio_inicio'] || !$this->proyecto_activo['folio_inicio']){
            return $this->dispatchBrowserEvent("dangert-notify", "El proyecto necesita tener los folios registrados");
        }

        $subprocesos = 0;
        foreach ($this->proyecto_activo['servicio']['procesos'] as $key => $value) {
            $subprocesos = $subprocesos + count($value['subprocesos']);
        }

        if(count($this->proyecto_activo['avance']) < $subprocesos){
            return $this->dispatchBrowserEvent("dangert-notify", "Se debe terminar el avance del proyecto al 100%");
        }

        $proyecto = Proyectos::find($this->proyecto_activo['id']);
        $proyecto->status = 1;
        $proyecto->save();

        $this->dispatchBrowserEvent("cerrar-modal-procesos-escritura");
        return $this->dispatchBrowserEvent("success-notify", "Exito al terminar proyecto, ahora lo puede ver en el apartado de escrituras");
    }

    public $egreso_id;
    public $td_egreso = "info";
    public $file_egreso;

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
        $path = "/uploads/clientes/" . str_replace(" ", "_", $this->proyecto_activo['cliente']['nombre']) . "_" . str_replace(" ", "_", $this->proyecto_activo['cliente']['apaterno']) . "_" . str_replace(" ", "_", $this->proyecto_activo['cliente']['amaterno']) . "/documentos";
        $store_xml = $this->file_egreso->storeAs(mb_strtolower($path), "egreso_" . $egreso->id . "_" . time() . "." . $this->file_egreso->extension(), 'public');
        $egreso->path = "storage/" . $store_xml;
        $egreso->save();
        $this->td_egreso = "info";
        $this->egreso_id = "";
        $this->file_egreso = "";
        return $this->resetProyect();
    }

    public function open_modal_borrar($id){
        $this->proyecto_id = $id;
        return $this->dispatchBrowserEvent("abrir-modal-borrar-proyecto");
    }

    public function borrar_proyecto(){
        $apoyos = ApoyoProyectos::where("proyecto_id", $this->proyecto_id)->get();
        foreach ($apoyos as $key => $value) {
            $value->delete();
        }

        $proyecto = Proyectos::find($this->proyecto_id);
        delete_firebase_project($proyecto->id);
        $proyecto->delete();
        $this->proyecto_id = "";
        return $this->dispatchBrowserEvent("cerrar-modal-borrar-proyecto");
    }

    public function guardarCliente(){
        $this->validate([
            "nombre_parte" => "required",
            "paterno_parte" => $this->persona_moral == '' ? "required" : "",
            "materno_parte" => $this->persona_moral == '' ? "required" : "",
            "rfc_parte" => $this->persona_moral != '' ? "required" : "",
        ],[
            "nombre_parte.required" => "Es necesario el nombre",
            "rfc_parte.required" => "Es necesario el RFC"
        ]);

        $cliente = new Clientes;
        $cliente->nombre = $this->nombre_parte;
        $cliente->apaterno = $this->paterno_parte ?? "";
        $cliente->amaterno = $this->materno_parte ?? "";
        $cliente->curp = $this->curp_parte ?? "";
        $cliente->rfc = $this->rfc_parte ?? "";
        $cliente->tipo_cliente = $this->persona_moral == '' ? "Persona Fisica" : "Persona Moral";
        $cliente->save();

        $this->persona_moral = '';
        $this->nombre_parte = '';
        $this->paterno_parte = '';
        $this->materno_parte = '';
        $this->curp_parte = '';
        $this->rfc_parte = '';
        $this->cambiarRegistroCliente(0);
        return $this->dispatchBrowserEvent("success-notify", "Cliente registrado");
    }

    public $tipo_doc_upload = '';
    public $document_upload;

    public function abrir_agregar_documentos(){
        return $this->dispatchBrowserEvent("abrir-modal-agregar-documentos");
    }

    public function limpiarVariables(){
        $this->tipo_doc_upload = '';
        $this->document_upload = '';
    }

    public function uploadDocument(){
        $this->validate([
            "tipo_doc_upload" => "required",
            "document_upload" => "required",
        ],[
            "tipo_doc_upload.required" => "Es necesario seleccionar el tipo de documento",
            "document_upload.required" => "Es necesario subir el documento",
        ]);

        $path = "/uploads/clientes/" . str_replace(" ", "_", $this->proyecto_activo['cliente']['nombre']) . "_" . str_replace(" ", "_", $this->proyecto_activo['cliente']['apaterno']) . "_" . str_replace(" ", "_", $this->proyecto_activo['cliente']['amaterno']) . "/documentos";
        $store = $this->document_upload->storeAs(mb_strtolower($path), time() . "_" . $this->document_upload->getClientOriginalName(), 'public');

        $newdoc = new Documentos;
        $newdoc->nombre = $this->document_upload->getClientOriginalName();
        $newdoc->catalogo_id = $this->tipo_doc_upload;
        $newdoc->storage = "storage/" . $store;
        $newdoc->cliente_id = $this->proyecto_activo['cliente']['id'];
        $newdoc->proyecto_id = $this->proyecto_activo['id'];
        $newdoc->save();

        $this->limpiarVariables();
        $this->resetProyect();
        $this->dispatchBrowserEvent("success-notify", "Documento registrado");
        return $this->dispatchBrowserEvent("cerrar-modal-agregar-documentos");
    }

    public function deleteCollection(){
        data_delete_collection();
    }

    public $qrData;
    public function abrirQr($id){
        $escritura = Proyectos::find($id);
        $this->qrData = $escritura->qr ?? "";
        return $this->dispatchBrowserEvent("abrir-modal-generar-qr");
    }

    public $anticipo_id;
    public $recibo_pdf;
    public function abrir_modal_importar_recibo($id){
        $this->anticipo_id = $id;
        return $this->dispatchBrowserEvent("abrir-modal-importar-recibo-pago");
    }

    public function importar_recibo_pago(){
        $this->validate([
            "recibo_pdf" => "required|mimes:pdf"
        ],[
            "recibo_pdf.required" => "Es necesario el recibo de pago",
            "recibo_pdf.mimes" => "El recibo de pago debe ser en formato PDF",
        ]);

        $cobro = Cobros::find($this->anticipo_id);
        $path = "/uploads/clientes/" . str_replace(" ", "_", $this->proyecto_activo['cliente']['nombre']) . "_" . str_replace(" ", "_", $this->proyecto_activo['cliente']['apaterno']) . "_" . str_replace(" ", "_", $this->proyecto_activo['cliente']['amaterno']) . "/documentos/recibos_de_pago";
        $store = $this->recibo_pdf->storeAs(mb_strtolower($path), "Recibo_de_pago_" . time() . "." . $this->recibo_pdf->extension(), 'public');
        $cobro->path = "storage/" . $store;
        $cobro->save();

        $this->anticipo_id = '';
        $this->recibo_pdf = '';

        $this->dispatchBrowserEvent("success-notify", "Se registro el recibo de pago con exito");
        return $this->dispatchBrowserEvent("cerrar-modal-importar-recibo-pago");
    }

    public function plantilla(){
        $proyecto = Proyectos::find($this->proyecto_activo['id']);

        $numero_letras = new NumeroALetras();
        $escritura_letra = $numero_letras->toWords($proyecto->numero_escritura);
        $volumen_letra = $numero_letras->toWords($proyecto->volumen);
        $hora_letra = $numero_letras->toWords(date("H", time()));
        $year_letra = $numero_letras->toWords(date("Y", time()));

        $dia_escrito = Carbon::parse(date("Y-m-d", time()))->isoFormat('dddd');
        $mes_escrito = Carbon::parse(date("Y-m-d", time()))->isoFormat('MMMM');

        $templateprocessor = new TemplateProcessor('word-template/plantillas/plantilla_compraventas.docx');
        $templateprocessor->setValue('num_esc', $proyecto->numero_escritura ?? "S/N");
        $templateprocessor->setValue('num_esc_letra', !$proyecto->numero_escritura ? "Sin número" : $escritura_letra);
        $templateprocessor->setValue('volumen', $proyecto->volumen ?? "S/V");
        $templateprocessor->setValue('volumen_letra', !$proyecto->volumen ? "Sin volumen" : $volumen_letra);
        $templateprocessor->setValue('folio_inicio', $proyecto->folio_inicio ?? "S/F");
        $templateprocessor->setValue('folio_fin', $proyecto->folio_fin ?? "S/F");
        $templateprocessor->setValue('hora', date("H", time()));
        $templateprocessor->setValue('hora_letra', $hora_letra);
        $templateprocessor->setValue('dia', date("d", time()));
        $templateprocessor->setValue('dia_letra', $dia_escrito);
        $templateprocessor->setValue('mes_letra', $mes_escrito);
        $templateprocessor->setValue('year', date("Y", time()));
        $templateprocessor->setValue('year_letra', mb_strtolower($year_letra));

        $filename = "Compraventa plantilla";
        $templateprocessor->saveAs($filename . '.docx');
        return response()->download($filename . ".docx")->deleteFileAfterSend(true);
    }
}

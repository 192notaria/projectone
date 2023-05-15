<?php

namespace App\Http\Livewire;

use App\Models\Catalogos_conceptos_pago;
use App\Models\Clientes;
use App\Models\Costos;
use App\Models\CostosCotizaciones;
use App\Models\Cotizaciones as ModelsCotizaciones;
use App\Models\Proyectos;
use App\Models\Servicios;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use PhpOffice\PhpWord\TemplateProcessor;

class Cotizaciones extends Component
{
    use WithPagination;
    public $cantidadCotizaciones = 5;
    public $search;
    public $costos_array = [];
    public $acto_id = "";
    public $acto_key_id = "";
    public $concepto_id = "";
    public $concepto_nombre;
    public $monto_concepto;
    public $gestoria_concepto;
    public $impuesto_concepto;
    public $observaciones_concepto;
    public $buscar_cliente;
    public $proyecto_cliente;
    public $tipo_servicio = '';

    public $cotizacion_id;

    public function render()
    {
        return view('livewire.cotizaciones', [
            "cotizaciones" => ModelsCotizaciones::orderBy("created_at", "DESC")->paginate($this->cantidadCotizaciones),
            "actos" => Servicios::orderBy("nombre", "ASC")->get(),
            "conceptos_pago" => Catalogos_conceptos_pago::orderBy("descripcion", "ASC")->get(),
            "clientes" =>  $this->buscar_cliente == '' ? [] : Clientes::orderBy("nombre", "ASC")
                ->where('nombre', 'LIKE', '%' . $this->buscar_cliente . '%')
                ->orWhere('apaterno', 'LIKE', '%' . $this->buscar_cliente . '%')
                ->orWhere('amaterno', 'LIKE', '%' . $this->buscar_cliente . '%')
                ->get(),
            "abogados" => User::whereHas("roles", function($data){
                    $data->where('name', "ABOGADO")->orWhere("name", "ABOGADO ADMINISTRADOR");
                })->get(),
        ]);
    }

    public function asignar_cliente($cliente){
        $this->proyecto_cliente = $cliente;
    }

    public function remover_cliente(){
        $this->proyecto_cliente = "";
        $this->buscar_cliente = "";
    }

    public function abrir_modal_crear_cotizacion(){
        return $this->dispatchBrowserEvent("abrir-modal-crear-cotizacion");
    }

    public function agregar_honorarios(){
        $this->costos_array = [];
        $servicio = Servicios::find($this->acto_id);
        foreach ($servicio->conceptos_pago as $key => $value) {
            $data = [
                "concepto_id" => $value->id,
                "concepto" => $value->descripcion,
                "monto" => $value->precio_sugerido == '' ? 0.0 : $value->precio_sugerido,
                "gestoria" => 0.0,
                "impuesto" => $value->impuestos == '' ? 0.0 : $value->impuestos,
                "observaciones" => "",
            ];
            array_push($this->costos_array, $data);
        }
    }

    public function remover_concepto($id){
        unset($this->costos_array[$id]);
    }

    public function editar_concepto($id){
        $this->acto_key_id = $id;
        $this->concepto_id = $this->costos_array[$id]['concepto_id'];
        $this->concepto_nombre = $this->costos_array[$id]['concepto'];
        $this->monto_concepto = $this->costos_array[$id]['monto'];
        $this->gestoria_concepto = $this->costos_array[$id]['gestoria'];
        $this->impuesto_concepto = $this->costos_array[$id]['impuesto'];
        $this->observaciones_concepto = $this->costos_array[$id]['observaciones'];
        return $this->dispatchBrowserEvent("abrir-modal-registro-costo");
    }

    public function clearInputs(){
        $this->acto_key_id = "";
        $this->concepto_id = "";
        $this->concepto_nombre = "";
        $this->monto_concepto = "";
        $this->gestoria_concepto = "";
        $this->impuesto_concepto = "";
        $this->observaciones_concepto = "";
    }

    public function agregar_costo(){
        $this->validate([
            "concepto_id" => "required",
            "monto_concepto" => "required",
        ],[
            "concepto_id.required" => "Es necesario seleccionar el concepto",
            "monto_concepto.required" => "Es necesario agregar el monto",
        ]);

        $concepto = Catalogos_conceptos_pago::find($this->concepto_id);

        if($this->acto_key_id != ""){
            $this->costos_array[$this->acto_key_id]["concepto_id"] = $concepto->id;
            $this->costos_array[$this->acto_key_id]["concepto"] = $concepto->descripcion;
            $this->costos_array[$this->acto_key_id]["monto"] = $this->monto_concepto;
            $this->costos_array[$this->acto_key_id]["gestoria"] = $this->gestoria_concepto == "" ? 0.0 : $this->gestoria_concepto;
            $this->costos_array[$this->acto_key_id]["impuesto"] = $this->impuesto_concepto == "" ? 0.0 : $this->impuesto_concepto;
            $this->costos_array[$this->acto_key_id]["observaciones"] = $this->observaciones_concepto ?? "";
            $this->clearInputs();
            return $this->dispatchBrowserEvent("cerrar-modal-registro-costo");
        }

        $data = [
            "concepto_id" => $concepto->id,
            "concepto" => $concepto->descripcion,
            "monto" => $this->monto_concepto,
            "gestoria" => $this->gestoria_concepto == "" ? 0.0 : $this->gestoria_concepto,
            "impuesto" => $this->impuesto_concepto == "" ? 0.0 : $this->impuesto_concepto,
            "observaciones" => $this->observaciones_concepto ?? "",
        ];
        array_push($this->costos_array, $data);
        $this->clearInputs();
        return $this->dispatchBrowserEvent("cerrar-modal-registro-costo");
    }

    public function abrir_modal_costo(){
        return $this->dispatchBrowserEvent("abrir-modal-registro-costo");
    }

    public function registrar_cotizacion(){
        $this->validate([
            "acto_id" => "required",
            "proyecto_cliente" => "required",
            "tipo_servicio" => $this->acto_id == 25 ? "required" : "",
        ],[
            "acto_id.required" => "Es necesario seleccionar un acto",
            "proyecto_cliente.required" => "Es necesario seleccionar un cliente",
            "tipo_servicio.required" => "Es necesario el tipo de acta",
        ]);

        if(!$this->proyecto_cliente){
            return $this->addError("proyecto_cliente", "Es necesario el cliente para la cotizacion");
        }

        $total_sum = 0;
        foreach ($this->costos_array as $costo_sum) {
            $total = $costo_sum['monto'] + $costo_sum['gestoria'] + $costo_sum['monto'] * $costo_sum['impuesto'] / 100;
            $total_sum = $total_sum + $total;
        }

        if(count($this->costos_array) == 0){
            return $this->addError("costos_array", "Es necesario agregar los costos de la cotizacion");
        }

        if($total_sum == 0){
            return $this->addError("error_cotizacion", "La cotización no puede ser de $0.00");
        }

        if($this->cotizacion_id){
            $cotizacion = ModelsCotizaciones::find($this->cotizacion_id);
            $cotizacion->total = $total_sum;

            $version = $cotizacion->version + 1;

            $cotizacion->version = $version;
            $cotizacion->save();


            foreach ($this->costos_array as $valor) {
                $costo = new CostosCotizaciones;
                $costo->subtotal = $valor['monto'];
                $costo->gestoria = $valor['gestoria'];
                $costo->impuesto = $valor['impuesto'];
                $costo->version = $version;
                $costo->cotizaciones_id = $cotizacion->id;
                $costo->concepto_id = $valor['concepto_id'];
                $costo->observaciones = $valor['observaciones'] ?? "Sin observaciones";
                $costo->save();
            }
            $this->cotizacion_id = "";
            $this->acto_id = "";
            $this->proyecto_cliente = "";
            $this->costos_array = [];
            return $this->dispatchBrowserEvent("cerrar-modal-crear-cotizacion");
        }

        $cotizacion = new ModelsCotizaciones;
        $cotizacion->cliente_id = $this->proyecto_cliente['id'];
        $cotizacion->acto_id = $this->acto_id;
        $cotizacion->tipo_servicio = $this->tipo_servicio == '' ? null : $this->tipo_servicio;
        $cotizacion->total = $total_sum;
        $cotizacion->version = 1;
        $cotizacion->save();

        foreach ($this->costos_array as $valor) {
            $costo = new CostosCotizaciones;
            $costo->subtotal = $valor['monto'];
            $costo->gestoria = $valor['gestoria'];
            $costo->impuesto = $valor['impuesto'];
            $costo->version = 1;
            $costo->cotizaciones_id = $cotizacion->id;
            $costo->concepto_id = $valor['concepto_id'];
            $costo->observaciones = $valor['observaciones'] ?? "Sin observaciones";
            $costo->save();
        }

        $this->cotizacion_id = "";
        $this->acto_id = "";
        $this->tipo_servicio = "";
        $this->proyecto_cliente = "";
        $this->costos_array = [];
        return $this->dispatchBrowserEvent("cerrar-modal-crear-cotizacion");
    }

    public function editar_cotizacion($id){
        $this->cotizacion_id = $id;
        $cotizacion = ModelsCotizaciones::find($id);
        $this->proyecto_cliente = $cotizacion->cliente;
        $this->acto_id = $cotizacion->acto_id;
        $costos = CostosCotizaciones::where("cotizaciones_id", $id)->where("version", $cotizacion->version)->get();
        foreach ($costos as $key => $costo) {
            $data = [
                "concepto_id" => $costo->concepto_id,
                "concepto" => $costo->concepto->descripcion,
                "monto" => $costo->subtotal,
                "gestoria" => $costo->gestoria,
                "impuesto" => $costo->impuesto,
                "observaciones" => $costo->observaciones,
            ];
            array_push($this->costos_array, $data);
        }
        return $this->dispatchBrowserEvent("abrir-modal-crear-cotizacion");
    }

    public $historial_cotizaciones = [];
    public function ver_cotizaciones($id){
        $costos = CostosCotizaciones::where("cotizaciones_id", $id)->distinct('version')->orderBy("created_at", "desc")->get();
        $versiones = $costos->unique("version");
        foreach ($versiones as $value) {
            $cotizacion = CostosCotizaciones::where("cotizaciones_id", $id)->where("version", $value->version)->get();
            array_push($this->historial_cotizaciones, $cotizacion);
        }
        return $this->dispatchBrowserEvent("abrir-modal-historial-cotizacion");
    }

    public function cerrar_historail_cotizacion(){
        $this->historial_cotizaciones = [];
        return $this->dispatchBrowserEvent("cerrar-modal-historial-cotizacion");
    }

    public function descargar_cotizacion($version, $cotizacion_id){
        $cotizacion = CostosCotizaciones::where("cotizaciones_id", $cotizacion_id)->where("version", $version)->get();
        $total_sum = 0;
        foreach ($cotizacion as $costo_sum) {
            $total_sum = $total_sum + $costo_sum->subtotal + $costo_sum->gestoria + $costo_sum->impuesto * $costo_sum->subtotal / 100;
        }

        $nombre = $cotizacion[0]->cotizacion->cliente->nombre . " " . $cotizacion[0]->cotizacion->cliente->apaterno . " " . $cotizacion[0]->cotizacion->cliente->amaterno;
        $acto = $cotizacion[0]->cotizacion->acto->nombre;
        $day = date("d", strtotime($cotizacion[0]->cotizacion->created_at));
        $month = date("m", strtotime($cotizacion[0]->cotizacion->created_at));
        $year = date("Y", strtotime($cotizacion[0]->cotizacion->created_at));

        $templateprocessor = new TemplateProcessor('word-template/cotizacion.docx');
        $templateprocessor->setValue('nombre', mb_strtoupper($nombre));
        $templateprocessor->setValue('acto', $acto);
        $templateprocessor->setValue('costo', "$" . number_format($total_sum, 2));
        $templateprocessor->setValue('dia', $day);
        $templateprocessor->setValue('mes', $month);
        $templateprocessor->setValue('year', $year);
        $filename = "Cotización " . $acto . " " . $nombre;

        $templateprocessor->saveAs("cotizaciones/" . $filename . '.docx');
        return response()->download("cotizaciones/" . $filename . '.docx')->deleteFileAfterSend(true);
    }

    public $servicio_id;
    public $cliente_id;
    public $usuario_id = '';
    public $numero_escritura;
    public $status;
    public $volumen_escritura;
    public $total_escritura;
    public $costos_escritura;

    public function abrir_proyecto_modal($version, $cotizacion_id){
        $cotizacion = ModelsCotizaciones::find($cotizacion_id);
        $costos_escritura = CostosCotizaciones::where("cotizaciones_id", $cotizacion_id)->where("version", $version)->get();
        $this->costos_escritura = $costos_escritura;

        $total_sum = 0;
        foreach ($this->costos_escritura as $costo_sum) {
            $total_sum = $total_sum + $costo_sum->subtotal + $costo_sum->gestoria + $costo_sum->impuesto * $costo_sum->subtotal / 100;
        }

        $this->total_escritura = $total_sum;
        $this->servicio_id = $cotizacion->acto->id;
        $this->cliente_id = $cotizacion->cliente->id;
        $this->tipo_servicio = $cotizacion->tipo_servicio;
        return $this->dispatchBrowserEvent("abrir-modal-crear-proyecto");
    }

    public function crear_proyecto(){
        $this->validate([
            "servicio_id" => "required",
            "cliente_id" => "required",
            "usuario_id" => "required",
            "numero_escritura" => "required",
            "volumen_escritura" => "required",
            "total_escritura" => "required",
            "tipo_servicio" => $this->servicio_id == 25 ? "required" : "",
        ],[
            "servicio_id.required" => "Es necesario asignar un acto",
            "cliente_id.required" => "Es necesario asignar el cliente",
            "usuario_id.required" => "Es necesario seleccionar el abogado",
            "numero_escritura.required" => "Es necesario el número de escritura",
            "volumen_escritura.required" => "Es necesario el volumen",
            "total_escritura.required" => "Es necesario el costo total de la escritura",
            "tipo_servicio.required" => "Es necesario el tipo de acta",
        ]);


        $acto_juridico = Servicios::find($this->acto_juridico_id);
        $buscar_proyecto = Proyectos::where("tipo_id", $acto_juridico)
            ->where("numero_escritura", $this->numero_escritura)->get();
        if(count($buscar_proyecto) > 0){
            return $this->addError("numero_escritura", "El numero de escritura ya esta registrado");
        }

        $proyecto = new Proyectos;
        $proyecto->servicio_id = $this->servicio_id;
        $proyecto->tipo_servicio = $this->tipo_servicio;
        $proyecto->cliente_id = $this->cliente_id;
        $proyecto->usuario_id = $this->usuario_id;
        $proyecto->numero_escritura = $this->numero_escritura;
        $proyecto->status = 0;
        $proyecto->volumen = $this->volumen_escritura;
        $proyecto->total = $this->total_escritura;
        $proyecto->save();

        foreach ($this->costos_escritura as $value) {
            $costo = new Costos;
            $costo->concepto_id = $value->concepto_id;
            $costo->subtotal = $value->subtotal;
            $costo->gestoria = $value->gestoria;
            $costo->impuestos = $value->impuesto;
            $costo->proyecto_id = $proyecto->id;
            $costo->save();
        }

        return $this->dispatchBrowserEvent("cerrar-modal-crear-proyecto");
    }
}


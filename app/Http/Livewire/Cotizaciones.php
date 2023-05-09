<?php

namespace App\Http\Livewire;

use App\Models\Catalogos_conceptos_pago;
use App\Models\Clientes;
use App\Models\CostosCotizaciones;
use App\Models\Cotizaciones as ModelsCotizaciones;
use App\Models\Servicios;
use Livewire\Component;
use Livewire\WithPagination;

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
        ],[
            "acto_id.required" => "Es necesario seleccionar un acto",
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
}

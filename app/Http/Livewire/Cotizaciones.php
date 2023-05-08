<?php

namespace App\Http\Livewire;

use App\Models\Catalogos_conceptos_pago;
use App\Models\Clientes;
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
            "proyecto_cliente" => "required",
        ],[
            "acto_id.required" => "Es necesario seleccionar un acto",
            "proyecto_cliente.required" => "Es necesario el cliente para la cotizacion",
        ]);

        if(count($this->costos_array) == 0){
            return $this->addError("costos_array", "Es necesario agregar los costos de la cotizacion");
        }

        $total_sum = 0;
        foreach ($this->costos_array as $costo_sum) {
            $total = $costo_sum['monto'] + $costo_sum['gestoria'] + $costo_sum['monto'] * $costo_sum['impuesto'] / 100;
            $total_sum = $total_sum + $total;
        }

        $cotizacion = new Cotizaciones;
        $cotizacion->cliente_id = $this->proyecto_cliente['id'];
        $cotizacion->acto_id = $this->acto_id;
        $cotizacion->total = $total_sum;
        $cotizacion->save();
        return $this->dispatchBrowserEvent("cerrar-modal-registro-costo");
    }
}

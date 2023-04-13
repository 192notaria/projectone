<?php
namespace App\Http\Livewire;

use App\Models\CatalogoMetodosPago;
use App\Models\Catalogos_bancos;
use App\Models\Catalogos_categoria_gastos;
use App\Models\Catalogos_conceptos_pago;
use App\Models\Catalogos_tipo_cuenta;
use App\Models\Catalogos_uso_de_cuentas;
use App\Models\CatalogosTipoImpuestos;
use App\Models\Cuentas_bancarias;
use Livewire\Component;

class Contabilidad extends Component
{
    public $vista = "home";
    public function render()
    {
        return view('livewire.contabilidad',[
            "bancos" => Catalogos_bancos::orderBy("nombre", "ASC")->get(),
            "categoria_gastos" => Catalogos_categoria_gastos::orderBy("nombre", "ASC")->get(),
            "conceptos_pago" => Catalogos_conceptos_pago::orderBy("descripcion", "ASC")->get(),
            "cuentas_contables" => Cuentas_bancarias::orderBy("id", "ASC")->get(),
            "metodos_pago" => CatalogoMetodosPago::orderBy("nombre", "ASC")->get(),
            "tipo_cuentas" => Catalogos_tipo_cuenta::orderBy("nombre", "ASC")->get(),
            "tipo_impuestos" => CatalogosTipoImpuestos::orderBy("nombre", "ASC")->get(),
            "tipo_uso_cuentas" => Catalogos_uso_de_cuentas::orderBy("nombre", "ASC")->get(),
        ]);
    }

    public function cambiar_vista($vista){
        $this->vista = $vista;
    }

    public function clearAndReturnToHome(){
        $this->banco_id = "";
        $this->banco_nombre = "";
        $this->banco_descripcion = "";

        $this->categoria_gasto_id = "";
        $this->categoria_gasto_nombre = "";
        $this->categoria_gasto_descripcion = "";

        $this->concepto_pago_id = "";
        $this->concepto_pago_nombre = "";
        $this->concepto_pago_categoria_id = "";
        $this->concepto_pago_precio = "";
        $this->concepto_pago_impuesto = "";
        $this->concepto_pago_impuesto_id = "";

        $this->vista = "home";
    }

    public $banco_id;
    public $banco_nombre;
    public $banco_descripcion;

    public function registro_bancos(){
        $this->validate([
                "banco_nombre" => "required|unique:catalogos_bancos,nombre," . $this->banco_id
            ],
            [
                "banco_nombre.required" => "El nombre del banco es obligatorio",
                "banco_nombre.unique" => "El nombre del banco ya esta registrado",
            ]
        );

        if($this->banco_id){
            $banco = Catalogos_bancos::find($this->banco_id);
            $banco->nombre = $this->banco_nombre;
            $banco->observaciones = $this->banco_descripcion;
            $banco->save();
            $this->dispatchBrowserEvent("success-notify", "Banco editado con exito");
            return $this->clearAndReturnToHome();
        }

        $banco = new Catalogos_bancos;
        $banco->nombre = $this->banco_nombre;
        $banco->observaciones = $this->banco_descripcion;
        $banco->save();
        $this->dispatchBrowserEvent("success-notify", "Banco registrado con exito");
        return $this->clearAndReturnToHome();
    }

    public function editarBanco($id){
        $banco = Catalogos_bancos::find($id);
        $this->banco_id = $banco->id;
        $this->banco_nombre = $banco->nombre;
        $this->banco_descripcion = $banco->descripcion;
        return $this->cambiar_vista("form-banco");
    }


    public $categoria_gasto_id;
    public $categoria_gasto_nombre;
    public $categoria_gasto_descripcion;

    public function registro_categoria_gastos(){
        $this->validate([
                "categoria_gasto_nombre" => "required|unique:catalogos_categoria_gastos,nombre," . $this->categoria_gasto_id
            ],
            [
                "categoria_gasto_nombre.required" => "El nombre de la categoria es obligatorio",
                "categoria_gasto_nombre.unique" => "El nombre de la categoria ya esta registrado",
            ]
        );

        if($this->categoria_gasto_id){
            $categoria = Catalogos_categoria_gastos::find($this->categoria_gasto_id);
            $categoria->nombre = $this->categoria_gasto_nombre;
            $categoria->descripcion = $this->categoria_gasto_descripcion;
            $categoria->save();
            $this->dispatchBrowserEvent("success-notify", "Catregoria de gasto editada con exito");
            return $this->clearAndReturnToHome();
        }

        $categoria = new Catalogos_categoria_gastos;
        $categoria->nombre = $this->categoria_gasto_nombre;
        $categoria->descripcion = $this->categoria_gasto_descripcion;
        $categoria->save();
        $this->dispatchBrowserEvent("success-notify", "Categoria de gasto registrado con exito");
        return $this->clearAndReturnToHome();
    }

    public function editarCategoriaGasto($id){
        $categoria = Catalogos_categoria_gastos::find($id);
        $this->categoria_gasto_id = $categoria->id;
        $this->categoria_gasto_nombre = $categoria->nombre;
        $this->categoria_gasto_descripcion = $categoria->descripcion;
        return $this->cambiar_vista("categoria-gastos-form");
    }

    public $concepto_pago_id;
    public $concepto_pago_nombre;
    public $concepto_pago_categoria_id = "";
    public $concepto_pago_precio;
    public $concepto_pago_impuesto;
    public $concepto_pago_impuesto_id = "";

    public function editarConceptoPago($id){
        $concepto = Catalogos_conceptos_pago::find($id);
        $this->concepto_pago_id = $concepto->id;
        $this->concepto_pago_nombre = $concepto->descripcion;
        $this->concepto_pago_categoria_id = $concepto->categoria_gasto_id;
        $this->concepto_pago_precio = $concepto->precio_sugerido;
        $this->concepto_pago_impuesto = $concepto->impuestos;
        $this->concepto_pago_impuesto_id = $concepto->tipo_impuesto_id;
        return $this->cambiar_vista("concepto-pago-form");
    }

}

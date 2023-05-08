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
        $this->concepto_pago_id = $id;
        $this->concepto_pago_nombre = $concepto->descripcion;
        $this->concepto_pago_categoria_id = $concepto->categoria_gasto_id;
        $this->concepto_pago_precio = $concepto->precio_sugerido;
        $this->concepto_pago_impuesto = $concepto->impuestos;
        $this->concepto_pago_impuesto_id = $concepto->tipo_impuesto_id;
        return $this->cambiar_vista("concepto-pago-form");
    }

    public function guardar_concepto_pago(){
        $this->validate([
            "concepto_pago_nombre" => "required",
            "concepto_pago_categoria_id" => "required",
            "concepto_pago_precio" => "required",
            "concepto_pago_impuesto" => "required",
            "concepto_pago_impuesto_id" => "required",
        ]);

        if($this->concepto_pago_id){
            $concepto = Catalogos_conceptos_pago::find($this->concepto_pago_id);
            $concepto->descripcion = $this->concepto_pago_nombre;
            $concepto->categoria_gasto_id = $this->concepto_pago_categoria_id;
            $concepto->precio_sugerido = $this->concepto_pago_precio;
            $concepto->impuestos = $this->concepto_pago_impuesto;
            $concepto->tipo_impuesto_id = $this->concepto_pago_impuesto_id;
            $concepto->save();

            $this->clearAndReturnToHome();
            return $this->dispatchBrowserEvent("success-notify", "Concepto de pago registrado");
        }

        $concepto = new Catalogos_conceptos_pago;
        $concepto->descripcion = $this->concepto_pago_nombre;
        $concepto->categoria_gasto_id = $this->concepto_pago_categoria_id;
        $concepto->precio_sugerido = $this->concepto_pago_precio;
        $concepto->impuestos = $this->concepto_pago_impuesto;
        $concepto->tipo_impuesto_id = $this->concepto_pago_impuesto_id;
        $concepto->save();
        $this->clearAndReturnToHome();
        return $this->dispatchBrowserEvent("success-notify", "Concepto de pago registrado");
    }

    public $cuenta_id = '';
    public $uso_cuenta_id = '';
    public $tipo_cuenta_id = '';
    public $banco_cuenta_id = '';
    public $titular_cuenta;
    public $numero_cuenta;
    public $clabe_cuenta;
    public $observaciones_cuenta;

    public function clearInputsCuenta(){
        $this->cuenta_id = '';
        $this->uso_cuenta_id = '';
        $this->tipo_cuenta_id = '';
        $this->banco_cuenta_id = '';
        $this->titular_cuenta = '';
        $this->numero_cuenta = '';
        $this->clabe_cuenta = '';
        $this->observaciones_cuenta = '';
    }

    public function editar_cuenta($id){
        $cuenta = Cuentas_bancarias::find($id);
        $this->cuenta_id = $id;
        $this->uso_cuenta_id = $cuenta->uso_id;
        $this->tipo_cuenta_id = $cuenta->tipo_cuenta_id;
        $this->banco_cuenta_id = $cuenta->banco_id;
        $this->titular_cuenta = $cuenta->titular;
        $this->numero_cuenta = $cuenta->numero_cuenta;
        $this->clabe_cuenta = $cuenta->clabe_interbancaria;
        $this->observaciones_cuenta = $cuenta->observaciones;
        return $this->cambiar_vista("cuentas-contables-form");
    }

    public function borrar_cuenta($id){
        return Cuentas_bancarias::find($id)->delete();
    }

    public function registrar_cuenta(){
        $this->validate([
            "uso_cuenta_id" => "required",
            "tipo_cuenta_id" => "required",
            "banco_cuenta_id" => "required",
            "titular_cuenta" => "required",
        ],[
            "uso_cuenta_id.required" => "Es necesario seleccionar el uso de la cuenta",
            "tipo_cuenta_id.required" => "Es necesario seleccionar el tipo de cuenta",
            "banco_cuenta_id.required" => "Es necesario seleccionar el banco",
            "titular_cuenta.required" => "Es necesario el titular",
        ]);

        if($this->cuenta_id){
            $cuenta = Cuentas_bancarias::find($this->cuenta_id);
            $cuenta->uso_id = $this->uso_cuenta_id;
            $cuenta->tipo_cuenta_id = $this->tipo_cuenta_id;
            $cuenta->banco_id = $this->banco_cuenta_id;
            $cuenta->titular = $this->titular_cuenta;
            $cuenta->numero_cuenta = $this->numero_cuenta;
            $cuenta->clabe_interbancaria = $this->clabe_cuenta;
            $cuenta->observaciones = $this->observaciones_cuenta;
            $cuenta->save();
            $this->clearInputsCuenta();
            return $this->cambiar_vista("home");
        }

        $cuenta = new Cuentas_bancarias;
        $cuenta->uso_id = $this->uso_cuenta_id;
        $cuenta->tipo_cuenta_id = $this->tipo_cuenta_id;
        $cuenta->banco_id = $this->banco_cuenta_id;
        $cuenta->titular = $this->titular_cuenta;
        $cuenta->numero_cuenta = $this->numero_cuenta;
        $cuenta->clabe_interbancaria = $this->clabe_cuenta;
        $cuenta->observaciones = $this->observaciones_cuenta;
        $cuenta->save();
        $this->clearInputsCuenta();
        return $this->cambiar_vista("home");
    }

    public $cuenta_tipo_id;
    public $nombre_tipo_cuenta;
    public $descripcion_tipo_cuenta;

    public function clear_inputs_tipo_cuentas(){
        $this->cuenta_tipo_id = '';
        $this->nombre_tipo_cuenta = '';
        $this->descripcion_tipo_cuenta = '';
    }

    public function editar_tipo_cuenta($id){
        $cat_tipo_cuenta = Catalogos_tipo_cuenta::find($id);
        $this->cuenta_tipo_id = $id;
        $this->nombre_tipo_cuenta = $cat_tipo_cuenta->nombre;
        $this->descripcion_tipo_cuenta = $cat_tipo_cuenta->observaciones;
        $this->cambiar_vista("form-tipo-cuentas");
    }

    public function borrar_tipo_cuenta($id){
        return Catalogos_tipo_cuenta::find($id)->delete();
    }

    public function registrar_tipo_cuenta(){
        $this->validate([
            "nombre_tipo_cuenta" => "required",
        ],[
            "nombre_tipo_cuenta.required" => "Es necesario el nombre del tipo de cuenta",
        ]);

        if($this->cuenta_tipo_id){
            $cat_tipo_cuenta = Catalogos_tipo_cuenta::find($this->cuenta_tipo_id);
            $cat_tipo_cuenta->nombre = $this->nombre_tipo_cuenta;
            $cat_tipo_cuenta->observaciones = $this->descripcion_tipo_cuenta;
            $cat_tipo_cuenta->save();
            $this->clear_inputs_tipo_cuentas();
            return $this->clearAndReturnToHome();
        }

        $cat_tipo_cuenta = new Catalogos_tipo_cuenta;
        $cat_tipo_cuenta->nombre = $this->nombre_tipo_cuenta;
        $cat_tipo_cuenta->observaciones = $this->descripcion_tipo_cuenta;
        $cat_tipo_cuenta->save();
        $this->clear_inputs_tipo_cuentas();
        return $this->clearAndReturnToHome();
    }

    public $metodo_pago_id;
    public $nombre_metodo_pago;
    public $observaciones_metodo_pago;

    public function clear_inputs_metodo_pago(){
        $this->cuenta_tipo_id = '';
        $this->nombre_tipo_cuenta = '';
        $this->descripcion_tipo_cuenta = '';
    }

    public function editar_metodo_pago($id){
        $metodo_pago = CatalogoMetodosPago::find($id);
        $this->metodo_pago_id = $id;
        $this->nombre_metodo_pago = $metodo_pago->nombre;
        $this->observaciones_metodo_pago = $metodo_pago->observaciones;
        $this->cambiar_vista("metodos-pago-form");
    }

    public function borrar_metodo_pago($id){
        return CatalogoMetodosPago::find($id)->delete();
    }

    public function registrar_metodo_pago(){
        $this->validate([
            "nombre_metodo_pago" => "required",
        ],[
            "nombre_metodo_pago.required" => "Es necesario el nombre del metodo de pago",
        ]);

        if($this->metodo_pago_id){
            $metodo_pago = CatalogoMetodosPago::find($this->metodo_pago_id);
            $metodo_pago->nombre = $this->nombre_metodo_pago;
            $metodo_pago->observaciones = $this->observaciones_metodo_pago;
            $metodo_pago->save();
            $this->clear_inputs_metodo_pago();
            return $this->clearAndReturnToHome();
        }

        $metodo_pago = new CatalogoMetodosPago;
        $metodo_pago->nombre = $this->nombre_metodo_pago;
        $metodo_pago->observaciones = $this->observaciones_metodo_pago;
        $metodo_pago->save();
        $this->clear_inputs_metodo_pago();
        return $this->clearAndReturnToHome();
    }

    public $impuesto_id;
    public $nombre_impuesto;
    public $observaciones_impuesto;

    public function clear_inputs_impuesto(){
        $this->impuesto_id = '';
        $this->nombre_impuesto = '';
        $this->observaciones_impuesto = '';
    }

    public function editar_impuesto($id){
        $impuesto = CatalogosTipoImpuestos::find($id);
        $this->impuesto_id = $id;
        $this->nombre_impuesto = $impuesto->nombre;
        $this->observaciones_impuesto = $impuesto->descripcion;
        $this->cambiar_vista("impuesto-form");
    }

    public function borrar_impuesto($id){
        return CatalogosTipoImpuestos::find($id)->delete();
    }

    public function registrar_impuesto(){
        $this->validate([
            "nombre_impuesto" => "required",
        ],[
            "nombre_impuesto.required" => "Es necesario el nombre del impuesto",
        ]);

        if($this->impuesto_id){
            $impuesto = CatalogosTipoImpuestos::find($this->impuesto_id);
            $impuesto->nombre = $this->nombre_impuesto;
            $impuesto->descripcion = $this->observaciones_impuesto;
            $impuesto->save();
            $this->clear_inputs_impuesto();
            return $this->clearAndReturnToHome();
        }

        $impuesto = new CatalogosTipoImpuestos;
        $impuesto->nombre = $this->nombre_impuesto;
        $impuesto->descripcion = $this->observaciones_impuesto;
        $impuesto->save();
        $this->clear_inputs_impuesto();
        return $this->clearAndReturnToHome();
    }

    public $tipo_uso_cuenta_id;
    public $nombre_tuc;
    public $observaciones_tuc;

    public function clear_inputs_tuc(){
        $this->impuesto_id = '';
        $this->nombre_tuc = '';
        $this->observaciones_tuc = '';
    }

    public function editar_tuc($id){
        $tuc = Catalogos_uso_de_cuentas::find($id);
        $this->tipo_uso_cuenta_id = $id;
        $this->nombre_tuc = $tuc->nombre;
        $this->observaciones_tuc = $tuc->observaciones;
        $this->cambiar_vista("tipo_uso_cuenta");
    }

    public function borrar_tuc($id){
        return Catalogos_uso_de_cuentas::find($id)->delete();
    }

    public function registrar_tuc(){
        $this->validate([
            "nombre_tuc" => "required",
        ],[
            "nombre_tuc.required" => "Es necesario el nombre del impuesto",
        ]);

        if($this->tipo_uso_cuenta_id){
            $impuesto = Catalogos_uso_de_cuentas::find($this->tipo_uso_cuenta_id);
            $impuesto->nombre = $this->nombre_tuc;
            $impuesto->observaciones = $this->observaciones_tuc;
            $impuesto->save();
            $this->clear_inputs_tuc();
            return $this->clearAndReturnToHome();
        }

        $impuesto = new Catalogos_uso_de_cuentas;
        $impuesto->nombre = $this->nombre_tuc;
        $impuesto->observaciones = $this->observaciones_tuc;
        $impuesto->save();
        $this->clear_inputs_tuc();
        return $this->clearAndReturnToHome();
    }
}

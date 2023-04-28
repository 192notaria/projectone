<?php

namespace App\Http\Livewire;

use App\Models\CatalogoMetodosPago;
use App\Models\Catalogos_conceptos_pago;
use App\Models\Cobros;
use App\Models\Costos;
use App\Models\Cuentas_bancarias;
use App\Models\Egresos;
use App\Models\Proyectos;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class EscriturasGeneral extends Component
{
    use WithPagination;
    public $cantidad_escrituras = 10;

    public $escritura_id;
    public $egreso_data = "";

    // EGRESO
    public $responsable_pago = "";
    public $fecha_egreso;
    public $comentarios_egreso;

    // COSTOS
    public $costo_id = '';
    public $concepto_costo_id = '';
    public $monto_costo;
    public $gestoria_costo;
    public $impuestos_costo;

    // Cobros
    public $cobro_id;
    public $fecha_cobro;
    public $nombre_cliente_cobro;
    public $monto_cobro;
    public $metodo_pago_id = '';
    public $cuenta_id = '';
    public $observaciones_cobro;

    public function render()
    {
        return view('livewire.escrituras-general', [
            "escrituras" => Proyectos::orderBy("numero_escritura", "ASC")->paginate($this->cantidad_escrituras),
            "escritura_activa" => $this->escritura_id != '' ? Proyectos::find($this->escritura_id) : "",
            "metodos_pago" => CatalogoMetodosPago::orderBy("nombre", "ASC")->get(),
            "abogados" => User::orderBy("name", "ASC")
                ->where(function($query){
                    $query->whereHas("roles", function($data){
                        $data->where('name', '!=', 'ADMINISTRADOR');
                    });
                })
            ->get(),
            "catalogo_conceptos" => Catalogos_conceptos_pago::orderBy("descripcion", "ASC")->get(),
            "cuentas_bancarias" => Cuentas_bancarias::all()
        ]);
    }

    public function open_modal($id){
        $this->escritura_id = $id;
        return $this->dispatchBrowserEvent("open-modal-pagos");
    }

    public function abrir_registrar_egreso($id){
        $this->egreso_data = Costos::find($id);
        return $this->dispatchBrowserEvent("abrir-modal-registrar-egresos");
    }

    public function clearEgresos(){
        $this->egreso_data = "";
        $this->responsable_pago = "";
        $this->fecha_egreso = "";
        $this->comentarios_egreso = "";
    }

    public function registrar_egreso(){
        $this->validate([
            "responsable_pago" => "required",
            "fecha_egreso" => "required",
        ],[
            "responsable_pago.required" => "Es necesario seleccionar el responsable del pago",
            "fecha_egreso.required" => "Es necesario la fecha del egreso",
        ]);


        $escritura_activa = Proyectos::find($this->escritura_id);
        $saldo_disponible = $escritura_activa->pagos_recibidos_total($this->escritura_id) - $escritura_activa->egresos_registrados($this->escritura_id);
        $total_egreso = $this->egreso_data['subtotal'] + $this->egreso_data['gestoria'] + $this->egreso_data['subtotal'] * $this->egreso_data['impuestos'] / 100;

        if($total_egreso > $saldo_disponible){
            return $this->addError("sin_saldo", "No es posible generar un egreso, porque no hay saldo suficiente para pagarlo. Solicite al cliente el pago total de la escritura o un abono para continuar el proceso.");
        }

        $egreso = new Egresos;
        $egreso->costo_id = $this->egreso_data['id'];
        $egreso->proyecto_id = $this->escritura_id;
        $egreso->monto = $this->egreso_data['subtotal'];
        $egreso->gestoria = $this->egreso_data['gestoria'];
        $egreso->impuestos = $this->egreso_data['impuestos'];
        $egreso->fecha_egreso = $this->fecha_egreso;
        $egreso->comentarios = $this->comentarios_egreso;
        $egreso->path = null;
        $egreso->status = 0;
        $egreso->usuario_id = $this->responsable_pago;
        $egreso->save();
        $this->clear_inputs();
        return $this->dispatchBrowserEvent("cerrar-modal-registrar-egresos");
    }

    public function abrir_registro_costos(){
        return $this->dispatchBrowserEvent("abrir-modal-registrar-costo");
    }

    public function editar_costo($id){
        $costo = Costos::find($id);
        $this->costo_id = $id;
        $this->concepto_costo_id = $costo->concepto_id;
        $this->monto_costo = $costo->subtotal;
        $this->impuestos_costo = $costo->impuestos;
        $this->gestoria_costo = $costo->gestoria;
        return $this->dispatchBrowserEvent("abrir-modal-registrar-costo");
    }

    public function abrir_modal_borrar_costo($id){
        $this->costo_id = $id;
        return $this->dispatchBrowserEvent("abrir-modal-borrar-costo");
    }

    public function borrar_costo(){
        Costos::find($this->costo_id)->delete();
        $this->costo_id = '';
        return $this->dispatchBrowserEvent("cerrar-modal-borrar-costo", "Costo borrado");
    }

    public function clear_inputs(){
        $this->responsable_pago = '';
        $this->fecha_egreso = '';
        $this->comentarios_egreso = '';
        $this->costo_id = '';
        $this->concepto_costo_id = '';
        $this->monto_costo = '';
        $this->gestoria_costo = '';
        $this->impuestos_costo = '';
    }

    public function registrar_costo(){
        $this->validate([
            "monto_costo" =>"required",
        ],[
            "monto_costo.required" => "Es necesario colocar el costo"
        ]);

        if($this->costo_id){
            $costo = Costos::find($this->costo_id);
            $costo->concepto_id = $this->concepto_costo_id;
            $costo->subtotal = $this->monto_costo;
            $costo->impuestos = $this->impuestos_costo == '' ? 0 : $this->impuestos_costo;
            $costo->gestoria = $this->gestoria_costo == '' ? 0 : $this->gestoria_costo;
            $costo->save();
            $this->clear_inputs();
            $this->dispatchBrowserEvent("success-notify", "Costo editado");
            return $this->dispatchBrowserEvent("cerrar-modal-registrar-costo");
        }

        $costo = new Costos;
        $costo->concepto_id = $this->concepto_costo_id;
        $costo->subtotal = $this->monto_costo;
        $costo->impuestos = $this->impuestos_costo == '' ? 0 : $this->impuestos_costo;
        $costo->gestoria = $this->gestoria_costo == '' ? 0 : $this->gestoria_costo;
        $costo->proyecto_id = $this->escritura_id;
        $costo->save();
        $this->clear_inputs();
        $this->dispatchBrowserEvent("success-notify", "Costo registrado");
        return $this->dispatchBrowserEvent("cerrar-modal-registrar-costo");
    }

    public function abrir_modal_pago(){
        return $this->dispatchBrowserEvent("abrir-modal-registrar-pagos");
    }

    public function abrir_modal_borrar_pago($id){
        $this->cobro_id = $id;
        return $this->dispatchBrowserEvent("abrir-modal-borrar-pago");
    }

    public function borrar_pago(){
        Cobros::find($this->cobro_id)->delete();
        $this->cobro_id = "";
        return $this->dispatchBrowserEvent("cerrar-modal-borrar-pago");
    }

    public function editar_pago($id){
        $pago = Cobros::find($id);
        $this->cobro_id = $id;
        $this->fecha_cobro = $pago->fecha;
        $this->nombre_cliente_cobro = $pago->cliente;
        $this->monto_cobro = $pago->monto;
        $this->metodo_pago_id = $pago->metodo_pago_id;
        $this->cuenta_id = $pago->cuenta_id;
        $this->observaciones_cobro = $pago->observaciones;
        return $this->dispatchBrowserEvent("abrir-modal-registrar-pagos");
    }

    public function registrar_pago(){
        $this->validate([
            "fecha_cobro" => "required",
            "monto_cobro" => "required",
            "metodo_pago_id" => "required",
        ],[
            "fecha_cobro.required" => "Es necesario ingresar la fecha del pago",
            "monto_cobro.required" => "Es necesario ingresar el monto del pago",
            "metodo_pago_id.required" => "Es necesario seleccionar el metodo de pago",
        ]);

        $escritura_activa = Proyectos::find($this->escritura_id);
        $pendiente_pago = $escritura_activa->costo_total($escritura_activa->id) - $escritura_activa->pagos_recibidos_total($this->escritura_id);

        if($this->monto_cobro > $pendiente_pago){
            return $this->addError("monto_mayor", "No es posible recibir un pago mayor al pendiente de pago");
        }

        if($this->cobro_id){
            $pago = Cobros::find($this->cobro_id);
            $pago->fecha = $this->fecha_cobro;
            $pago->cliente = $this->nombre_cliente_cobro ?? null;
            $pago->monto = $this->monto_cobro;
            $pago->metodo_pago_id = $this->metodo_pago_id;
            $pago->cuenta_id = $this->cuenta_id;
            $pago->observaciones = $this->observaciones_cobro;
            $pago->save();
            return $this->dispatchBrowserEvent("cerrar-modal-registrar-pagos");
        }

        $pago = new Cobros;
        $pago->fecha = $this->fecha_cobro;
        $pago->cliente = $this->nombre_cliente_cobro ?? null;
        $pago->monto = $this->monto_cobro;
        $pago->metodo_pago_id = $this->metodo_pago_id;
        $pago->cuenta_id = $this->cuenta_id == '' ? null : $this->cuenta_id;
        $pago->proyecto_id = $this->escritura_id;
        $pago->usuario_id = Auth::user()->id;
        $pago->observaciones = $this->observaciones_cobro;
        $pago->save();
        return $this->dispatchBrowserEvent("cerrar-modal-registrar-pagos");
    }
}

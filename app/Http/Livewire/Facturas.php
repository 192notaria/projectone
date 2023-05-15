<?php

namespace App\Http\Livewire;

use App\Models\Clientes;
use App\Models\Facturas as ModelsFacturas;
use App\Models\Proyectos;
use Livewire\Component;
use Livewire\WithPagination;

class Facturas extends Component
{
    use WithPagination;

    public $cantidadFacturas = 10;
    public $buscarEscrituraInput;

    public $escritura_data;
    public $cliente_data;

    public $clienteInput;
    public $rfcInput;
    public $escrituraInput;

    public function render(){
        return view('livewire.facturas',[
            "facturas" => ModelsFacturas::orderBY("created_At", "DESC")->paginate($this->cantidadFacturas),
            "buscar_escrituras" => !$this->buscarEscrituraInput ? [] : Proyectos::orderBy("numero_escritura", "ASC")
                ->where("numero_escritura", "LIKE", "%" . $this->buscarEscrituraInput . "%")
                ->take(10)
                ->get(),
            "buscar_clientes" => !$this->clienteInput && !$this->cliente_data ? [] : Clientes::orderBy("nombre", "ASC")
                ->where("nombre", "LIKE", "%". $this->clienteInput ."%")
                ->get(),
        ]);
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



}

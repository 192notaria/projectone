<?php

namespace App\Http\Livewire;

use App\Models\CatalogoJuzgados;
use App\Models\Clientes;
use Livewire\Component;
use Livewire\WithPagination;

class Juzgados extends Component
{
    use WithPagination;
    public $cantidadJuzgados = 10;
    public $nombre;
    public $apaterno;
    public $amaterno;

    public $juzgado_id;
    public $distrito;
    public $adscripcion;
    public $cliente_id = '';
    public $domicilio;

    public function render(){
        return view('livewire.juzgados',[
            "juzgados" => CatalogoJuzgados::orderBy("adscripcion", "ASC")
                ->paginate($this->cantidadJuzgados),
            "clientes" => Clientes::orderBy("nombre", "ASC")->get()
        ]);
    }

    public function abrirModalRegistrarJuzgado(){
        return $this->dispatchBrowserEvent("abrir-modal-registrar-juzgado");
    }

    public function abrirModalRegistrarCliente(){
        return $this->dispatchBrowserEvent("abrir-modal-registrar-cliente");
    }

    public function editarJuzgado($id){
        $juzgado = CatalogoJuzgados::find($id);
        $this->juzgado_id = $id;
        $this->distrito = $juzgado->distrito;
        $this->adscripcion = $juzgado->adscripcion;
        $this->cliente_id = $juzgado->cliente_id;
        $this->domicilio = $juzgado->domicilio;
        return $this->abrirModalRegistrarJuzgado();
    }

    public function registrarCliente(){
        $cliente = new Clientes;
        $cliente->nombre = $this->nombre;
        $cliente->apaterno = $this->apaterno;
        $cliente->amaterno = $this->amaterno;
        $cliente->save();

        $this->nombre = '';
        $this->apaterno = '';
        $this->amaterno = '';

        $this->dispatchBrowserEvent("success-notify", "Cliente registrado");
        return $this->dispatchBrowserEvent("cerrar-modal-registrar-cliente");
    }

    public function registrarJuzgado(){

    }
}

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
    public $clientes = [];

    public function mount(){
        $this->clientes = Clientes::orderBy("nombre", "ASC")->get();
    }

    public function render(){
        return view('livewire.juzgados',[
            "juzgados" => CatalogoJuzgados::orderBy("adscripcion", "ASC")
                ->paginate($this->cantidadJuzgados),
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
        $this->clientes = [];
        $cliente = new Clientes;
        $cliente->nombre = $this->nombre;
        $cliente->apaterno = $this->apaterno;
        $cliente->amaterno = $this->amaterno;
        $cliente->save();

        $this->nombre = '';
        $this->apaterno = '';
        $this->amaterno = '';

        // $this->clientes = Clientes::orderBy("nombre", "ASC")->get();
        $this->dispatchBrowserEvent("success-notify", "Cliente registrado");
        return $this->dispatchBrowserEvent("cerrar-modal-registrar-cliente");
    }

    public function registrarJuzgado(){
        $this->validate([
            "distrito" => "required",
            "adscripcion" => "required",
            "cliente_id" => "required",
            "domicilio" => "required",
        ],[
            "distrito.required" => "Es necesario el distrito",
            "adscripcion.required" => "Es necesario la adscripcion",
            "cliente_id.required" => "Es necesario el cliente",
            "domicilio.required" => "Es necesario el domicilio",
        ]);

        if($this->juzgado_id){
            $juzgado = CatalogoJuzgados::find($this->juzgado_id);
            $juzgado->distrito = $this->distrito;
            $juzgado->adscripcion = $this->adscripcion;
            $juzgado->cliente_id = $this->cliente_id;
            $juzgado->domicilio = $this->domicilio;
            $juzgado->save();

            $this->distrito = '';
            $this->adscripcion = '';
            $this->cliente_id = '';
            $this->domicilio = '';

            $this->dispatchBrowserEvent("success-notify", "Juzgado editado");
            return $this->dispatchBrowserEvent("cerrar-modal-registrar-juzgado");
        }

        $juzgado = new CatalogoJuzgados();
        $juzgado->distrito = $this->distrito;
        $juzgado->adscripcion = $this->adscripcion;
        $juzgado->cliente_id = $this->cliente_id;
        $juzgado->domicilio = $this->domicilio;
        $juzgado->save();

        $this->distrito = '';
        $this->adscripcion = '';
        $this->cliente_id = '';
        $this->domicilio = '';

        $this->dispatchBrowserEvent("success-notify", "Juzgado guardado");
        return $this->dispatchBrowserEvent("cerrar-modal-registrar-juzgado");
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Clientes;
use App\Models\Proyectos;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class EscriturasProceso extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $cantidad_escrituras = 5;
    public $proceso_activo;
    public $procesos_data = [];
    public $subprocesos_data = [];

    // Buscadores inputs
    public $search;
    public $buscar_cliente = [];

    public function render()
    {
        return view('livewire.escrituras-proceso',[
            "escrituras" => Auth::user()->hasRole('ADMINISTRADOR') || Auth::user()->hasRole('ABOGADO ADMINISTRADOR') ?
                Proyectos::orderBy("numero_escritura", "ASC")
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
                ->paginate($this->cantidad_escrituras )
            :
                Proyectos::orderBy("numero_escritura", "ASC")
                    ->where('usuario_id', auth()->user()->id)
                    ->where('status', 0)
                    ->where(function($query){
                        $query->orWhereHas('cliente', function($q){
                            $q->where('nombre', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('apaterno', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('amaterno', 'LIKE', '%' . $this->search . '%');
                        })->orWhereHas('servicio', function($serv){
                            $serv->where('nombre', 'LIKE', '%' . $this->search . '%');
                        })->orWhere('volumen', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('numero_escritura', 'LIKE', '%' . $this->search . '%');
                    })
                    ->paginate($this->cantidad_escrituras ),
            "clientes" => $this->buscar_cliente == "" ? [] : Clientes::orderBy("nombre", "ASC")->get(),
        ]);
    }

    public function openProcesos($proyecto_id){
        $proyecto = Proyectos::find($proyecto_id);
        $this->procesos_data = $proyecto->servicio->procesos;
        $this->subprocesos_data = $this->procesos_data[0]->subprocesos;
        $this->proceso_activo = $this->procesos_data[0]->id;
        return $this->dispatchBrowserEvent('abrir-modal-procesos-escritura');
    }

    public function closeProcesos(){
        $this->procesos_data = [];
        $this->subprocesos_data = [];
        $this->proceso_activo = "";
        return $this->dispatchBrowserEvent('cerrar-modal-procesos-escritura');
    }

    public function subprocesosData($proceso_id){
        $this->subprocesos_data = [];
        $this->proceso_activo = $proceso_id;
        $proceso = ProcesosServicios::find($proceso_id);
        $this->subprocesos_data = $proceso->subprocesos;
    }
}

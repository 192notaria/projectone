<?php

namespace App\Http\Livewire;

use App\Models\Proyectos;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class EscriturasProceso extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $search;
    public $cantidad_escrituras = 10;

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
        ]);
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Cobros;
use Livewire\Component;
use Livewire\WithPagination;

class PagosRegistrados extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.pagos-registrados',[
            "pagos_registrados" => Cobros::orderBy("fecha", "ASC")->paginate(10)
        ]);
    }
}

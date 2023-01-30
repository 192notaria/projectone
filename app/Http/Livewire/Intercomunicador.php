<?php

namespace App\Http\Livewire;

use App\Models\Interphone;

use Livewire\Component;

class Intercomunicador extends Component
{
    public $intercomunicadores = [];

    // newinterfon
    protected $listeners = ['newinterfon' => 'refreshIntercomunicador'];

    public function render()
    {
        return view('livewire.intercomunicador', [
            $this->intercomunicadores = Interphone::where("to", auth()->user()->id)->where('view', 0)->orderBy("created_at", "DESC")->get()
        ]);
    }

    public function refreshIntercomunicador(){
        $this->intercomunicadores = Interphone::where("to", auth()->user()->id)->where('view', 0)->orderBy("created_at", "DESC")->get();
    }

    public function viewIntercomunicador(){
        $intercoms = Interphone::where("to", auth()->user()->id)->where("view", 0)->get();
        foreach($intercoms as $inter){
            $updateInter = Interphone::find($inter->id);
            $updateInter->view = true;
            $updateInter->save();
        }
    }
}

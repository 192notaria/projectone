<?php

namespace App\Http\Livewire;

use App\Models\Contactos as ModelsContactos;
use App\Models\User;
use Livewire\Component;

class Contactos extends Component
{
    public $interphoneUser;
    public $recording;

    public function render()
    {
        return view('livewire.contactos',[
            "contacts" => User::orderBy("name","ASC")->get()
        ]);
    }

    public function startRecording($id){
        $this->interphoneUser = $id;
        $this->recording = true;
        return $this->dispatchBrowserEvent('start-interphone');
    }

    public function stopRecording(){
        $this->dispatchBrowserEvent('stop-interphone', $this->interphoneUser);
        $this->interphoneUser = "";
        return $this->recording = false;
    }

    public function addFavorites($id){
        $contacto = new ModelsContactos;
        $contacto->usuario_id = $id;
        $contacto->auth_usuario_id = auth()->user()->id;
        $contacto->save();
        return $this->emit('updateFavorites');
    }

    public function removeFavorites($id){
        ModelsContactos::where("usuario_id", $id)->where("auth_usuario_id", auth()->user()->id)->delete();
        return $this->emit('updateFavorites');
        // $contacto->usuario_id = $id;
        // $contacto->save();
    }
}

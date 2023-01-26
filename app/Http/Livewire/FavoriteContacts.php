<?php

namespace App\Http\Livewire;

use App\Models\Contactos;
use Livewire\Component;

class FavoriteContacts extends Component
{
    protected $listeners = ['updateFavorites' => 'refreshFavorites'];
    public $favorites = [];
    public $interphoneUser;
    public $recording;

    public function render()
    {
        return view('livewire.favorite-contacts',[
            $this->favorites = Contactos::where("auth_usuario_id", auth()->user()->id)->get()
        ]);
    }

    public function startRecording($id){
        $this->interphoneUser = $id;
        $this->recording = true;
        return $this->dispatchBrowserEvent('start-interphone-favorite');
    }

    public function stopRecording(){
        $this->dispatchBrowserEvent('stop-interphone-favorite', $this->interphoneUser);
        $this->interphoneUser = "";
        return $this->recording = false;
    }

    public function refreshFavorites(){
        $this->favorites = Contactos::where("auth_usuario_id", auth()->user()->id)->get();
    }
}

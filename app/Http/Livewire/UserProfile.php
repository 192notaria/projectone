<?php

namespace App\Http\Livewire;

use App\Models\Ocupaciones;
use Livewire\Component;

class UserProfile extends Component
{
    public function render()
    {
        return view('livewire.user-profile', [
            "ocupaciones" => Ocupaciones::orderby("nombre","ASC")->get()
        ]);
    }

    public $user_img;
    public function editProfile(){
        dd($this->user_img);
    }
}

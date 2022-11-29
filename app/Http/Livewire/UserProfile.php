<?php

namespace App\Http\Livewire;

use App\Models\Ocupaciones;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Arr;


class UserProfile extends Component
{
    public function render()
    {
        return view('livewire.user-profile', [
            "ocupaciones" => Ocupaciones::orderby("nombre","ASC")->get()
        ]);
    }

    protected function rules(){
        return [
            'nombre' => 'required|min:3',
            'apaterno' => 'required|min:3',
            'amaterno' => 'required|min:3',
            'genero' => 'required',
            'ocupacion' => 'required',
            'fecha_nacimiento' => 'required',
            'telefono' => 'required|min:10',
            'contraseña' => 'min:8',
            'confirmacion_contraseña' => 'same:password'
        ];
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public $nombre, $apaterno, $amaterno, $genero, $ocupacion, $fecha_nacimiento, $telefono, $contraseña, $confirmacion_contraseña;

    public function saveData(){
        $validatedData = $this->validate();
        if(empty($validatedData['password'])){
            $validatedData = Arr::except($validatedData, array('contraseña'));
        }

        $validatedData['name'] = mb_strtoupper($validatedData['name']);
        $validatedData['apaterno'] = mb_strtoupper($validatedData['apaterno']);
        $validatedData['amaterno'] = mb_strtoupper($validatedData['amaterno']);

        $user = User::find(auth()->user()->id);
        $user->update($validatedData);
    }


}

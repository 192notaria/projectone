<?php

namespace App\Http\Livewire;

use App\Models\Ocupaciones;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserProfile extends Component
{
    public function render()
    {
        return view('livewire.user-profile', [
            "ocupaciones" => Ocupaciones::orderby("nombre","ASC")->get()
        ]);
    }

    public $nombre;
    public $apaterno;
    public $amaterno;
    public $genero;
    public $ocupacion;
    public $fecha_nacimiento;
    public $telefono;
    public $contrasena;
    public $confirmacion_contrasena;

    public function mount(){
        $this->nombre = auth()->user()->name;
        $this->apaterno = auth()->user()->apaterno;
        $this->amaterno = auth()->user()->amaterno;
        $this->genero = auth()->user()->genero;
        $this->ocupacion = auth()->user()->ocupacion;
        $this->fecha_nacimiento = auth()->user()->fecha_nacimiento;
        $this->telefono = auth()->user()->telefono;
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
            'contrasena' => $this->contrasena != "" ? 'min:8' : "",
            'confirmacion_contrasena' => 'same:contrasena'
        ];
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function saveData(){
        $validatedData = $this->validate();

        $validatedData['nombre'] = mb_strtoupper($validatedData['nombre']);
        $validatedData['apaterno'] = mb_strtoupper($validatedData['apaterno']);
        $validatedData['amaterno'] = mb_strtoupper($validatedData['amaterno']);

        $user = User::find(auth()->user()->id);
        $user->name =  $validatedData['nombre'];
        $user->apaterno =  $validatedData['apaterno'];
        $user->amaterno =  $validatedData['amaterno'];
        $user->genero =  $validatedData['genero'];
        $user->ocupacion =  $validatedData['ocupacion'];
        $user->fecha_nacimiento =  $validatedData['fecha_nacimiento'];
        $user->telefono =  $validatedData['telefono'];
        if($this->contrasena != ""){
            $user->password = Hash::make($this->contrasena);
        }

        $user->save();

        notifyAdmins("Datos actualizados",
            auth()->user()->name . " " . auth()->user()->apaterno . " ha actualizado sus datos generales",
            "private", "Datos actualizados", auth()->user()->id);
    }


}

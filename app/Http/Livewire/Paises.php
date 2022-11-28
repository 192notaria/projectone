<?php

namespace App\Http\Livewire;

use App\Events\NotificationEvent;
use App\Models\Paises as ModelsPaises;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use PhpParser\Node\Stmt\Foreach_;

class Paises extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $buscarPais;
    public $cantidadPaises = 10;
    public $modal = false;
    public $id_pais, $nombre;

    protected function rules(){
        if($this->id_pais == ""){
            return [
                'nombre' => 'required|min:3|unique:paises,nombre',
            ];
        }

        return [
            'nombre' => 'required|min:3|unique:paises,nombre,' . $this->id_pais,
        ];
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function updatingBuscarPais(){
        $this->resetPage();
    }

    public function openModal(){
        $this->modal = true;
        $this->resetInputs();
    }

    public function closeModal(){
        $this->modal = false;
        $this->resetInputs();
    }

    public function resetInputs(){
        $this->id_pais = "";
        $this->nombre = "";
    }

    public function guardar(){
        if($this->id_pais == ""){
            $validatedData = $this->validate();
            ModelsPaises::create($validatedData);
            $this->resetInputs();
            $this->closeModal();
            $nombreUsuario = auth()->user()->name . ' ' . auth()->user()->apaterno;
            $admins = DB::table('model_has_roles')->where('role_id', 1)->get();
            foreach ($admins as $admin) {
                if($admin->role_id == auth()->user()->id){
                    event(new NotificationEvent(auth()->user()->id, "<span style='font-weight:bold;'>Nuevo Pais. </span>Se ha registrado un nuevo Pais"));
                }else{
                    event(new NotificationEvent(auth()->user()->id, "<span style='font-weight:bold;'>" . $nombreUsuario . "</span>" . " Ha registrado un nuevo Pais "));
                }
            }
        }else{
            $validatedData = $this->validate();
            $pais = ModelsPaises::find($this->id_pais);
            $pais->update($validatedData);
            $nombreUsuario = auth()->user()->name . ' ' . auth()->user()->apaterno;
            $admins = DB::table('model_has_roles')->where('role_id', 1)->get();
            $this->resetInputs();
            $this->closeModal();
            foreach ($admins as $admin) {
                if($admin->role_id == auth()->user()->id){
                    event(new NotificationEvent(auth()->user()->id, "<span style='font-weight:bold;'>Pais editado. </span>Se ha editado un Pais"));
                }else{
                    event(new NotificationEvent(auth()->user()->id, "<span style='font-weight:bold;'>" . $nombreUsuario . "</span>" . " Ha editado un Pais"));
                }
            }
        }
    }

    public function edit($id){
        $this->openModal();
        $user = ModelsPaises::findOrFail($id);
        $this->id_pais = $id;
        $this->nombre = $user->nombre;
    }

    public function delete($id){
        ModelsPaises::find($id)->delete();
        event(new NotificationEvent(auth()->user()->id, 'Se ha eliminado un pais'));
    }

    public function render(){
        return view('livewire.paises',[
            'paisesData' => ModelsPaises::where('nombre', 'LIKE', '%' . $this->buscarPais . '%')
                ->paginate($this->cantidadPaises),
        ]);
    }
}

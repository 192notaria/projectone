<?php

namespace App\Http\Livewire;

use App\Events\InterphoneEvent;
use App\Events\NotificationEvent;
use App\Models\Notifications;
use App\Models\Ocupaciones;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;


class AdministracionUsuariosLiveWire extends Component {
    use WithPagination;

    public $rolesUsuario = [];
    public $selectedRol;
    public $userId;
    public $search;
    public $modal = false;
    public $cantidadUsuarios = 10;
    public $recording = false;

    public $interphoneUser;

    public $id_usuario, $name, $apaterno, $amaterno, $email, $genero, $ocupacion, $fecha_nacimiento, $telefono, $password, $password_confirmation;

    public $user_image = "/v3/src/assets/img/g-8.png";

    public function updatingSearch(){
        $this->resetPage();
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

    protected function rules(){
        if($this->id_usuario == ""){
            return [
                'name' => 'required|min:3',
                'apaterno' => 'required|min:3',
                'amaterno' => 'required|min:3',
                'genero' => 'required',
                'ocupacion' => 'required',
                'fecha_nacimiento' => 'required',
                'telefono' => 'required|min:10',
                'email' => 'required|email|unique:users,email',
                'user_image' => 'min:2',
                'selectedRol' => 'required',
                'password' => 'required|min:8',
                'password_confirmation' => 'required|same:password'
            ];
        }

        return [
            'name' => 'required|min:3',
            'apaterno' => 'required|min:3',
            'amaterno' => 'required|min:3',
            'genero' => 'required',
            'ocupacion' => 'required',
            'fecha_nacimiento' => 'required',
            'telefono' => 'required|min:10',
            'email' => 'required|email|unique:users,email,' . $this->id_usuario,
            'user_image' => 'min:2',
            'selectedRol' => 'required',
            'password' => $this->password != "" ? 'min:8' : "",
            'password_confirmation' => 'same:password'
        ];
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function openModal(){
        $this->limpiarCampos();
        $this->modal = true;
    }

    public function closeModal(){
        $this->limpiarCampos();
        $this->modal = false;
     }

    public function save($id){
        $validatedData = $this->validate();
        if($this->id_usuario != ""){
            $validatedData = $this->validate();
            if(empty($validatedData['password'])){
                $validatedData = Arr::except($validatedData, array('password'));
            }else{
                $validatedData['password'] = Hash::make($validatedData['password']);
            }
            $validatedData['name'] = mb_strtoupper($validatedData['name']);
            $validatedData['apaterno'] = mb_strtoupper($validatedData['apaterno']);
            $validatedData['amaterno'] = mb_strtoupper($validatedData['amaterno']);
            $validatedData['email'] = mb_strtolower ($validatedData['email']);

            $user = User::find($this->id_usuario);
            $user->update($validatedData);
            DB::table('model_has_roles')->where('model_id', $this->id_usuario)->delete();
            $user->assignRole($validatedData['selectedRol']);

            $this->limpiarCampos();
            $this->closeModal();
            notifyAdmins("Usuario editado",
                auth()->user()->name . " " . auth()->user()->apaterno . " Ha editado el usuario de " . $validatedData['name'] . " " . $validatedData['apaterno'] . " " . $validatedData['amaterno'],
                "private",
                "Usiario editado",
                $id
            );

        }else{
            $validatedData = $this->validate();
            $validatedData['name'] = mb_strtoupper($validatedData['name']);
            $validatedData['apaterno'] = mb_strtoupper($validatedData['apaterno']);
            $validatedData['amaterno'] = mb_strtoupper($validatedData['amaterno']);
            $validatedData['email'] = mb_strtolower($validatedData['email']);
            $validatedData['password'] = Hash::make($validatedData['password']);

            $usuario = User::create($validatedData);
            $usuario->assignRole($validatedData['selectedRol']);

            $this->limpiarCampos();
            $this->closeModal();

            // $notificacion = new Notifications;
            // $notificacion->name = "Usuario Creado";
            // $notificacion->body = "Se ha registrado un nuevo usuario con exito";
            // $notificacion->viewed = false;
            // $notificacion->channel = "private";
            // $notificacion->user_id = $id;
            // $notificacion->save();

            // event(new NotificationEvent($id, "Se ha registrado un nuevo usuario"));
            notifyAdmins("Usuario creado",
                auth()->user()->name . auth()->user()->apaterno . " Ha registrado a " . $validatedData['name'] . " " . $validatedData['apaterno'] . " como " . $validatedData['selectedRol'],
                "private",
                "Usuario registrado",
                $id
            );
            $this->emit('listenNotify');
        }
    }

    public function limpiarCampos(){
        $this->id_usuario = "";
        $this->name = "";
        $this->apaterno = "";
        $this->amaterno = "";
        $this->email = "";
        $this->genero = "";
        $this->ocupacion = "";
        $this->fecha_nacimiento = "";
        $this->telefono = "";
        $this->password = "";
        $this->password_confirmation = "";
        $this->selectedRol = "";
    }

    public function borrarRegistro($id, $notificationid){
        User::find($id)->delete();
        // event(new NotificationEvent($notificationid, "Se ha eliminado un usuario"));
    }

    public function editarRegistro($id){
        $this->openModal();
        $user = User::findOrFail($id);
        $this->id_usuario = $id;
        $this->name = $user->name;
        $this->apaterno = $user->apaterno;
        $this->amaterno = $user->amaterno;
        $this->email = $user->email;
        $this->genero = $user->genero;
        $this->telefono = $user->telefono;
        $this->ocupacion = $user->ocupacion;
        $this->fecha_nacimiento = $user->fecha_nacimiento;
        $roles = Role::pluck('name','name')->all();
        $rolAsignado = $user->roles->pluck('name', 'name')->all();
        foreach($rolAsignado as $rolAs){
            $this->selectedRol = $rolAs;
        }
    }

    public function verUsuarios($id){
        $user = User::findOrFail($id);
        $this->name = $user->name;
        $this->apaterno = $user->apaterno;
        $this->amaterno = $user->amaterno;
        $this->email = $user->email;
        $this->telefono = $user->telefono;
        $this->fecha_nacimiento = $user->fecha_nacimiento;
        $this->ocupacion = $user->ocupacion;
    }

    public function closeSession($id){
        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make('po9iuns652nmsn28km86sD4a1!asad44$aama$$!2121AAASss')
        ]);
        event(new NotificationEvent($id, "closession"));
    }

    public function render() {
        return view('livewire.administracion-usuarios-live-wire', [
            "usuarios" => User::where('name', 'LIKE', '%' . $this->search . '%')
                ->Orwhere('apaterno', 'LIKE', '%' . $this->search . '%')
                ->Orwhere('amaterno', 'LIKE', '%' . $this->search . '%')
                ->paginate($this->cantidadUsuarios),
            $this->rolesUsuario = Role::pluck('name','name')->all(),
            "ocupaciones" => Ocupaciones::orderBy("nombre", "ASC")->get()
        ]);
    }
}

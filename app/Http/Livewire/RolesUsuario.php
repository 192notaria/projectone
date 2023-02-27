<?php

namespace App\Http\Livewire;

use App\Events\NotificationEvent;
use App\Models\RolesModel;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesUsuario extends Component
{
    public $modalEdit = false;
    public $editmethod = false;
    public $rol_id;
    public $rolName;
    public $roles;
    public $roleName;
    public $permisos;
    public $modal = false;
    public $permisosCheck = [];

    protected function rules(){
        if($this->editmethod){
            return [
                'rolName' => 'required|unique:roles,name,' . $this->rol_id,
                'permisosCheck' => 'required'
            ];
        }
        return [
            'rolName' => 'required|unique:roles,name',
            'permisosCheck' => 'required'
        ];
    }

    public function render()
    {
        return view('livewire.roles-usuario', [
            $this->roles = Role::all(),
            $this->permisos = Permission::all(),
        ]);
    }

    public function openModal(){
        $this->modal = true;
        $this->editmethod = false;
    }

    public function closeModal(){
        $this->modal = false;
        $this->modalEdit = false;
        $this->clearIputs();
    }

    public function clearIputs(){
        $this->rol_id = "";
        $this->rolName = "";
        $this->permisosCheck = [];
    }

    public function editRole($id){
        $this->openModal();
        $rol = Role::find($id);
        $this->rolName = $rol->name;
        $this->editmethod = true;
        $this->rol_id = $id;
        $this->permisosCheck = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
    }

    public function viewRole($id){
        $rol = Role::find($id);
        $this->rolName = $rol->name;
        $this->permisosCheck = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
    }

    public function saveRol($id){
        if($this->editmethod){
            $validateData = $this->validate();
            $role = Role::find($this->rol_id);
            $role->name = $validateData['rolName'];
            $role->updateOrCreate(
                ['id' => $this->rol_id],
                ['name' => $validateData['rolName']],
            );
            $role->syncPermissions($validateData['permisosCheck']);
            $this->closeModal();
            $this->clearIputs();
            event(new NotificationEvent($id, "Rol editado con exito"));
        }else{
            $validateData = $this->validate();

            $role = Role::create([
                'name' => mb_strtoupper($validateData['rolName'])
            ]);

            $role->syncPermissions($validateData['permisosCheck']);
            $this->closeModal();
            $this->clearIputs();
            event(new NotificationEvent($id, "Rol creado con exito"));
        }
    }

    public function deleteRol($id){
        DB::table('roles')->where('id', $id)->delete();
    }
}

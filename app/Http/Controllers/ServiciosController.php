<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ServiciosController extends Controller
{
    function __construct(){
        $this->middleware('permission:ver-servicios|crear-servicios|editar-servicios|borrar-servicios',['only'=>['index']]);
        $this->middleware('permission:crear-servicios',['only' => ['create', 'store']]);
        $this->middleware('permission:editar-servicios',['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-servicios',['only' => ['destroy']]);
    }

    public function index(){
        return view("administracion.servicios");
    }

    public function uploadFiles(Request $request){
        $request->validate([
            "filepond" => "required|mimes:png,jpg"
        ]);

        if($request->hasFile("filepond")){
            $user = User::find($request->user_id);
            $file = $request->file('filepond');
            $filename = $user->id . $user->name . "." . $file->guessExtension();
            $filePath = $file->storeAs('uploads/usuarios', $filename, 'public');
            $user->user_image = "/". "storage/" . $filePath;
            $user->save();
            notifyAdmins("Foto de perfil actualizada",
            auth()->user()->name . " " . auth()->user()->apaterno . " ha actualizado su foto de perfil",
            "private", "Foto de perfil actualizada, porfavor actualiza la pagina para ver los cambios en tu foto...", auth()->user()->id);

            return $filePath;
        }

        return "Exito";
    }
}

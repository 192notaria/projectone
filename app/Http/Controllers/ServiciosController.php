<?php

namespace App\Http\Controllers;

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
            $file = $request->file('filepond');
            $filename = time() . "_" . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $filename, 'public');
            return $filePath;
        }

        return "Exito";
    }
}

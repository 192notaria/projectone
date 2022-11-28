<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProcesosServicios extends Controller
{
    function __construct(){
        $this->middleware('permission:ver-procesos|crear-procesos|editar-procesos|borrar-procesos',['only'=>['index']]);
        $this->middleware('permission:crear-procesos',['only' => ['create', 'store']]);
        $this->middleware('permission:editar-procesos',['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-procesos',['only' => ['destroy']]);
    }

    public function index(){
        return view('administracion.procesos_servicios');
    }
}

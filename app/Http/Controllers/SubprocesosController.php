<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubprocesosController extends Controller
{
    function __construct(){
        $this->middleware('permission:ver-subprocesos|crear-subprocesos|editar-subprocesos|borrar-subprocesos',['only'=>['index']]);
        $this->middleware('permission:crear-subprocesos',['only' => ['create', 'store']]);
        $this->middleware('permission:editar-subprocesos',['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-subprocesos',['only' => ['destroy']]);
    }

    public function index(){
        return view("administracion.subprocesos");
    }
}

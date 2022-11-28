<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProyectosController extends Controller
{
    function __construct(){
        $this->middleware('permission:ver-proyectos|crear-proyectos|editar-proyectos|borrar-proyectos',['only'=>['index']]);
        $this->middleware('permission:crear-proyectos',['only' => ['create', 'store']]);
        $this->middleware('permission:editar-proyectos',['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-proyectos',['only' => ['destroy']]);
    }

    public function index(){
        return view("administracion.proyectos");
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EscriturasApoyo extends Controller
{
    function __construct(){
        $this->middleware('permission:ver-escrituras_apoyo|crear-escrituras_apoyo|editar-escrituras_apoyo|borrar-escrituras_apoyo',['only'=>['index']]);
        $this->middleware('permission:crear-escrituras_apoyo',['only' => ['create', 'store']]);
        $this->middleware('permission:editar-escrituras_apoyo',['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-escrituras_apoyo',['only' => ['destroy']]);
    }

    public function index(){
        return view('administracion.escrituras-apoyo');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EstadosController extends Controller
{
    function __construct(){
        $this->middleware('permission:ver-estados|crear-estados|editar-estados|borrar-estados',['only'=>['index']]);
        $this->middleware('permission:crear-estados',['only' => ['create', 'store']]);
        $this->middleware('permission:editar-estados',['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-estados',['only' => ['destroy']]);
    }
    public function index(){
        return view('catalogos.estados');
    }
}

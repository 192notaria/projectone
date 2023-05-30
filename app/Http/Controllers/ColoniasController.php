<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ColoniasController extends Controller
{
    function __construct(){
        $this->middleware('permission:ver-colonias|crear-colonias|editar-colonias|borrar-colonias',['only'=>['index']]);
        $this->middleware('permission:crear-colonias',['only' => ['create', 'store']]);
        $this->middleware('permission:editar-colonias',['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-colonias',['only' => ['destroy']]);
    }

    public function index(){
        return view('catalogos.colonias');
    }

    public function juzgados(){
        return view('catalogos.juzgados');
    }
}

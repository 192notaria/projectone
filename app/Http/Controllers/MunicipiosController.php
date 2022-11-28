<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MunicipiosController extends Controller
{
    function __construct(){
        $this->middleware('permission:ver-municipios|crear-municipios|editar-municipios|borrar-municipios',['only'=>['index']]);
        $this->middleware('permission:crear-municipios',['only' => ['create', 'store']]);
        $this->middleware('permission:editar-municipios',['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-municipios',['only' => ['destroy']]);
    }

    public function index(){
        return view('catalogos.municipios');
    }
}

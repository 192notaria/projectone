<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ContactosController extends Controller
{
    function __construct(){
        $this->middleware('permission:ver-contactos|crear-contactos|editar-contactos|borrar-contactos',['only'=>['index']]);
        $this->middleware('permission:crear-contactos',['only' => ['create', 'store']]);
        $this->middleware('permission:editar-contactos',['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-contactos',['only' => ['destroy']]);
    }

    public function index(){
        return view('contactos.contactos');
    }
}

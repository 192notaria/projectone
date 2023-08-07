<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProyectosController extends Controller
{
    function __construct(){
        $this->middleware('permission:ver-pagos-escritura-page',['only'=>['escrituras_general']]);
        $this->middleware('permission:ver-documentos_generales',['only'=>['documentos_generales']]);
        $this->middleware('permission:ver-cotizaciones',['only'=>['cotizaciones']]);
        $this->middleware('permission:ver-proyectos|crear-proyectos|editar-proyectos|borrar-proyectos',['only'=>['index']]);
        $this->middleware('permission:crear-proyectos',['only' => ['create', 'store']]);
        $this->middleware('permission:editar-proyectos',['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-proyectos',['only' => ['destroy']]);
        $this->middleware('permission:ver-copias', ['only'=>['copias_certificadas']]);
    }

    public function index(){
        return view("administracion.proyectos");
    }

    public function actas(){
        return view("administracion.actas");
    }

    public function poderes(){
        return view("administracion.poderes");
    }

    public function ratificaciones(){
        return view("administracion.ratificaciones");
    }

    public function index2(){
        return view("administracion.escrituras-proceso");
    }

    public function escrituras(){
        return view("administracion.escrituras");
    }

    public function escrituras_general(){
        return view("administracion.escrituras-general");
    }

    public function cotizaciones(){
        return view("administracion.cotizaciones");
    }

    public function documentos_generales(){
        return view("catalogos.documentos_generales");
    }

    public function escrituras_guardadas(){
        return view("administracion.escrituras-guardadas");
    }

    public function copias_certificadas(){
        return view("administracion.copias_certificadas");
    }
}

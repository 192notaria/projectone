<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Contabilidad extends Controller
{
    public function index(){
        return view("contabilidad.general");
    }

    public function pagos(){
        return view("contabilidad.pagos");
    }

    public function facturas(){
        return view("contabilidad.facturas");
    }
}

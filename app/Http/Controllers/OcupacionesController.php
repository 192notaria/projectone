<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OcupacionesController extends Controller
{
    public function index(){
        return view("administracion.ocupaciones");
    }
}

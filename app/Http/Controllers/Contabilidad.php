<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Contabilidad extends Controller
{
    public function index(){
        return view("contabilidad.general");
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartsController extends Controller
{
    public function index(Request $request){

    if($request->type == 'area'){
        $data = [
            ["x" => "Enero", "y" => "120000"],
            ["x" => "Febrero", "y" => "190000"],
            ["x" => "Marzo", "y" => "12000"],
            ["x" => "Abril", "y" => "120000"],
            ["x" => "Mayo", "y" => "13900"],
            ["x" => "Junio", "y" => "190000"],
            ["x" => "Julio", "y" => "12200"],
            ["x" => "Agosto", "y" => "120000"],
            ["x" => "Septiembre", "y" => "13200"],
            ["x" => "Octubre", "y" => "15000"],
            ["x" => "Noviembre", "y" => "220000"],
            ["x" => "Diciembre", "y" => "1200"],
        ];

        $datareturn = [
            "data" => $data,
            "type" => $request->type
        ];

        return json_encode($datareturn);
    }

    if($request->type == 'dounut'){
        $data = [
            "values" => [15,90,30],
            "labels" => ["Compraventas","Donaciones","Testamentos"],
        ];

        $datareturn = [
            "data" => $data,
        ];

        return json_encode($datareturn);
    }

    }
}

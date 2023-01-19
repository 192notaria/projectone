<?php

namespace App\Http\Controllers;

use App\Models\Proyectos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // $data = [
        //     "values" => [15,90,30],
        //     "labels" => ["Compraventas","Donaciones","Testamentos"],
        // ];

        // $datareturn = [
        //     "data" => $data,
        // ];

        // return json_encode($datareturn);
        $actos = Proyectos::select('servicio_id', DB::raw('count(*) as cantidad'))->groupBy('servicio_id')->orderBy('cantidad', "DESC")->limit(5)->get();
            $values = [];
            $labels = [];
            foreach($actos as $acto){
                 array_push($values,$acto->cantidad);
                 array_push($labels,$acto->servicio->nombre);
            }
            $data = [
                "values" => $values,
                "labels" => $labels,
            ];
            $datareturn = [
                "data" => $data,
            ];
            // $actos = Proyectos::selectRaw('count(*) as qty')
            //     ->groupBy('if')
            //     ->get();
            // $actos = DB::table('proyectos')
            //     ->groupBy('servicio_id')
            //     ->having(DB::raw('count(*)'), '<', 2)
            //     ->pluck('servicio_id');
            return json_encode($datareturn);
    }

        if($request->type == 'prueba'){
            $actos = Proyectos::select('servicio_id', DB::raw('count(*) as cantidad'))->groupBy('servicio_id')->orderBy('cantidad', "DESC")->get();
            $values = [];
            $labels = [];
            foreach($actos as $acto){
                 array_push($values,$acto->cantidad);
                 array_push($labels,$acto->servicio->nombre);
            }
            $data = [
                "values" => $values,
                "labels" => $labels,
            ];
            $datareturn = [
                "data" => $data,
            ];
            // $actos = Proyectos::selectRaw('count(*) as qty')
            //     ->groupBy('if')
            //     ->get();
            // $actos = DB::table('proyectos')
            //     ->groupBy('servicio_id')
            //     ->having(DB::raw('count(*)'), '<', 2)
            //     ->pluck('servicio_id');
            return json_encode($datareturn);
        }
    }
}

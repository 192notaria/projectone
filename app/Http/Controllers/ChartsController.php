<?php

namespace App\Http\Controllers;

use App\Models\Proyectos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartsController extends Controller
{
    public function index(Request $request){

    if($request->type == 'area'){
        $proyectos = Proyectos::select("id", "created_at")->get()->groupBy(function ($date){
            return Carbon::parse($date->created_at)->format('m'); // grouping by months
        });

        $mes = "";
        $proyectosArray = [];
        foreach ($proyectos as $key => $value) {

            if((int)$key == 1) $mes = "Enero";
            if((int)$key == 2) $mes = "Febrero";
            if((int)$key == 3) $mes = "Marzo";
            if((int)$key == 4) $mes = "Abril";
            if((int)$key == 5) $mes = "Mayo";
            if((int)$key == 6) $mes = "Junio";
            if((int)$key == 7) $mes = "Julio";
            if((int)$key == 8) $mes = "Agosto";
            if((int)$key == 9) $mes = "Septiembre";
            if((int)$key == 10) $mes = "Octubre";
            if((int)$key == 11) $mes = "Noviembre";
            if((int)$key == 12) $mes = "Diciembre";

            $dataarray = ["x" => $mes, "y" => count($value)];
            array_push($proyectosArray, $dataarray);
            // $proyectosArray[(int)$key] = count($value);
        }
        // return json_encode($proyectosArray);

        // $data = [
        //     ["x" => "Enero", "y" => "120000"],
        //     ["x" => "Febrero", "y" => "190000"],
        //     ["x" => "Marzo", "y" => "12000"],
        //     ["x" => "Abril", "y" => "120000"],
        //     ["x" => "Mayo", "y" => "13900"],
        //     ["x" => "Junio", "y" => "190000"],
        //     ["x" => "Julio", "y" => "12200"],
        //     ["x" => "Agosto", "y" => "120000"],
        //     ["x" => "Septiembre", "y" => "13200"],
        //     ["x" => "Octubre", "y" => "15000"],
        //     ["x" => "Noviembre", "y" => "220000"],
        //     ["x" => "Diciembre", "y" => "1200"],
        // ];

        $datareturn = [
            "data" => $proyectosArray,
            "type" => $request->type
        ];

        return json_encode($datareturn);
    }
        $factory = (new Factory)->withServiceAccount(__DIR__."/firebase_credentials.json");
        if($request->type == 'dounut'){
            $actos = Proyectos::select('servicio_id', DB::raw('count(*) as cantidad'))->groupBy('servicio_id')->orderBy('cantidad', "DESC")->take(10)->get();
            $values = [];
            $labels = [];
            foreach($actos as $acto){
                array_push($values,$acto->cantidad);
                array_push($labels,$acto->servicio->nombre);

                $firestore = $factory->createFirestore();
                $database = $firestore->database();
                $testRef = $database->collection('pie_chart')->newDocument();
                $testRef->set([
                    'id' => $testRef->id(),
                    'cantidad' => $acto->cantidad,
                    'acto' => $acto->servicio->nombre,
                ]);
            }
            $data = [
                "values" => $values,
                "labels" => $labels,
            ];
            $datareturn = [
                "data" => $data,
            ];

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

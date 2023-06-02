<?php

namespace App\Http\Controllers;

use App\Models\Proyectos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Factory;

class ChartsController extends Controller
{
    public function index(Request $request){
        $year = date("Y", time());
        if($request->type == 'area'){
            $proyectos = Proyectos::select("id", "created_at")->whereYear("created_at", $year)->get()->groupBy(function ($date){
                return Carbon::parse($date->created_at)->format('m');
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
            }
            $datareturn = [
                "data" => $proyectosArray,
                "type" => $request->type
            ];
            return json_encode($datareturn);
        }

        if($request->type == 'dounut'){
            $actos = Proyectos::select('servicio_id', DB::raw('count(*) as cantidad'))->where("status", "!=", 5)->groupBy('servicio_id')->orderBy('cantidad', "DESC")->get();
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
            return json_encode($datareturn);
        }

        if($request->type == 'demo'){
            $factory = (new Factory)->withServiceAccount(__DIR__."/firebase_credentials.json");
            $firestore = $factory->createFirestore();
            $database = $firestore->database();
            $actos = Proyectos::select('servicio_id', DB::raw('count(*) as cantidad'))->groupBy('servicio_id')->orderBy('cantidad', "DESC")->take(5)->get();
            foreach($actos as $acto){
                $testRef = $database->collection('piechart')->newDocument();
                $testRef->set([
                    'id' => $testRef->id(),
                    'servicio_id' => $acto->servicio->id,
                    'cantidad' => $acto->cantidad,
                    'acto' => $acto->servicio->nombre ?? "Sin nombre",
                ]);
                // array_push($values,$acto->cantidad);
                // array_push($labels,$acto->servicio->nombre);
            }
        }
    }
}

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
            $actos = Proyectos::select('servicio_id', DB::raw('count(*) as cantidad'))->where("status", "!=", "5")->groupBy('servicio_id')->orderBy('cantidad', "DESC")->take(5)->get();
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

        if($request->type == 'notification'){
            $url = 'https://fcm.googleapis.com/fcm/send';
            $serverKey = 'AAAAQwE2vxw:APA91bEkJ06IORB6GNrtyTdsnLitXE5JDD1VCvovoVWbwgVAojxBcU8G8C0C3WB5C5XIUWye1CvK2hc475VdHGrFqPseOvto8j7LAii7lcocX2zskqXSTihZCCGFB3twSvbWALhLny_q';

            $data = [
                "to" => "B788Z5ZQ8Q",
                // "registration_ids" => ["B788Z5ZQ8Q"],
                "notification" => [
                    "title" => "Prueba de notificacion",
                    "body" => "Prueba de notificacion desde Laravel",
                ]
            ];
            $encodedData = json_encode($data);

            $headers = [
                'Authorization:key=' . $serverKey,
                'Content-Type: application/json',
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
            // Execute post
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }
            // Close connection
            curl_close($ch);
            // FCM response
            dd($result);
        }
    }
}

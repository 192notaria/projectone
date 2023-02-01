<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Proyectos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Factory;

class FirebaseAuthController extends Controller
{
    private $ref;

    public function index(){
        $firebase = (new Factory)
            ->withServiceAccount(__DIR__."/firebase_credentials.json")
            ->withDatabaseUri('https://notaria192-158b7-default-rtdb.firebaseio.com');

//Registrar clientes firebase
        // $clientes = Clientes::all();
        // foreach($clientes as $cliente){
        //     $municipio = isset($cliente->getMunicipio->nombre) ? $cliente->getMunicipio->nombre : "";
        //     $estado = isset($cliente->getMunicipio->getEstado->nombre) ? $cliente->getMunicipio->getEstado->nombre : "";
        //     $pais = isset($cliente->getMunicipio->getEstado->getPais->nombre) ? $cliente->getMunicipio->getEstado->getPais->nombre : "";
        //     $ocupacion = isset($cliente->getOcupacion->nombre) ? $cliente->getOcupacion->nombre : "";

        //     $clienteData = [
        //         'municipio_nacimiento' => $municipio . " " . $estado . " " .$pais,
        //         'fecha_nacimiento' => $cliente->fecha_nacimiento,
        //         'email' => $cliente->email,
        //         'telefono' => $cliente->telefono,
        //         'ocupacion' => $ocupacion,
        //         'estado_civil' => $cliente->estado_civil,
        //         'genero' => $cliente->genero,
        //         'rfc' => $cliente->rfc,
        //         'curp' => $cliente->curp
        //     ];

        //     $database = $firebase->createDatabase();
        //     // $cliente_firebasekey = $database->getReference('clientes/' . $cliente->firebase_key)->update($clienteData);
        //     $cliente_firebasekey = $database->getReference('clientes/' . str_replace(".", "_", $cliente->nombre) . " " . $cliente->apaterno . " " . $cliente->amaterno)->set($clienteData);

        //     $updateCliente = Clientes::find($cliente->id);
        //     $updateCliente->firebase_key = $cliente_firebasekey->getKey();
        //     $updateCliente->save();
        // }

        //Registrar proyectos con su avance
            $escrituras = Proyectos::all();
            foreach($escrituras as $escritura){
                $arrayTemp = [];
                foreach ($escritura->avance as $key => $value) {
                    $data = [];
                    array_push($arrayTemp, $data);
                    $arrayTemp[$value->proceso->nombre] = $arrayTemp[$key];
                    unset($arrayTemp[$key]);
                }

                foreach ($escritura->avance as $key => $value) {
                    $newdata = [
                        "registro" => $value->subproceso->nombre,
                        "date" => $value->subproceso->created_at,
                    ];
                    $arrayTemp[$value->proceso->nombre] = $newdata;
                }

                $escrituraData = [
                    'acto' => $escritura->servicio->nombre,
                    'abogado' => $escritura->abogado->name . " " . $escritura->abogado->apaterno . " " . $escritura->abogado->amaterno,
                    'date' => $escritura->created_at,
                    'qr' => Hash::make($escritura->servicio->nombre . $escritura->abogado->name . $escritura->abogado->apaterno . $escritura->abogado->amaterno . $escritura->created_at),
                    'avance' => $arrayTemp
                ];

                $database = $firebase->createDatabase();
                $firebasekey = $database->getReference('clientes/' . str_replace(".", "_", $escritura->cliente->nombre) . " " . $escritura->cliente->apaterno . " " . $escritura->cliente->amaterno . "/" . $escritura->servicio->nombre . $escritura->id)->set($escrituraData);
                // $escritura_search = Proyectos::find($escritura->id);
                // $escritura_search->firebase_key = $firebasekey->getKey();
                // $escritura_search->save();
            }

            // Get data
            // $database = $firebase->createDatabase();
            // $values = $database->getReference('clientes')->getSnapshot()->getValue();
            // $snapshot = $reference->getSnapshot();
            // foreach($reference as $ref){
            //     return $ref;
            // }

            // return $this->ref->getValue();
            // return view("firebase_demo", compact('values'));
    }

    public function sendemail(){
        $mail_data = [
            "recipient" => 'carlos.avalos0812@gmail.com',
            "fromEmail" => "notaria192@gmail.com",
            "fromName" => "Notaria 192 Michoacán",
            "subject" => "Tu escritura esta lista para su entrega",
            "body" => "Hola",
        ];

        \Mail::send('email-template', $mail_data, function($message) use ($mail_data){
            $message->to($mail_data['recipient'])
                ->from($mail_data['fromEmail'], $mail_data['fromName'])
                ->subject($mail_data['subject']);
        });
    }
}

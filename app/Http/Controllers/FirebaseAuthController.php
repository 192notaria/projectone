<?php

namespace App\Http\Controllers;

use App\Models\AvanceProyecto;
use App\Models\Clientes;
use App\Models\Proyectos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Kreait\Firebase\Contract\Firestore;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Factory;
use Google\Cloud\Firestore\FirestoreClient;


class FirebaseAuthController extends Controller
{
    public function index(){
        $factory = (new Factory)->withServiceAccount(__DIR__."/firebase_credentials.json");
        $firestore = $factory->createFirestore();
        $database = $firestore->database();

//Registrar clientes firebase
        // $clientes = Clientes::all();
        // foreach($clientes as $cliente){
        //     $municipio = isset($cliente->getMunicipio->nombre) ? $cliente->getMunicipio->nombre : "";
        //     $estado = isset($cliente->getMunicipio->getEstado->nombre) ? $cliente->getMunicipio->getEstado->nombre : "";
        //     $pais = isset($cliente->getMunicipio->getEstado->getPais->nombre) ? $cliente->getMunicipio->getEstado->getPais->nombre : "";
        //     $ocupacion = isset($cliente->getOcupacion->nombre) ? $cliente->getOcupacion->nombre : "";
        //     // $testRef = $database->collection('clientes')->document($cliente->firebase_key);
        //     $testRef = $database->collection('clientes')->newDocument();

        //     $testRef->set([
        //         'id' => $testRef->id(),
        //         'nombre' => $cliente->nombre,
        //         'apaterno' => $cliente->apaterno,
        //         'amaterno' => $cliente->amaterno,
        //         'municipio_nacimiento' => $municipio . " " . $estado . " " .$pais,
        //         'fecha_nacimiento' => $cliente->fecha_nacimiento,
        //         'email' => $cliente->email,
        //         'telefono' => $cliente->telefono,
        //         'ocupacion' => $ocupacion,
        //         'estado_civil' => $cliente->estado_civil,
        //         'genero' => $cliente->genero,
        //         'rfc' => $cliente->rfc,
        //         'curp' => $cliente->curp
        //     ]);

        //     $updateCliente = Clientes::find($cliente->id);
        //     $updateCliente->firebase_key = $testRef->id();
        //     $updateCliente->save();
        // }

//Registrar escrituras
            // $escrituras = Proyectos::all();
            // foreach($escrituras as $escritura){
            //     // $testRef = $database->collection('clientes')
            //     //     ->document($escritura->cliente->firebase_key)
            //     //     ->collection('escrituras')
            //     //     ->document($escritura->firebase_key);
            //     $testRef = $database->collection('clientes')
            //         ->document($escritura->cliente->firebase_key)
            //         ->collection('escrituras')
            //         ->newDocument();

            //     $testRef->set([
            //         'id' => $testRef->id(),
            //         'acto' => $escritura->servicio->nombre,
            //         'abogado' => $escritura->abogado->name . " " . $escritura->abogado->apaterno . " " . $escritura->abogado->amaterno,
            //         'fecha_registro' => $escritura->created_at,
            //         'qr' => Hash::make($escritura->servicio->nombre . $escritura->abogado->name . $escritura->abogado->apaterno . $escritura->abogado->amaterno . $escritura->created_at),
            //     ]);

            //     $escritura_search = Proyectos::find($escritura->id);
            //     $escritura_search->firebase_key = $testRef->id();
            //     $escritura_search->save();
            // }

//Registrar avance de escrituras
            $avances = AvanceProyecto::all();
            foreach($avances as $avance){
            // $testRef = $database->collection('clientes')
            //     ->document($avance->proyecto->cliente->firebase_key)
            //     ->collection('escrituras')
            //     ->document($avance->proyecto->firebase_key)
            //     ->collection('avance')
            //     ->document($avance->firebase_key);
            $testRef = $database->collection('clientes')
                ->document($avance->proyecto->cliente->firebase_key)
                ->collection('escrituras')
                ->document($avance->proyecto->firebase_key)
                ->collection('avance')
                ->newDocument();

                $testRef->set([
                    "id" => $testRef->id(),
                    "proyecto" => $avance->proyecto->servicio->nombre,
                    "proceso" => $avance->proceso->nombre,
                    "subproceso" => $avance->subproceso->nombre,
                    "fecha_registro" => $avance->created_at
                ]);
                $avancessearch = AvanceProyecto::find($avance->id);
                $avancessearch->firebase_key = $testRef->id();
                $avancessearch->save();
            }
    }

    public function sendemail(){
        $mail_data = [
            "recipient" => 'carlos.avalos0812@gmail.com',
            "fromEmail" => "notaria192@gmail.com",
            "fromName" => "Notaria 192 Michoacán",
            "subject" => "Tu escritura esta lista para su entrega",
            "body" => "Hola",
        ];

        // \Mail::send('email-template', $mail_data, function($message) use ($mail_data){
        //     $message->to($mail_data['recipient'])
        //         ->from($mail_data['fromEmail'], $mail_data['fromName'])
        //         ->subject($mail_data['subject']);
        // });
    }
}

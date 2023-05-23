<?php

namespace App\Http\Controllers;

use App\Models\AvanceProyecto;
use App\Models\Clientes;
use App\Models\Partes;
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

        // Registrar escrituras
        $escrituras = Proyectos::all();
        foreach($escrituras as $escritura){
            $qr_data = Hash::make($escritura->servicio->nombre . $escritura->abogado->name . $escritura->abogado->apaterno . $escritura->abogado->amaterno . $escritura->created_at);
            $testRef = $database->collection('actos')->newDocument();
            $testRef->set([
                'id' => $testRef->id(),
                'omitido' => $escritura->omitido,
                'usuario' => $escritura->usuario->name ?? "",
                'created_at' => $escritura->created_at,
                'acto' => $escritura->servicio->nombre,
                'tipo_acto' => $escritura->servicio->tipo_acto->nombre,
                'abogado' => $escritura->abogado->name . " " . $escritura->abogado->apaterno . " " . $escritura->abogado->amaterno,
                'cliente' => $escritura->cliente->nombre . " " . $escritura->cliente->apaterno . " " . $escritura->cliente->amaterno,
                'numero_escritura' => $escritura->numero_escritura ?? "S/N",
                'volumen' => $escritura->volumen,
                'folios' => $escritura->folio_inicio . " - " . $escritura->folio_fin,
                'status' => $escritura->status,
                'fecha_registro' => $escritura->created_at,
                'qr' => $qr_data
            ]);

            $avance = AvanceProyecto::find($escritura->id);
            $avance->firebase_key = $testRef->id();
            $avance->save();
        }
    }

    public function clientes_firebase(){
        $factory = (new Factory)->withServiceAccount(__DIR__."/firebase_credentials.json");
        $firestore = $factory->createFirestore();
        $database = $firestore->database();

        // Registrar clientes firebase
        $clientes = Clientes::all();
        foreach($clientes as $cliente){
            $municipio = isset($cliente->getMunicipio->nombre) ? $cliente->getMunicipio->nombre : "";
            $estado = isset($cliente->getMunicipio->getEstado->nombre) ? $cliente->getMunicipio->getEstado->nombre : "";
            $pais = isset($cliente->getMunicipio->getEstado->getPais->nombre) ? $cliente->getMunicipio->getEstado->getPais->nombre : "";
            $ocupacion = isset($cliente->getOcupacion->nombre) ? $cliente->getOcupacion->nombre : "";
            $testRef = $database->collection('clientes')->newDocument();
            $nacimiento_mun = $municipio . " " . $estado . " " . $pais;
            $testRef->set([
                'id' => $testRef->id(),
                'nombre' => $cliente->nombre ?? "",
                'apaterno' => $cliente->apaterno ?? "",
                'amaterno' => $cliente->amaterno ?? "",
                'municipio_nacimiento' => $nacimiento_mun,
                'fecha_nacimiento' => $cliente->fecha_nacimiento,
                'email' => $cliente->email,
                'telefono' => $cliente->telefono,
                'ocupacion' => $ocupacion,
                'estado_civil' => $cliente->estado_civil,
                'genero' => $cliente->genero,
                'curp' => $cliente->curp,
                'rfc' => $cliente->rfc,
                'tipo_cliente' => $cliente->tipo_cliente ?? "N/A",
                'razon_social' => $cliente->razon_social ?? "N/A",
                'firebase_key' => $testRef->id()
            ]);

            $updateCliente = Clientes::find($cliente->id);
            $updateCliente->firebase_key = $testRef->id();
            $updateCliente->save();
        }
    }

    public function partes_proyectos_firebase(){
        $factory = (new Factory)->withServiceAccount(__DIR__."/firebase_credentials.json");
        $firestore = $factory->createFirestore();
        $database = $firestore->database();

        $escrituras = Proyectos::all();

        foreach($escrituras as $escritura){
            foreach ($escritura->partes as $key => $value) {
                $testRef = $database->collection('actos')
                    ->document($escritura->firebase_key)
                    ->collection('partes')
                    ->newDocument();
                $testRef->set([
                    'id' => $testRef->id(),
                    'nombre' => $value->nombre,
                    'apaterno' => $value->apaterno,
                    'amaterno' => $value->amaterno,
                    'tipo_persona' => $value->tipo_persona,
                    'curp' => $value->curp,
                    'rfc' => $value->rfc,
                    'tipo' => $value->tipo,
                    'porcentaje' => $value->porcentaje == 0 ? 100 : $value->porcentaje,
                ]);
                $parte = Partes::find($value->id);
                $parte->firebase_key = $testRef->id();
                $parte->save();
            }
        }
    }

    public function avance_firebase(){
        $factory = (new Factory)->withServiceAccount(__DIR__."/firebase_credentials.json");
        $firestore = $factory->createFirestore();
        $database = $firestore->database();
            $escrituras = Proyectos::all();
            foreach($escrituras as $escritura){
                if(count($escritura->avance) > 0){
                    foreach ($escritura->avance as $key => $value) {
                        $testRef = $database->collection('actos')
                            ->document($escritura->firebase_key)
                            ->collection('avance')
                            ->newDocument();

                        $testRef->set([
                            'id' => $testRef->id(),
                            'proceso' => $value->proceso->nombre,
                            'subproceso' => $value->subproceso->nombre,
                            'omitido' => $value->omitido,
                            'usuario' => $value->usuario->name ?? "",
                            'created_at' => $value->created_at,
                        ]);
                        $avance = AvanceProyecto::find($value->id);
                        $avance->firebase_key = $testRef->id();
                        $avance->save();
                    }
                }
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

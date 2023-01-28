<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Factory;

class FirebaseAuthController extends Controller
{

    public function index(){
        $firebase = (new Factory)
            ->withServiceAccount(__DIR__."/firebase_credentials.json")
            ->withDatabaseUri('https://notaria192-158b7-default-rtdb.firebaseio.com');

        $clientes = Clientes::all();
        foreach($clientes as $cliente){
            $municipio = isset($cliente->getMunicipio->nombre) ? $cliente->getMunicipio->nombre : "";
            $estado = isset($cliente->getMunicipio->getEstado->nombre) ? $cliente->getMunicipio->getEstado->nombre : "";
            $pais = isset($cliente->getMunicipio->getEstado->getPais->nombre) ? $cliente->getMunicipio->getEstado->getPais->nombre : "";
            $ocupacion = isset($cliente->getOcupacion->nombre) ? $cliente->getOcupacion->nombre : "";
            $clienteData = [
                'nombre' => $cliente->nombre . " " . $cliente->apaterno . " " . $cliente->amaterno,
                'municipio_nacimiento' => $municipio . " " . $estado . " " .$pais,
                'fecha_nacimiento' => $cliente->fecha_nacimiento,
                'email' => $cliente->email,
                'telefono' => $cliente->telefono,
                'ocupacion' => $ocupacion,
                'estado_civil' => $cliente->estado_civil,
                'genero' => $cliente->genero,
                'rfc' => $cliente->rfc,
                'curp' => $cliente->curp
            ];

            $database = $firebase->createDatabase();
            $cliente_firebasekey = $database->getReference('clientes/' . $cliente->firebase_key)->update($clienteData);

            // $updateCliente = Clientes::find($cliente->id);
            // $updateCliente->firebase_key = $cliente_firebasekey->getKey();
            // $updateCliente->save();
        }
        // print_r($postRef->getKey());



        // $blog = $database
        //     ->getReference('actos');

        // // echo '<pre>';
        // // print_r($blog->getvalue());
        // // echo '</pre>';
    }
}

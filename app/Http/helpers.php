<?php

use App\Events\NotificationEvent;
use App\Models\LoginLog;
use App\Models\Notifications;
use App\Models\Proyectos;
use App\Models\User;
use Carbon\Carbon;
use Kreait\Firebase\Factory;

    function activeRoute($route, $isClass = false): string {
        $requesUrl = request()->fullUrl() === $route ? true : false;
        if($isClass){
            return $requesUrl ? $isClass : '';
        }else{
            return $requesUrl ? 'active' : '';
        }
    }

    function notifyAdmins($name, $body, $channel, $authId){
        // dd("hola helper");
        // $administradores = User::whereHas("roles",
        //     function($data){
        //         $data->where('name', "ADMINISTRADOR");
        // })->get();

        // foreach ($administradores as $admin) {
        //     if($admin->id != $authId){
        //         $notificacion = new Notifications;
        //         $notificacion->name = $name;
        //         $notificacion->body = $body;
        //         $notificacion->viewed = false;
        //         $notificacion->channel = $channel;
        //         $notificacion->user_id = $admin->id;
        //         $notificacion->save();
        //         event(new NotificationEvent($admin->id, $body));
        //     }
        // }
    }

    function notificarCambioGuardia($user_guardia_id, $usuario_solicitante_id, $fecha){
        $usuario_solicitante = User::find($usuario_solicitante_id);
        $mensaje = $usuario_solicitante->name . " " . $usuario_solicitante->apaterno .
            " te solicita hacer un cambio de guardia el dia " . Carbon::create($fecha)->isoFormat('dddd D \d\e MMMM');
        $notificacion = new Notifications;
        $notificacion->name = "Solicitud de cambio de guardia";
        $notificacion->body = $mensaje;
        $notificacion->viewed = false;
        $notificacion->channel = "private";
        $notificacion->user_id = $user_guardia_id;
        $notificacion->save();
        return event(new NotificationEvent($user_guardia_id, $mensaje));
    }

    function create_firebase_project($id){
        $escritura = Proyectos::find($id);
        $qr_data = Hash::make($escritura->servicio->nombre . $escritura->abogado->name . $escritura->abogado->apaterno . $escritura->abogado->amaterno . $escritura->created_at);
        $folios = $escritura->folio_inicio ?? "S/F" . " - " . $escritura->folio_fin ?? "S/F";

        $factory = (new Factory)->withServiceAccount(env("FIREBASE_CREDENTIALS"));
        $firestore = $factory->createFirestore();
        $database = $firestore->database();
        $testRef = $database->collection('actos')->newDocument();
        $testRef->set([
            'id' => $testRef->id(),
            'acto' => $escritura->servicio->nombre,
            'tipo_acto' => $escritura->servicio->tipo_acto->nombre,
            'abogado' => $escritura->abogado->name . " " . $escritura->abogado->apaterno . " " . $escritura->abogado->amaterno,
            'cliente' => $escritura->cliente->nombre . " " . $escritura->cliente->apaterno . " " . $escritura->cliente->amaterno,
            'numero_escritura' => $escritura->numero_escritura ?? "S/N",
            'volumen' => $escritura->volumen,
            'folios' => $folios,
            'status' => $escritura->status,
            'fecha_registro' => $escritura->created_at,
            'qr' => $qr_data
        ]);
        $escritura->firebase_key = $testRef->id();
        $escritura->qr = $qr_data;
        $escritura->save();
    }
?>

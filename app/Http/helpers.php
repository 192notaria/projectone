<?php

use App\Events\NotificationEvent;
use App\Models\Egresos;
use App\Models\LoginLog;
use App\Models\Notifications;
use App\Models\ObservacionesProyectos;
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

        $factory = (new Factory)->withServiceAccount(__DIR__."/firebase_credentials.json");
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

    function edit_firebase_project($id){
        $escritura = Proyectos::find($id);
        $folios = $escritura->folio_inicio ?? "S/F" . " - " . $escritura->folio_fin ?? "S/F";
        $factory = (new Factory)->withServiceAccount(__DIR__."/firebase_credentials.json");
        $firestore = $factory->createFirestore();
        $database = $firestore->database();
        $testRef = $database->collection('actos')->document($escritura->firebase_key);
        $testRef->set([
            'acto' => $escritura->servicio->nombre,
            'tipo_acto' => $escritura->servicio->tipo_acto->nombre,
            'abogado' => $escritura->abogado->name . " " . $escritura->abogado->apaterno . " " . $escritura->abogado->amaterno,
            'cliente' => $escritura->cliente->nombre . " " . $escritura->cliente->apaterno . " " . $escritura->cliente->amaterno,
            'numero_escritura' => $escritura->numero_escritura ?? "S/N",
            'volumen' => $escritura->volumen,
            'folios' => $folios,
            'status' => $escritura->status,
            'fecha_registro' => $escritura->created_at,
            // 'qr' => $escritura->qr
        ]);
    }

    function agregar_observaciones_firebase($id){
        $observacion = ObservacionesProyectos::find($id);
        $factory = (new Factory)->withServiceAccount(__DIR__."/firebase_credentials.json");
        $firestore = $factory->createFirestore();
        $database = $firestore->database();
        $testRef = $database->collection('actos')->document($observacion->proyectos->firebase_key)->collection('observaciones')->newDocument();
        $testRef->set([
            'descripcion' => $observacion->comentarios,
            'usuario' => $observacion->usuarios->name . " " . $observacion->usuarios->apaterno,
            'created_at' => $observacion->created_at,
        ]);
        $observacion->firebase_key = $testRef->id();
        $observacion->save();
    }

    function delete_firebase_project($id){
        $escritura = Proyectos::find($id);
        $factory = (new Factory)->withServiceAccount(__DIR__."/firebase_credentials.json");
        $firestore = $factory->createFirestore();
        $database = $firestore->database();
        $database->collection('actos')->document($escritura->firebase_key)->delete();
    }

    function login_logs_firebase($id){
        $login = LoginLog::find($id);
        if($login->usuario->email != "admin@admin.com"){
            $factory = (new Factory)->withServiceAccount(__DIR__."/firebase_credentials.json");
            $firestore = $factory->createFirestore();
            $database = $firestore->database();
            $testRef = $database->collection('logins')->newDocument();
            $testRef->set([
                'id' => $testRef->id(),
                'usuario' => $login->usuario->name . " " . $login->usuario->apaterno,
                'ip' => $login->local_ip,
                'created_at' => $login->created_at,
            ]);
        }
    }

    function send_notification_to_firebase_egresos($id, $tittle, $body){
        $egreso = Egresos::find($id);
        $factory = (new Factory)->withServiceAccount(__DIR__."/firebase_credentials.json");
        $firestore = $factory->createFirestore();
        $database = $firestore->database();
        $testRef = $database->collection('notifications')->newDocument();
        $testRef->set([
            'id' => $testRef->id(),
            'tittle' => $tittle,
            'body' => $body,
            'created_at' => $egreso->created_at,
        ]);
    }

    function save_notification($tittle, $body, $user_id){
        $notification = new Notifications;
        $notification->name = $tittle;
        $notification->body = $body;
        $notification->viewed = 0;
        $notification->channel = "private";
        $notification->user_id = $user_id;
        $notification->save();
        event(new NotificationEvent($user_id, $tittle));
    }
?>

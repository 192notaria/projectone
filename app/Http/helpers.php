<?php

use App\Events\NotificationEvent;
use App\Models\Notifications;
use App\Models\User;
use Carbon\Carbon;

    function activeRoute($route, $isClass = false): string {
        $requesUrl = request()->fullUrl() === $route ? true : false;
        if($isClass){
            return $requesUrl ? $isClass : '';
        }else{
            return $requesUrl ? 'active' : '';
        }
    }

    function notifyAdmins($name, $body, $channel, $authId){
        dd("hola helper");
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
?>

<?php

use App\Events\NotificationEvent;
use App\Models\Notifications;
use App\Models\User;

    function activeRoute($route, $isClass = false): string {
        $requesUrl = request()->fullUrl() === $route ? true : false;
        if($isClass){
            return $requesUrl ? $isClass : '';
        }else{
            return $requesUrl ? 'active' : '';
        }
    }

    function notifyAdmins($name, $body, $channel, $bodyAuthUser, $authId){
        $administradores = User::whereHas("roles",
            function($data){
                $data->where('name', "ADMINISTRADOR");
            })->get();

        foreach ($administradores as $admin) {
            if($admin->id != $authId){
                $notificacion = new Notifications;
                $notificacion->name = $name;
                $notificacion->body = $body;
                $notificacion->viewed = false;
                $notificacion->channel = $channel;
                $notificacion->user_id = $admin->id;
                $notificacion->save();
                event(new NotificationEvent($admin->id, $body));
            }
                event(new NotificationEvent($authId, $bodyAuthUser));
        }
    }

    function bitacora ($usuario, $cliente, $proyecto, $proceso, $subproceso, $tipo){

    }
?>

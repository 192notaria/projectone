<?php

namespace App\Observers;

use App\Models\Bitacora;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        // dd($user);
        $bitacora = new Bitacora;
        $bitacora->actividad = "Nuevo registro";
        $bitacora->detalle = "Nuevo usuario registrado";
        $bitacora->descripcion = auth()->user()->name . " " . auth()->user()->apaterno .
            " ha registrado a " .
            $user->name . " " . $user->apaterno . " " . $user->amaterno . " como nuevo usuario";
        $bitacora->user_id = auth()->user()->id;
        $bitacora->save();
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        $bitacora = new Bitacora;
        $bitacora->actividad = "Registro editado";
        $bitacora->detalle = "Usuario editado";
        $usuarioAuth = auth()->user()->name . " " . auth()->user()->apaterno;
        $bitacora->descripcion =  $usuarioAuth . " ha editado los datos del usuario " .
            $user->name . " " . $user->apaterno . " " . $user->amaterno;
        $bitacora->user_id = auth()->user()->id;
        $bitacora->save();
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        $bitacora = new Bitacora;
        $bitacora->actividad = "Registro borrado";
        $bitacora->detalle = "Usuario borrado";
        $usuarioAuth = auth()->user()->name . " " . auth()->user()->apaterno;
        $bitacora->descripcion =  $usuarioAuth . " ha borrado los datos del usuario " .
            $user->name . " " . $user->apaterno . " " . $user->amaterno;
        $bitacora->user_id = auth()->user()->id;
        $bitacora->save();
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}

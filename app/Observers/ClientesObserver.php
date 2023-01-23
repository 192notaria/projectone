<?php

namespace App\Observers;

use App\Models\Bitacora;
use App\Models\Clientes;

class ClientesObserver
{
    /**
     * Handle the Clientes "created" event.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return void
     */
    public function created(Clientes $clientes)
    {
        $bitacora = new Bitacora;
        $bitacora->actividad = "Nuevo registro";
        $bitacora->detalle = "Nuevo cliente registrado";
        $bitacora->descripcion = auth()->user()->name . " " . auth()->user()->apaterno .
            " ha registrado a " .
            $clientes->nombre . " " . $clientes->apaterno . " " . $clientes->amaterno . " como nuevo cliente";
        $bitacora->user_id = auth()->user()->id;
        $bitacora->save();
    }

    /**
     * Handle the Clientes "updated" event.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return void
     */
    public function updated(Clientes $clientes)
    {
        $bitacora = new Bitacora;
        $bitacora->actividad = "Registro editado";
        $bitacora->detalle = "Cliente editado";
        $bitacora->descripcion = auth()->user()->name . " " . auth()->user()->apaterno .
            " ha editado la informacion del cliente " .
            $clientes->nombre . " " . $clientes->apaterno . " " . $clientes->amaterno;
        $bitacora->user_id = auth()->user()->id;
        $bitacora->save();
    }

    /**
     * Handle the Clientes "deleted" event.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return void
     */
    public function deleted(Clientes $clientes)
    {
        $bitacora = new Bitacora;
        $bitacora->actividad = "Registro borrado";
        $bitacora->detalle = "Cliente borrado";
        $bitacora->descripcion = auth()->user()->name . " " . auth()->user()->apaterno .
            " ha borrado la informacion del cliente " .
            $clientes->nombre . " " . $clientes->apaterno . " " . $clientes->amaterno;
        $bitacora->user_id = auth()->user()->id;
        $bitacora->save();
    }

    /**
     * Handle the Clientes "restored" event.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return void
     */
    public function restored(Clientes $clientes)
    {
        //
    }

    /**
     * Handle the Clientes "force deleted" event.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return void
     */
    public function forceDeleted(Clientes $clientes)
    {
        //
    }
}

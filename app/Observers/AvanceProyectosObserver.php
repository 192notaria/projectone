<?php

namespace App\Observers;

use App\Models\AvanceProyecto;
use App\Models\Bitacora;

class AvanceProyectosObserver
{
    /**
     * Handle the AvanceProyecto "created" event.
     *
     * @param  \App\Models\AvanceProyecto  $avanceProyecto
     * @return void
     */
    public function created(AvanceProyecto $avanceProyecto)
    {
        $bitacora = new Bitacora;
        $bitacora->actividad = "Nuevo registro";
        $bitacora->detalle = $avanceProyecto->subproceso->nombre . " registrado";
        $bitacora->descripcion = auth()->user()->name . " " . auth()->user()->apaterno .
            " ha registrado " . $avanceProyecto->subproceso->nombre . " del acto " . $avanceProyecto->proyecto->servicio->nombre . " para el cliente " .
            $avanceProyecto->proyecto->cliente->nombre . " " . $avanceProyecto->proyecto->cliente->apaterno . " " . $avanceProyecto->proyecto->cliente->amaterno;
        $bitacora->user_id = auth()->user()->id;
        $bitacora->save();
    }

    /**
     * Handle the AvanceProyecto "updated" event.
     *
     * @param  \App\Models\AvanceProyecto  $avanceProyecto
     * @return void
     */
    public function updated(AvanceProyecto $avanceProyecto)
    {
        $bitacora = new Bitacora;
        $bitacora->actividad = "Nuevo registro";
        $bitacora->detalle = $avanceProyecto->subproceso->nombre . " editado";
        $bitacora->descripcion = auth()->user()->name . " " . auth()->user()->apaterno .
            " ha editado " . $avanceProyecto->subproceso->nombre . " del acto " . $avanceProyecto->proyecto->servicio->nombre . " para el cliente " .
            $avanceProyecto->proyecto->cliente->nombre . " " . $avanceProyecto->proyecto->cliente->apaterno . " " . $avanceProyecto->proyecto->cliente->amaterno;
        $bitacora->user_id = auth()->user()->id;
        $bitacora->save();
    }

    /**
     * Handle the AvanceProyecto "deleted" event.
     *
     * @param  \App\Models\AvanceProyecto  $avanceProyecto
     * @return void
     */
    public function deleted(AvanceProyecto $avanceProyecto)
    {
        $bitacora = new Bitacora;
        $bitacora->actividad = "Registro borrado";
        $bitacora->detalle = $avanceProyecto->subproceso->nombre . " borrado";
        $bitacora->descripcion = auth()->user()->name . " " . auth()->user()->apaterno .
            " ha borrado " . $avanceProyecto->subproceso->nombre . " del acto " . $avanceProyecto->proyecto->servicio->nombre . " para el cliente " .
            $avanceProyecto->proyecto->cliente->nombre . " " . $avanceProyecto->proyecto->cliente->apaterno . " " . $avanceProyecto->proyecto->cliente->amaterno;
        $bitacora->user_id = auth()->user()->id;
        $bitacora->save();
    }

    /**
     * Handle the AvanceProyecto "restored" event.
     *
     * @param  \App\Models\AvanceProyecto  $avanceProyecto
     * @return void
     */
    public function restored(AvanceProyecto $avanceProyecto)
    {
        //
    }

    /**
     * Handle the AvanceProyecto "force deleted" event.
     *
     * @param  \App\Models\AvanceProyecto  $avanceProyecto
     * @return void
     */
    public function forceDeleted(AvanceProyecto $avanceProyecto)
    {
        //
    }
}

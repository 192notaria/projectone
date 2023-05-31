<?php

namespace App\Observers;

use App\Models\Bitacora;
use App\Models\Proyectos;

class ProyectosObserver
{
    /**
     * Handle the Proyectos "created" event.
     *
     * @param  \App\Models\Proyectos  $proyectos
     * @return void
     */
    public function created(Proyectos $proyectos)
    {
        if(isset($proyectos->servicio->nombre) && isset($proyectos->cliente->nombre)){
            $bitacora = new Bitacora;
            $bitacora->actividad = "Nuevo registro";
            $bitacora->detalle = "Nuevo acto registrado";
            $bitacora->descripcion = auth()->user()->name . " " . auth()->user()->apaterno .
                " ha registrado un nuevo acto de " . $proyectos->servicio->nombre . " para el cliente " .
                $proyectos->cliente->nombre . " " . $proyectos->cliente->apaterno . " " . $proyectos->cliente->amaterno;
            $bitacora->user_id = auth()->user()->id;
            $bitacora->save();
        }
    }

    /**
     * Handle the Proyectos "updated" event.
     *
     * @param  \App\Models\Proyectos  $proyectos
     * @return void
     */
    public function updated(Proyectos $proyectos)
    {
        if(isset($proyectos->servicio->nombre) && isset($proyectos->cliente->nombre)){
            $bitacora = new Bitacora;
            $bitacora->actividad = "Registro editado";
            $bitacora->detalle = "Acto editado";
            $bitacora->descripcion = auth()->user()->name . " " . auth()->user()->apaterno .
                " ha editado la informacion del acto " . $proyectos->servicio->nombre . " que corresponde al cliente " .
                $proyectos->cliente->nombre . " " . $proyectos->cliente->apaterno . " " . $proyectos->cliente->amaterno;
            $bitacora->user_id = auth()->user()->id;
            $bitacora->save();
        }
    }

    /**
     * Handle the Proyectos "deleted" event.
     *
     * @param  \App\Models\Proyectos  $proyectos
     * @return void
     */
    public function deleted(Proyectos $proyectos)
    {
        $bitacora = new Bitacora;
        $bitacora->actividad = "Registro borrado";
        $bitacora->detalle = "Acto borrado";
        $bitacora->descripcion = auth()->user()->name . " " . auth()->user()->apaterno .
            " ha borrado el acto " . $proyectos->servicio->nombre . " que corresponde al cliente " .
            $proyectos->cliente->nombre . " " . $proyectos->cliente->apaterno . " " . $proyectos->cliente->amaterno;
        $bitacora->user_id = auth()->user()->id;
        $bitacora->save();
    }

    /**
     * Handle the Proyectos "restored" event.
     *
     * @param  \App\Models\Proyectos  $proyectos
     * @return void
     */
    public function restored(Proyectos $proyectos)
    {
        //
    }

    /**
     * Handle the Proyectos "force deleted" event.
     *
     * @param  \App\Models\Proyectos  $proyectos
     * @return void
     */
    public function forceDeleted(Proyectos $proyectos)
    {
        //
    }
}

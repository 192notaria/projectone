<?php

namespace App\Observers;

use App\Models\AvanceProyecto;

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
        //
    }

    /**
     * Handle the AvanceProyecto "updated" event.
     *
     * @param  \App\Models\AvanceProyecto  $avanceProyecto
     * @return void
     */
    public function updated(AvanceProyecto $avanceProyecto)
    {
        //
    }

    /**
     * Handle the AvanceProyecto "deleted" event.
     *
     * @param  \App\Models\AvanceProyecto  $avanceProyecto
     * @return void
     */
    public function deleted(AvanceProyecto $avanceProyecto)
    {
        //
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

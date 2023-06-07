<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionProyecto extends Model
{
    use HasFactory;

    public function proyecto(){
        return $this->belongsTo(Proyectos::class, "proyecto_id");
    }

    public function concepto_pago(){
        return $this->belongsTo(Catalogos_conceptos_pago::class, "concepto_id");
    }
}

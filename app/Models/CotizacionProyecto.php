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
}

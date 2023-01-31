<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcesosServicios extends Model
{
    use HasFactory;
    protected $fillable = ["nombre"];
    public function servicios(){
        return $this->belongsToMany(Servicios::class, "servicios_procesos_servicio");
    }

    public function subprocesos(){
        return $this->hasMany(Subprocesos::class, "proceso_id");
    }
}

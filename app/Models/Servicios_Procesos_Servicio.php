<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicios_Procesos_Servicio extends Model
{
    use HasFactory;
    protected $table = "servicios_procesos_servicio";
    protected $fillable = [
        "servicio_id",
        "proceso_servicio_id",
    ];
}

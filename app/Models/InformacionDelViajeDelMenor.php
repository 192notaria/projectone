<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformacionDelViajeDelMenor extends Model
{
    use HasFactory;
    protected $table = "informacion_del_viaje_del_menor";
    protected $fillable = [
        "pais_procedencia",
        "pais_destino",
        "aereolinea",
        "numero_vuelo",
        "nombre_garita",
        "tiempo_extranjero",
        "domicilio_destino",
        "personas_viaje",
        "proyecto_id",
    ];
}

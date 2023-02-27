<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    use HasFactory;

    protected $fillable = [
        "nombre"
    ];

    public function procesos(){
        return $this->belongsToMany(ProcesosServicios::class, "servicios_procesos_servicio", "servicio_id", "proceso_servicio_id");
    }

    public function conceptos_pago(){
        return $this->belongsToMany(Catalogos_conceptos_pago::class, "servicios_conceptos_pagos", "servicio_id", "concepto_pago_id")
        ->orderBy('categoria_gasto_id', 'ASC')
        ->orderBy('descripcion', 'ASC');
    }
}

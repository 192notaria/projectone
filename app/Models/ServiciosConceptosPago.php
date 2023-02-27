<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiciosConceptosPago extends Model
{
    use HasFactory;
    protected $fillable = [
        "servicio_id",
        "concepto_pago_id",
    ];

}

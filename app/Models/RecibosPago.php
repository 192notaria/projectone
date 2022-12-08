<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecibosPago extends Model
{
    use HasFactory;
    protected $fillable = [
        "nombre",
        "path",
        "costo_recibo",
        "gastos_gestoria",
        "cliente_id",
        "proyecto_id"
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutorizacionCatastro extends Model
{
    use HasFactory;
    protected $fillable = [
        "comprobante",
        "cuenta_predial",
        "clave_catastral",
        "proceso_id",
        "subproceso_id",
        "proyecto_id",
    ];
}

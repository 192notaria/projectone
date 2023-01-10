<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Herederos extends Model
{
    use HasFactory;
    protected $fillable = [
        "cliente_id",
        "proyecto_id",
        "tipo",
        "acta_nacimiento",
        "acta_matrimonio",
        "curp",
        "rfc",
        "identificacion_oficial_con_foto",
        "comprobante_domicilio",
        "hijo",
    ];
}

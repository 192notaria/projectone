<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroFirmas extends Model
{
    use HasFactory;
    protected $fillable = [
        "nombre",
        "fechayhora",
        "proceso_id",
        "subproceso_id",
        "cliente_id",
        "proyecto_id"
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Firmas extends Model
{
    use HasFactory;
    protected $fillable = [
        "nombre",
        "fecha",
        "proceso_id",
        "cliente_id",
        "proyecto_id",
    ];
}

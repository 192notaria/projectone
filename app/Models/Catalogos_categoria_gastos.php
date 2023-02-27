<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogos_categoria_gastos extends Model
{
    use HasFactory;
    protected $fillable = [
        "nombre",
        "descripcion",
    ];
}

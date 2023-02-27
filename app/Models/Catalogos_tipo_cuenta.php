<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogos_tipo_cuenta extends Model
{
    use HasFactory;
    protected $fillable = [
        "nombre",
        "observaciones",
    ];
}

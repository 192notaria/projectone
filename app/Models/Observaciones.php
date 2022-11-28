<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observaciones extends Model
{
    use HasFactory;
    protected $fillable = [
        "titulo",
        "descripcion",
        "img_path",
        "proyecto_id"
    ];
}

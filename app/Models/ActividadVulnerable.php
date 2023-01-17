<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActividadVulnerable extends Model
{
    use HasFactory;
    protected $fillable = [
        "activo",
        "proyecto_id",
    ];
}

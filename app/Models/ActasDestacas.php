<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActasDestacas extends Model
{
    use HasFactory;
    protected $fillable = [
        "nombre",
        "proyecto_id",
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutuos extends Model
{
    use HasFactory;
    protected $fillable = [
        "cantidad",
        "forma_pago",
        "tiempo",
        "proyecto_id"
    ];
}

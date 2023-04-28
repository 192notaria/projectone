<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Egresos extends Model
{
    use HasFactory;
    protected $fillable = [
        "costo_id",
        "proyecto_id",
        "monto",
        "gestoria",
        "impuestos",
        "fecha_egreso",
        "comentarios",
        "path",
        "usuario_id",
        "status",
    ];

    public function costos(){
        return $this->belongsTo(Costos::class, "costo_id");
    }

    public function responsable(){
        return $this->belongsTo(User::class, "usuario_id");
    }
}

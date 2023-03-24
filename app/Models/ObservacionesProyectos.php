<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservacionesProyectos extends Model
{
    use HasFactory;
    protected $fillable = [
        "comentarios",
        "user_id",
        "proyecto_id",
    ];

    public function usuarios(){
        return $this->belongsTo(User::class, "user_id");
    }

    public function proyectos(){
        return $this->belongsTo(Proyectos::class, "proyecto_id");
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecibosArchivos extends Model
{
    use HasFactory;
    protected $fillable = [
        "path",
        "proyecto_id",
        "usuario_entrega_id",
        "usuario_recibe_id",
    ];

    public function proyecto(){
        return $this->belongsTo(Proyectos::class, "proyecto_id");
    }

    public function usuario_entrega(){
        return $this->belongsTo(User::class, "usuario_entrega_id");
    }

    public function usuario_recibe(){
        return $this->belongsTo(User::class, "usuario_recibe_id");
    }
}

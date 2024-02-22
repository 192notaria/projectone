<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpedientesArchivados extends Model
{
    use HasFactory;
    protected $fillable = [
        "proyecto_id",
        "observaciones",
    ];

    public function escritura(){
        return $this->belongsTo(Proyectos::class, "proyecto_id");
    }
}

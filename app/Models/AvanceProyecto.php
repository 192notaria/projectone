<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvanceProyecto extends Model
{
    use HasFactory;
    protected $fillable = [
        "proyecto_id",
        "proceso_id",
        "subproceso_id",
        "usuario_id",
    ];

    public function proceso(){
        return $this->hasOne(ProcesosServicios::class, 'id', 'proceso_id');
    }

    public function subproceso(){
        return $this->hasOne(SubprocesosCatalogos::class, 'id', 'subproceso_id');
    }

    public function proyecto(){
        return $this->hasOne(Proyectos::class, 'id', 'proyecto_id');
    }

    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }
}

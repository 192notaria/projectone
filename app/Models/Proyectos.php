<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyectos extends Model
{
    use HasFactory;
    protected $fillable = [
        "servicio_id",
        "cliente_id",
        "usuario_id",
        "status"
    ];

    public function abogado(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function servicio(){
        return $this->belongsTo(Servicios::class, 'servicio_id');
    }

    public function cliente(){
        return $this->belongsTo(Clientes::class, 'cliente_id');
    }

    public function generalesCliente(){
        return $this->hasMany(Generales::class, 'proyecto_id');
    }

    public function getstatus(){
        return $this->hasOne(AvanceProyecto::class, 'proyecto_id', 'id')->latest();
    }

    public function avanceCount(){
        return $this->hasMany(AvanceProyecto::class, 'proyecto_id', 'id')->distinct();
    }

    public function avance(){
        return $this->hasMany(AvanceProyecto::class, 'proyecto_id', 'id');
    }

    public function porcentaje(){
        return $this->hasMany(Servicios_Procesos_Servicio::class, 'servicio_id', 'servicio_id');
    }

    public function observaciones(){
        return $this->hasMany(Observaciones::class, 'proyecto_id');
    }

    public function apoyo(){
        return $this->hasMany(ApoyoProyectos::class, 'proyecto_id');
    }
}

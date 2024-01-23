<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizaciones extends Model
{
    use HasFactory;

    public function cliente(){
        return $this->belongsTo(Clientes::class, "cliente_id");
    }

    public function acto(){
        return $this->belongsTo(Servicios::class, "acto_id");
    }

    public function costos(){
        return $this->hasMany(CostosCotizaciones::class);
    }

    public function usuario(){
        return $this->belongsTo(User::class, "usuario_id");
    }

    public function proyecto(){
        return $this->belongsTo(Proyectos::class, "proyecto_id");
    }
}

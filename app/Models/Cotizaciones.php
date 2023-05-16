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

    public function promotor(){
        return $this->belongsTo(Promotores::class, "promotor_id");
    }
}

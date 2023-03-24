<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costos extends Model
{
    use HasFactory;
    protected $fillable = [
        "concepto_id",
        "subtotal",
        "gestoria",
        "impuestos",
        "proyecto_id",
    ];

    public function concepto_pago(){
        return $this->belongsTo(Catalogos_conceptos_pago::class, 'concepto_id');
    }

    public function pagados(){
        return $this->hasMany(CostosCobrados::class, 'costo_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostosCotizaciones extends Model
{
    use HasFactory;
    protected $fillable = [
        "subtotal",
        "gestoria",
        "impuesto",
        "version",
        "cotizaciones_id",
        "concepto_id",
        "observaciones",
    ];

    public function concepto(){
        return $this->belongsTo(Catalogos_conceptos_pago::class);
    }

    public function cotizacion(){
        return $this->belongsTo(Cotizaciones::class, "cotizaciones_id");
    }
}

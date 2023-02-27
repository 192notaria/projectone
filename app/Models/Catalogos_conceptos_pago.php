<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogos_conceptos_pago extends Model
{
    use HasFactory;
    protected $fillable = [
        'categoria_gasto_id',
        'descripcion',
        'precio_sugerido',
        'impuestos',
        'tipo_impuesto_id',
    ];

    public function categoria(){
        return $this->belongsTo(Catalogos_categoria_gastos::class, 'categoria_gasto_id');
    }

    public function impuesto(){
        return $this->belongsTo(CatalogosTipoImpuestos::class, 'tipo_impuesto_id');
    }
}

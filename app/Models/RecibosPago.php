<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecibosPago extends Model
{
    use HasFactory;
    protected $fillable = [
        "nombre",
        "path",
        "costo_recibo",
        "gastos_gestoria",
        "cliente_id",
        "proyecto_id",
        "subproceso_id"
    ];

    public function tipoRecibo(){
        return $this->belongsTo(SubprocesosCatalogos::class, "subproceso_id");
    }

    public function recibo_guardado($id){
        return $this->hasOne(AvanceProyecto::class, "proyecto_id", "proyecto_id")
            ->where('subproceso_id', $id)->get();
    }
}

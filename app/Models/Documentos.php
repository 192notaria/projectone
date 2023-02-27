<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{
    use HasFactory;
    protected $fillable = [
        "nombre",
        "storage",
        "cliente_id",
        "catalogo_id",
        "proyecto_id"
    ];

    public function tipoDoc(){
        return $this->belongsTo(SubprocesosCatalogos::class, "catalogo_id");
    }

    public function document_saved($id){
        return $this->hasOne(AvanceProyecto::class, "proyecto_id", "proyecto_id")
            ->where('subproceso_id', $id)->get();
    }
}

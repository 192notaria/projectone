<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subprocesos extends Model
{
    use HasFactory;
    protected $fillable = [
        "subproceso_id",
        "proceso_id"
    ];

    public function catalogosSubprocesos(){
        return $this->belongsTo(SubprocesosCatalogos::class, 'subproceso_id');
    }

    public function avance($proyecto, $proceso){
        return $this->hasOne(AvanceProyecto::class, 'subproceso_id', 'subproceso_id')
            ->where("proyecto_id", $proyecto)
            ->where("proceso_id", $proceso)->first();
    }

    public function firmaAgendada($proyecto){
        return $this->hasOne(Firmas::class, 'proceso_id', 'proceso_id')->where('proyecto_id', $proyecto)->first();
    }

    public function reciboPago($proyecto){
        // return $this->subproceso_id;
        return $this->hasOne(RecibosPago::class, 'subproceso_id', 'subproceso_id')->where('proyecto_id', $proyecto)->first();
    }

    public function validarDocumento($documento, $proyecto){
        $buscarDoc = Documentos::where("proyecto_id",$proyecto)->get();
        foreach($buscarDoc as $docdata){
            // return $docdata->tipoDoc->nombre;

            if(isset($docdata->tipoDoc->nombre) && $docdata->tipoDoc->nombre == $documento){
                return true;
            }
        }
    }
}

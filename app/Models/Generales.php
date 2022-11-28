<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generales extends Model
{
    use HasFactory;
    protected $fillable = [
        "cliente_id",
        "proyecto_id",
        "acta_nacimiento",
        "acta_matrimonio",
        "curp",
        "rfc",
        "identificacion_oficial_con_foto",
        "comprobante_domicilio",
    ];

    public function cliente(){
        return $this->belongsTo(Clientes::class, 'cliente_id');
    }
}

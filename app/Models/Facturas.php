<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facturas extends Model
{
    use HasFactory;
    protected $fillable = [
        "monto",
        "folio_factura",
        "rfc_receptor",
        "fecha",
        "origen",
        "concepto_pago_id",
        "observaciones",
        "xml",
        "pdf",
        "proyecto_id",
        "usuario_id",
    ];

    public function costos(){
        return $this->belongsTo(Costos::class, "concepto_pago_id");
    }

    public function usuario(){
        return $this->belongsTo(User::class, "usuario_id");
    }

    public function cliente(){
        return $this->belongsTo(Clientes::class, "cliente_id");
    }

    public function escritura(){
        return $this->belongsTo(Proyectos::class, "proyecto_id");
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuentas_bancarias extends Model
{
    use HasFactory;
    protected $fillable = [
        "uso_id",
        "tipo_cuenta_id",
        "banco_id",
        "titular",
        "numero_cuenta",
        "clabe_interbancaria",
        "observaciones"
    ];

    public function uso(){
        return $this->belongsTo(Catalogos_uso_de_cuentas::class, "uso_id");
    }

    public function banco(){
        return $this->belongsTo(Catalogos_bancos::class, "banco_id");
    }

    public function tipo(){
        return $this->belongsTo(Catalogos_tipo_cuenta::class, "tipo_cuenta_id");
    }
}

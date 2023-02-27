<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cobros extends Model
{
    use HasFactory;
    protected $fillabnle = [
        "fecha",
        "cliente",
        "monto",
        "metodo_pago_id",
        "factura_id",
        "cuenta_id",
        "proyecto_id",
        "usuario_id",
        "observaciones"
    ];

    public function cobrados(){
        return $this->hasMany(CostosCobrados::class, 'cobro_id');
    }

    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function cuenta(){
        return $this->belongsTo(Cuentas_bancarias::class, 'cuenta_id');
    }

    public function metodo_pago(){
        return $this->belongsTo(CatalogoMetodosPago::class, 'metodo_pago_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotejosCopias extends Model
{
    use HasFactory;
    protected $fillable = [
        "costo_copia",
        "cantidad_copias",
        "juegos",
        "cliente",
        "path_copias",
        "proyecto_id",
        "cliente_id",
        "usuario_id",
    ];

    public function cliente_data(){
        return $this->belongsTo(Clientes::class, "cliente_id");
    }

    public function usuario(){
        return $this->belongsTo(User::class, "usuario_id");
    }

    public function pago(){
        return $this->hasOne(RegistroRecibos::class, "proyecto_id", "proyecto_id");
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partes extends Model
{
    use HasFactory;

    public function cliente(){
        return $this->belongsTo(Clientes::class, "cliente_id");
    }
}

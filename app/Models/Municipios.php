<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipios extends Model
{
    use HasFactory;
    protected $table = "municipios";
    protected $fillable = [
        "nombre",
        "estado"
    ];

    public function getEstado(){
        return $this->belongsTo(Estados::class, 'estado');
    }

    public function colonia(){
        return $this->hasMany('App\Models\Colonias');
    }

    public function getCliente(){
        return $this->hasMany(Clientes::class, 'municipio_nacimiento_id');
    }

}

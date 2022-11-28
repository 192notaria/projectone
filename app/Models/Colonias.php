<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colonias extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "nombre",
        "ciudad",
        "municipio",
        "asentamiento",
        "codigo_postal"
    ];

    public function getMunicipio(){
        return $this->belongsTo(Municipios::class, 'municipio');
    }

}

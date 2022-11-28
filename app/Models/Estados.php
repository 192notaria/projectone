<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Paises;

class Estados extends Model
{
    use HasFactory;

    public function getPais(){
        return $this->belongsTo(Paises::class, 'pais');
    }

    public function municipios(){
        return $this->hasMany('App\Models\Municipios');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubprocesosCatalogos extends Model
{
    use HasFactory;
    protected $fillable = [
        "nombre"
    ];

    public function avance(){
        return $this->hasMany(AvanceProyecto::class, 'id');
    }

    public function tiposub(){
        return $this->belongsTo(CatalogosTipo::class, 'tipo_id');
    }
}

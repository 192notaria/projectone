<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DomiciliosClientes extends Model
{
    use HasFactory;
    protected $fillable = [
        "calle",
        "colonia_id",
        "numero_ext",
        "numero_int",
    ];

    public function getColonia(){
        return $this->belongsTo(Colonias::class, 'colonia_id');
    }

    public function cliente(){
        return $this->belongsTo("App\Models\Clientes");
    }


}

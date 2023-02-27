<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostosCobrados extends Model
{
    use HasFactory;
    protected $fillable = [
        "monto",
        "costo_id"
    ];

    public function costos_data(){
        return $this->belongsTo(Costos::class, 'costo_id');
    }
}

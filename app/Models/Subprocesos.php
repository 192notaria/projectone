<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subprocesos extends Model
{
    use HasFactory;
    protected $fillable = [
        "subproceso_id",
        "proceso_id"
    ];

    public function catalogosSubprocesos(){
        return $this->belongsTo(SubprocesosCatalogos::class, 'subproceso_id');
    }
}

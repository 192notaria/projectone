<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecibosArchivos extends Model
{
    use HasFactory;
    protected $fillable = [
        "path",
        "proyecto_id",
    ];

    public function proyecto(){
        return $this->belongsTo(Proyectos::class, "proyecto_id");
    }
}

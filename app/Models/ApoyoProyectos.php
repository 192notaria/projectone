<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApoyoProyectos extends Model
{
    use HasFactory;
    protected $fillable = [
        "abogado_id",
        "abogado_apoyo_id",
        "proyecto_id",
    ];

    public function abogado_apoyo(){
        return $this->belongsTo(User::class, 'abogado_apoyo_id');
    }
}

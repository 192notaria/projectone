<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Declaranot extends Model
{
    use HasFactory;

    public function escritura(){
        return $this->belongsTo(Proyectos::class, "proyecto_id");
    }

    public function usuario(){
        return $this->belongsTo(User::class, "usuario_id");
    }

    public function documentos(){
        return $this->hasMany(DocumentosDeclaranot::class, "declaracion_id");
    }

}

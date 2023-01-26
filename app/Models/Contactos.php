<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contactos extends Model
{
    use HasFactory;
    protected $fillable = [
        "usuario_id",
        "auth_usuario_id"
    ];

    public function usuario(){
        return $this->belongsTo(User::class, "usuario_id");
    }
}

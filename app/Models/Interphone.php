<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interphone extends Model
{
    use HasFactory;
    protected $fillable = [
        "from",
        "to",
        "path",
        "view",
    ];

    public function usuarioTo(){
        return $this->belongsTo(User::class, "to");
    }

    public function usuarioFrom(){
        return $this->belongsTo(User::class, "from");
    }

}

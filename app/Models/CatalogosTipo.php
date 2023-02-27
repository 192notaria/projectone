<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogosTipo extends Model
{
    use HasFactory;
    public $table = "catalogos_tipos";
    protected $fillable = [
        "nombre",
        "tipo_id",
    ];

}

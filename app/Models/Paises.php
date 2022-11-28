<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estados;

class Paises extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nombre',
    ];

    public function getEstados(){
        return $this->hasMany(Estados::class, 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comisiones extends Model
{
    use HasFactory;

    public function promotor(){
        return $this->belongsTo(Promotores::class, 'promotor_id');
    }
}

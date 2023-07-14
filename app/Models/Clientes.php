<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apaterno',
        'amaterno',
        'municipio_nacimiento_id',
        'fecha_nacimiento',
        'email',
        'telefono',
        'ocupacion',
        'estado_civil',
        'genero'
    ];

    public function getMunicipio(){
        return $this->belongsTo(Municipios::class, 'municipio_nacimiento_id');
    }

    public function domicilio(){
        return $this->hasOne(DomiciliosClientes::class, 'id');
    }

    public function getOcupacion(){
        return $this->hasOne(Ocupaciones::class, 'id', 'ocupacion');
    }

    public function documentos(){
        return $this->hasMany(DocumentosClientes::class, 'cliente_id');
    }

    public function validarData($id){
        return Clientes::where('id', $id)
            ->where(function($query){
                $query->where("apaterno","")
                    ->orWhere("amaterno", "")
                    ->orWhere("municipio_nacimiento_id", "")
                    ->orWhereNull("fecha_nacimiento")
                    ->orWhere("email", "")
                    ->orWhere("telefono", "")
                    ->orWhere("ocupacion", "")
                    ->orWhere("estado_civil", "")
                    ->orWhere("genero", "")
                    ->orWhere("curp", "")
                    ->orWhere("rfc", "")
                    ->orWhere("tipo_cliente", "");
            })
            ->first();
    }

}

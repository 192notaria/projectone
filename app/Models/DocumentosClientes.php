<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentosClientes extends Model
{
    use HasFactory;

    public function tipo_doc_data(){
        return $this->belongsTo(CatalogoDocumentosGenerales::class, "tipo_doc_id");
    }
}

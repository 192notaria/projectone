<?php

namespace Database\Seeders;

use App\Models\CatalogoDocumentos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatalogoDocumentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
            // ["nombre" => "Acta constitutiva", "tipo" => "pdf"],
            // ["nombre" => "Acta de matrimonio", "tipo" => "pdf"],
            // ["nombre" => "Acta de nacimiento", "tipo" => "pdf"],
            // ["nombre" => "RFC", "tipo" => "pdf"],
            // ["nombre" => "CURP", "tipo" => "pdf"],
            // ["nombre" => "Comprobante de domicilio", "tipo" => "pdf"],
            // ["nombre" => "Identificación oficial con fotografia", "tipo" => "pdf"],
            ["nombre" => "Certificado de libertad de gravamen", "tipo" => "pdf"],
            ["nombre" => "Constancia de no adeudo", "tipo" => "pdf"],
            ["nombre" => "Escritura antecedente", "tipo" => "pdf"],
            ["nombre" => "Pago del impuesto predial", "tipo" => "pdf"],
            ["nombre" => "Proyecto de escritura", "tipo" => "pdf"],
        ];

        foreach ($tipos as $data) {
            CatalogoDocumentos::create($data);
        }
    }
}

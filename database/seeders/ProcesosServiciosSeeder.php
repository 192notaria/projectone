<?php

namespace Database\Seeders;

use App\Models\ProcesosServicios;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcesosServiciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $procesosServicios = [
            ["id" => 1, "nombre" =>	"Entrega de documentos - Compraventa"],
            ["id" => 2, "nombre" =>	"Entrega de documentos - Dacion"],
            ["id" => 3, "nombre" =>	"Entrega de documentos - Cancelacion de hipoteca"],
            ["id" => 4, "nombre" =>	"Entrega de documentos - Testasmentos"],
            ["id" => 5, "nombre" =>	"Entrega de documentos - Sucesorios extrajudiciales Intestamentarios / Testamentarios"],
            ["id" => 6, "nombre" =>	"Entrega de documentos - Sucesorios judiciales Intestamentarios / Testamentarios"],
            ["id" => 7, "nombre" =>	"Entrega de documentos - Subdivisiones"],
            ["id" => 8, "nombre" =>	"Entrega de documentos - Actas destacadas"],
            ["id" => 9, "nombre" =>	"Entrega de documentos - Carta poder"],
            ["id" => 10, "nombre" => "Entrega de documentos - Permiso para menores"],
            ["id" => 11, "nombre" => "Entrega de documentos - Donacion en pago"],
            ["id" => 12, "nombre" => "Entrega de documentos - Divorcio"],
            ["id" => 13, "nombre" => "Entrega de documentos - Mutuos con garantia hipotecaria"],
            ["id" => 14, "nombre" => "Entrega de documentos - Acta de asamblea"],
            ["id" => 15, "nombre" => "Entrega de documentos - Actas constitutivas"],
            ["id" => 16, "nombre" => "Entrega de documentos - Poder en escritura"],
            ["id" => 17, "nombre" => "Firma"],
            ["id" => 18, "nombre" => "Certificado Catastral"],
            ["id" => 19, "nombre" => "Avaluo"],
            ["id" => 20, "nombre" => "Constancia de no adeudo"],
            ["id" => 21, "nombre" => "Traslado de dominio"],
            ["id" => 22, "nombre" => "Declaracion de impuesto"],
            ["id" => 23, "nombre" => "CFDI"],
            ["id" => 24, "nombre" => "Registro publico de la propiedad"],
            ["id" => 25, "nombre" => "Fecha de entrega"],
            ["id" => 26, "nombre" => "Aviso al RELOAT"],
            ["id" => 27, "nombre" => "Aviso de testamento"],
            ["id" => 28, "nombre" => "Certificado positivo - negativo de testamento"],
            ["id" => 29, "nombre" => "Edictos"],
            ["id" => 30, "nombre" => "Actas destacadas"],
            ["id" => 31, "nombre" => "Expediente del juzgado"],
            ["id" => 32, "nombre" => "Copia certificada (Si fue del distrito judicial)"],
            ["id" => 33, "nombre" => "Documentos"],
            ["id" => 34, "nombre" => "Solicitud de divorcio"],
            ["id" => 35, "nombre" => "Registro Civil"],
        ];
        foreach($procesosServicios as $proceos_servicio){
            ProcesosServicios::create($proceos_servicio);
        }

    }
}

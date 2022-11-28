<?php

namespace Database\Seeders;

use App\Models\SubprocesosCatalogos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubprocesosCatalogosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subprocesos = [
            ["id" => 1, "nombre" => "Acta de matrimonio (En caso de haberlo", "tipo_id" => 6],
            ["id" => 2, "nombre" => "Acta de nacimiento (En caso de hijos", "tipo_id" => 7],
            ["id" => 3, "nombre" => "Acta de nacimiento del de cujus", "tipo_id" => 6],
            ["id" => 4, "nombre" => "Acuerdo resolutorio y plano", "tipo_id" => 6],
            ["id" => 5, "nombre" => "Agendar fecha de entrega", "tipo_id" => 5],
            ["id" => 6, "nombre" => "Agendar fecha de firma del proyecto", "tipo_id" => 5],
            ["id" => 7, "nombre" => "Carta de instruccion / cancelacion", "tipo_id" => 6],
            ["id" => 8, "nombre" => "Certificacion de defuncion", "tipo_id" => 6],
            ["id" => 9, "nombre" => "Certificacion de libertad de gravamen",	"tipo_id" => 6],
            ["id" => 10, "nombre" => "Certificado positivo / negativo de testamento", "tipo_id" => 6],
            ["id" => 11, "nombre" => "Concubinato", "tipo_id" => 6],
            ["id" => 12, "nombre" => "Constancia de no adeudo", "tipo_id" => 6],
            ["id" => 13, "nombre" => "Desgloses Catastrales", "tipo_id" => 6],
            ["id" => 14, "nombre" => "Escritura publica", "tipo_id" => 6],
            ["id" => 15, "nombre" => "Expediente del juzgado o copia certificada", "tipo_id" => 6],
            ["id" => 16, "nombre" => "Fecha de solicitud de avaluo", "tipo_id" => 8],
            ["id" => 17, "nombre" => "Generales de los herederos", "tipo_id" => 2],
            ["id" => 18, "nombre" => "Generales de los testigos", "tipo_id" => 1],
            ["id" => 19, "nombre" => "Generales del comprador", "tipo_id" => 4],
            ["id" => 20, "nombre" => "Generales del testador", "tipo_id" => 4],
            ["id" => 21, "nombre" => "Generales del vendedor", "tipo_id" => 4],
            ["id" => 22, "nombre" => "Ingresar datos de autorizacion de catastro", "tipo_id" => 3],
            ["id" => 23, "nombre" => "Inscripcion de la subdivision", "tipo_id" => 6],
            ["id" => 24, "nombre" => "Pago del impuesto predial", "tipo_id" => 6],
            ["id" => 25, "nombre" => "Importar recibo de pago Certificado Catastral", "tipo_id" => 6],
            ["id" => 27, "nombre" => "Importar recibo de pago Catastro", "tipo_id" => 6],
            ["id" => 28, "nombre" => "Importar recibo de pago Constancia de no adeudo", "tipo_id" => 6],
            ["id" => 29, "nombre" => "Importar recibo de pago Declaracion de impuesto", "tipo_id" => 6],
            ["id" => 30, "nombre" => "Importar recibo de pago CFDI",	"tipo_id" => 6],
            ["id" => 31, "nombre" => "Importar recibo de pago Registro publico de la propiedad",	"tipo_id" => 6],
            ["id" => 32, "nombre" => "Importar recibo de pago de ayuntamiento",	"tipo_id" => 6],
            ["id" => 33, "nombre" => "Importar recibo de pago de catastro", "tipo_id" => 6],
            ["id" => 34, "nombre" => "Importar recibo de pago del ayuntamiento",	"tipo_id" => 6],
            ["id" => 35, "nombre" => "Importar proyecto firmado", "tipo_id" => 6],
            ["id" => 36, "nombre" => "Importar Certificado Catastral", "tipo_id" => 6],
            ["id" => 37, "nombre" => "Importar Avaluo", "tipo_id" => 6],
            ["id" => 38, "nombre" => "Importar Constancia de no adeudo",	"tipo_id" => 6],
            ["id" => 39, "nombre" => "Importar Declaracion de impuesto",	"tipo_id" => 6],
            ["id" => 40, "nombre" => "Importar CFDI", "tipo_id" => 6],
            ["id" => 41, "nombre" => "Importar Registro publico de la propiedad",	"tipo_id" => 6],
            ["id" => 42, "nombre" => "Importar Recibo de entrega firmado",	"tipo_id" => 6],
            ["id" => 43, "nombre" => "Testamento", "tipo_id" => 6],
            ["id" => 44, "nombre" => "Generales de la persona 1", "tipo_id" => 9],
            ["id" => 45, "nombre" => "Generales de la persona 2", "tipo_id" => 9],
            ["id" => 46, "nombre" => "Acta de matrimonio", "tipo_id" => 6],
            ["id" => 47, "nombre" => "Importar solicitud de divorcio", "tipo_id" => 6],
            ["id" => 48, "nombre" => "Importar recibo de pago del registro civil", "tipo_id" => 6],
            ["id" => 49, "nombre" => "Importar documento del registro civil", "tipo_id" => 6],
            ["id" => 50, "nombre" => "Generales del donador", "tipo_id" => NULL],
            ["id" => 51, "nombre" => "Generales del donatario", "tipo_id" => NULL],
        ];

        foreach ($subprocesos as $subproceso) {
            SubprocesosCatalogos::create($subproceso);
        }
    }
}

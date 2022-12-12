<?php

namespace Database\Seeders;

use App\Models\CatalogosTipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatalogosTipos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
            ['id' => 1, 'nombre' => '3 Datos generales'],
            ['id' => 2, 'nombre' => '4 o mas datos generales'],
            ['id' => 3, 'nombre' => 'Autorizacion Catastro'],
            ['id' => 4, 'nombre' => 'Datos generales con documentos'],
            ['id' => 5, 'nombre' => 'Fecha y hora'],
            ['id' => 6, 'nombre' => 'Documento (PDF)'],
            ['id' => 7, 'nombre' => 'Subir documento de herederos hijos'],
            ['id' => 8, 'nombre' => 'Fecha y hora de solicitud'],
            ['id' => 9, 'nombre' => 'Datos generales'],
            ['id' => 10, 'nombre' => 'Recibo de pago'],
        ];

        foreach ($tipos as $key) {
            CatalogosTipo::create($key);
        }
    }
}

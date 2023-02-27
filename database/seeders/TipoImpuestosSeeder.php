<?php

namespace Database\Seeders;

use App\Models\CatalogosTipoImpuestos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoImpuestosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
            ["nombre" => "Ninguno"],
            ["nombre" => "Actos juridicos"],
            ["nombre" => "Cedular"],
            ["nombre" => "Derechos de registro"],
            ["nombre" => "ISR Federal"],
            ["nombre" => "ISR Estado"],
            ["nombre" => "ISR Adquisición"],
            ["nombre" => "IVA"],
            ["nombre" => "Traslacion de dominio"]
        ];

        foreach ($tipos as $key) {
            CatalogosTipoImpuestos::create($key);
        }
    }
}

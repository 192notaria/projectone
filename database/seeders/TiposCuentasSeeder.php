<?php

namespace Database\Seeders;

use App\Models\Catalogos_tipo_cuenta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TiposCuentasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
            ["nombre" => "Sin uso", "observaciones" => ""],
            ["nombre" => "Honorarios", "observaciones" => ""],
            ["nombre" => "Gastos a cargo del vendedor / comprador", "observaciones" => ""],
        ];

        foreach($tipos as $tipo){
            Catalogos_tipo_cuenta::create($tipo);
        }
    }
}

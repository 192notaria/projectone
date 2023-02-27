<?php

namespace Database\Seeders;

use App\Models\Catalogos_uso_de_cuentas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsoCuentasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usos = [
            ["nombre" => "Ingresos", "observaciones" => ""],
            ["nombre" => "Egresos", "observaciones" => ""],
            ["nombre" => "Ambos", "observaciones" => ""],
        ];

        foreach ($usos as $uso) {
            Catalogos_uso_de_cuentas::create($uso);
        }
    }
}

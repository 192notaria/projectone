<?php

namespace Database\Seeders;

use App\Models\Cuentas_bancarias;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PhpParser\Node\Stmt\Foreach_;

class CuentasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cuentas = [
            [
                "uso_id" => 3,
                "tipo_cuenta_id" => 1,
                "banco_id" => 1,
                "titular" => "CARLOS JIMENEZ AVALOS",
                "numero_cuenta" => "773208999",
                "clabe_interbancaria" => "123874612806434123",
                "observaciones" => "",
            ]
        ];

        foreach ($cuentas as $cuenta) {
            Cuentas_bancarias::create($cuenta);
        }
    }
}

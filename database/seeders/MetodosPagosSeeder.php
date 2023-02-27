<?php

namespace Database\Seeders;

use App\Models\CatalogoMetodosPago;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MetodosPagosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $metodosPago = [
            ["nombre" => "Cheque"],
            ["nombre" => "Deposito de municipio"],
            ["nombre" => "Efectivo"],
            ["nombre" => "Tarjeta de crédito"],
            ["nombre" => "Tarjeta de débito"],
            ["nombre" => "Transferencia"],
        ];
        foreach ($metodosPago as $key => $value) {
            CatalogoMetodosPago::create($value);
        }
    }
}

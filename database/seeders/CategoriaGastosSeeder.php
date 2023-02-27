<?php

namespace Database\Seeders;

use App\Models\Catalogos_categoria_gastos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaGastosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias = [
            ["nombre" => "Gastos a cargo del comprador"],
            ["nombre" => "Gastos a cargo del vendedor"],
            ["nombre" => "Gastos Notariales"],
        ];

        foreach ($categorias as $value) {
            Catalogos_categoria_gastos::create($value);
        }
    }
}

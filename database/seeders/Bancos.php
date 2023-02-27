<?php

namespace Database\Seeders;

use App\Models\Catalogos_bancos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Bancos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bancos = [
            ['nombre' => "BBVA", 'observaciones' => ''],
            ['nombre' => "Banjercito", 'observaciones' => ''],
            ['nombre' => "Bancoppel", 'observaciones' => ''],
            ['nombre' => "Scotiabank", 'observaciones' => ''],
            ['nombre' => "HSB", 'observaciones' => ''],
            ['nombre' => "Banorte", 'observaciones' => ''],
        ];

        foreach ($bancos as $key) {
            Catalogos_bancos::create($key);
        }
    }
}

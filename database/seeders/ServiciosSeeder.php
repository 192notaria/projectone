<?php

namespace Database\Seeders;

use App\Models\Servicios;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $servicios = [
            ["nombre" => "Carta poder", 'tiempo_firma' => 40],
            ["nombre" => "Compraventas", 'tiempo_firma' => 40],
            ["nombre" => "Donaciones", 'tiempo_firma' => 40],
            ["nombre" => "Sociedades", 'tiempo_firma' => 40],
            ["nombre" => "Mutuos con interes", 'tiempo_firma' => 40],
            ["nombre" => "Mutuos con garantia hipotecaria", 'tiempo_firma' => 40],
            ["nombre" => "Sucesorios extrajudiciales - Intestamentarios", 'tiempo_firma' => 40],
            ["nombre" => "Sucesorios judiciales - Testamentarios", 'tiempo_firma' => 40],
            ["nombre" => "Sucesorios extrajudiciales - Intestamentarios", 'tiempo_firma' => 40],
            ["nombre" => "Sucesorios judiciales - Testamentarios", 'tiempo_firma' => 40],
            ["nombre" => "Testamentos universal y especifico", 'tiempo_firma' => 40],
            ["nombre" => "Poderes en escritura publica", 'tiempo_firma' => 40],
            ["nombre" => "Permisos para salir del pais", 'tiempo_firma' => 40],
            ["nombre" => "Cancelacion de hipoteca", 'tiempo_firma' => 40],
            ["nombre" => "Divorcio", 'tiempo_firma' => 40],
            ["nombre" => "Donaciones en pago", 'tiempo_firma' => 40],
            ["nombre" => "Subdivisiones", 'tiempo_firma' => 40],
            ["nombre" => "Acta destacada - Extravio de factura", 'tiempo_firma' => 40],
            ["nombre" => "Acta destacada - Manifestacion de nombres", 'tiempo_firma' => 40],
            ["nombre" => "Acta de asamblea", 'tiempo_firma' => 40],
        ];

        foreach ($servicios as $servicio) {
            Servicios::create($servicio);
        }
    }
}

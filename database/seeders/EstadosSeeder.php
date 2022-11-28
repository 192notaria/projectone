<?php

namespace Database\Seeders;

use App\Models\Estados;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estados = [
            ["id" => 1, "nombre" => "Aguascalientes", "pais" => 1],
            ["id" => 2, "nombre" => "Baja California", "pais" => 1],
            ["id" => 3, "nombre" => "Baja California Sur", "pais" => 1],
            ["id" => 4, "nombre" => "Campeche", "pais" => 1],
            ["id" => 5, "nombre" => "Chiapas", "pais" => 1],
            ["id" => 6, "nombre" => "Chihuahua", "pais" => 1],
            ["id" => 7, "nombre" => "Coahuila", "pais" => 1],
            ["id" => 8, "nombre" => "Colima", "pais" => 1],
            ["id" => 9, "nombre" => "Ciudad de México", "pais" => 1],
            ["id" => 10, "nombre" => "Durango", "pais" => 1],
            ["id" => 11, "nombre" => "Estado de México", "pais" => 1],
            ["id" => 12, "nombre" => "Guanajuato", "pais" => 1],
            ["id" => 13, "nombre" => "Guerrero", "pais" => 1],
            ["id" => 14, "nombre" => "Hidalgo", "pais" => 1],
            ["id" => 15, "nombre" => "Jalisco", "pais" => 1],
            ["id" => 16, "nombre" => "Michoacán", "pais" => 1],
            ["id" => 17, "nombre" => "Morelos", "pais" => 1],
            ["id" => 18, "nombre" => "Nayarit", "pais" => 1],
            ["id" => 19, "nombre" => "Nuevo León", "pais" => 1],
            ["id" => 20, "nombre" => "Oaxaca", "pais" => 1],
            ["id" => 21, "nombre" => "Puebla", "pais" => 1],
            ["id" => 22, "nombre" => "Querétaro", "pais" => 1],
            ["id" => 23, "nombre" => "Quintana Roo", "pais" => 1],
            ["id" => 24, "nombre" => "San Luis Potosí", "pais" => 1],
            ["id" => 25, "nombre" => "Sinaloa", "pais" => 1],
            ["id" => 26, "nombre" => "Sonora", "pais" => 1],
            ["id" => 27, "nombre" => "Tabasco", "pais" => 1],
            ["id" => 28, "nombre" => "Tamaulipas", "pais" => 1],
            ["id" => 29, "nombre" => "Tlaxcala", "pais" => 1],
            ["id" => 30, "nombre" => "Veracruz", "pais" => 1],
            ["id" => 31, "nombre" => "Yucatán", "pais" => 1],
            ["id" => 32, "nombre" => "Zacatecas", "pais" => 1],
        ];

        foreach($estados as $estado){
            Estados::create($estado);
        }
    }
}

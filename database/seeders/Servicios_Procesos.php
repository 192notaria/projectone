<?php

namespace Database\Seeders;

use App\Models\Servicios_Procesos_Servicio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Servicios_Procesos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $servicios_procesos = [
            ["id" => 1, "servicio_id" => 2, "proceso_servicio_id" => 1],
            ["id" => 2, "servicio_id" => 2, "proceso_servicio_id" => 17],
            ["id" => 3, "servicio_id" => 2, "proceso_servicio_id" => 18],
            ["id" => 4, "servicio_id" => 2, "proceso_servicio_id" => 19],
            ["id" => 5, "servicio_id" => 2, "proceso_servicio_id" => 21],
            ["id" => 6, "servicio_id" => 2, "proceso_servicio_id" => 20],
            ["id" => 7, "servicio_id" => 2, "proceso_servicio_id" => 22],
            ["id" => 8, "servicio_id" => 2, "proceso_servicio_id" => 23],
            ["id" => 9, "servicio_id" => 2, "proceso_servicio_id" => 24],
            ["id" => 10, "servicio_id" => 2, "proceso_servicio_id" => 25],
            ["id" => 11, "servicio_id" => 15, "proceso_servicio_id" => 12],
            ["id" => 12, "servicio_id" => 15, "proceso_servicio_id" => 34],
            ["id" => 13, "servicio_id" => 15, "proceso_servicio_id" => 17],
            ["id" => 14, "servicio_id" => 15, "proceso_servicio_id" => 25],
            ["id" => 15, "servicio_id" => 3, "proceso_servicio_id" => 2],
            ["id" => 16, "servicio_id" => 3, "proceso_servicio_id" => 17],
            ["id" => 17, "servicio_id" => 3, "proceso_servicio_id" => 18],
            ["id" => 18, "servicio_id" => 3, "proceso_servicio_id" => 19],
            ["id" => 19, "servicio_id" => 3, "proceso_servicio_id" => 21],
            ["id" => 20, "servicio_id" => 3, "proceso_servicio_id" => 20],
            ["id" => 21, "servicio_id" => 3, "proceso_servicio_id" => 24],
            ["id" => 22, "servicio_id" => 3, "proceso_servicio_id" => 25],
            ["id" => 23, "servicio_id" => 14, "proceso_servicio_id" => 3],
            ["id" => 24, "servicio_id" => 14, "proceso_servicio_id" => 17],
            ["id" => 25, "servicio_id" => 14, "proceso_servicio_id" => 24],
            ["id" => 26, "servicio_id" => 14, "proceso_servicio_id" => 25],
        ];

        foreach($servicios_procesos as $servicio_proceso){
            Servicios_Procesos_Servicio::create($servicio_proceso);
        }
    }
}

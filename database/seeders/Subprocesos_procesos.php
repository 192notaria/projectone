<?php

namespace Database\Seeders;

use App\Models\Subprocesos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Subprocesos_procesos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subprocesos_procesos = [
            ["subproceso_id" => 19, "proceso_id" => 1],
            ["subproceso_id" => 21, "proceso_id" => 1],
            ["subproceso_id" => 9, "proceso_id" => 1],
            ["subproceso_id" => 12, "proceso_id" => 1],
            ["subproceso_id" => 14, "proceso_id" => 1],
            ["subproceso_id" => 24, "proceso_id" => 1],
            ["subproceso_id" => 6, "proceso_id" => 17],
            ["subproceso_id" => 35, "proceso_id" => 17],
            ["subproceso_id" => 25, "proceso_id" => 18],
            ["subproceso_id" => 36, "proceso_id" => 18],
            ["subproceso_id" => 16, "proceso_id" => 19],
            ["subproceso_id" => 37, "proceso_id" => 19],
            ["subproceso_id" => 33, "proceso_id" => 21],
            ["subproceso_id" => 22, "proceso_id" => 21],
            ["subproceso_id" => 34, "proceso_id" => 21],
            ["subproceso_id" => 38, "proceso_id" => 20],
            ["subproceso_id" => 38, "proceso_id" => 20],
            ["subproceso_id" => 29, "proceso_id" => 22],
            ["subproceso_id" => 39, "proceso_id" => 22],
            ["subproceso_id" => 30, "proceso_id" => 23],
            ["subproceso_id" => 40, "proceso_id" => 23],
            ["subproceso_id" => 31, "proceso_id" => 24],
            ["subproceso_id" => 41, "proceso_id" => 24],
            ["subproceso_id" => 5, "proceso_id" => 25],
            ["subproceso_id" => 42, "proceso_id" => 25],
            ["subproceso_id" => 44, "proceso_id" => 12],
            ["subproceso_id" => 45, "proceso_id" => 12],
            ["subproceso_id" => 46, "proceso_id" => 12],
            ["subproceso_id" => 48, "proceso_id" => 35],
            ["subproceso_id" => 49, "proceso_id" => 35],
            ["subproceso_id" => 50, "proceso_id" => 2],
            ["subproceso_id" => 51, "proceso_id" => 2],
            ["subproceso_id" => 9, "proceso_id" => 2],
            ["subproceso_id" => 12, "proceso_id" => 2],
            ["subproceso_id" => 14, "proceso_id" => 2],
            ["subproceso_id" => 24, "proceso_id" => 2],
            ["subproceso_id" => 14, "proceso_id" => 3],
            ["subproceso_id" => 7, "proceso_id" => 3],
            ["subproceso_id" => 47, "proceso_id" => 34]
        ];

        foreach ($subprocesos_procesos as $subproceso_proceso) {
            Subprocesos::create($subproceso_proceso);
        }
    }
}

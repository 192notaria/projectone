<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SederPermisionsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permisos = [
            // Roles
            'ver-rol',
            'crear-rol',
            'editar-rol',
            'borrar-rol',

            // Usuarios
            'ver-usuarios',
            'crear-usuarios',
            'editar-usuarios',
            'borrar-usuarios',

            // Clientes
            'ver-clientes',
            'crear-clientes',
            'editar-clientes',
            'borrar-clientes',

            // Proyectos
            'ver-proyectos',
            'crear-proyectos',
            'editar-proyectos',
            'borrar-proyectos',

            // Paises
            'ver-paises',
            'crear-paises',
            'editar-paises',
            'borrar-paises',

            // Estados
            'ver-estados',
            'crear-estados',
            'editar-estados',
            'borrar-estados',

            // Municipios
            'ver-municipios',
            'crear-municipios',
            'editar-municipios',
            'borrar-municipios',

            // Municipios
            'ver-colonias',
            'crear-colonias',
            'editar-colonias',
            'borrar-colonias',

            // Servicios
            'ver-servicios',
            'crear-servicios',
            'editar-servicios',
            'borrar-servicios',

            // Procesos
            'ver-procesos',
            'crear-procesos',
            'editar-procesos',
            'borrar-procesos',

            // SubProcesos
            'ver-subprocesos',
            'crear-subprocesos',
            'editar-subprocesos',
            'borrar-subprocesos',

            //Domicilios Clientes
            'ver-domiciliosClientes',
            'crear-domiciliosClientes',
            'editar-domiciliosClientes',
            'borrar-domiciliosClientes',

            "ver-avanzarProyecto",
            "ver-lineatiempoProyecto",
            "ver-plantillas-proyecto",
            "ver-estado-proyecto",
            "ban-usuario",

            "agregar-proceso",
            "remover-proceso",
            "agregar-subproceso",
            "remover-subproceso",

            "ver_apoyo_proyecto",
            "agregar_apoyo_proyecto",
            "remover_apoyo_proyecto",

            "ver_observaciones-proyecto",
            "agregar_observaciones-proyecto",
            "remover_observaciones-proyecto",
        ];

        # code...
        foreach ($permisos as $permiso) {
            Permission::create(['name' => $permiso]);
        }
    }
}

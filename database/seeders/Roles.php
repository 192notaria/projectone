<?php

namespace Database\Seeders;

use App\Models\RolesModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ["id" => "1", "name" => "ADMINISTRADOR", "guard_name" => "web"],
            ["id" => "2", "name" => "ABOGADO", "guard_name" => "web"],
            ["id" => "3", "name" => "ABOGADO DE APOYO", "guard_name" => "web"],
            ["id" => "4", "name" => "CONTADOR", "guard_name" => "web"],
            ["id" => "5", "name" => "RECEPCIONISTA", "guard_name" => "web"],
            // ["name" => "RECEPCIONISTA 2", "guard_name" => "web"],
        ];

        foreach ($roles as $role) {
            RolesModel::create($role);
        }
    }
}

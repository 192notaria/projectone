<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Admin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            "id" => 1,
            "name" => "admin",
            "apaterno" => "admin",
            "amaterno" => "admin",
            "genero" => "ADMIN",
            "telefono" => "1234567890",
            "fecha_nacimiento" => date('Y-m-d H:i:s', time()),
            "ocupacion" => 44,
            "user_image" => "v3/src/assets/img/g-8.png",
            "email" => "admin@admin.com",
            "email_verified_at" => null,
            "password" => Hash::make("root"),
            "remember_token" => null,
            "created_at" => date('Y-m-d H:i:s', time()),
            "updated_at" => date('Y-m-d H:i:s', time()),
        ]);
        $user->assignRole("ADMINISTRADOR");
    }
}

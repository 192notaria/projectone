<?php

namespace Database\Seeders;

use App\Models\Ocupaciones;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OcupacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profesiones_oficios = [
            ['nombre' => 'Carpintero', 'tipo' => 'Oficio'],
            ['nombre' => 'Lechero', 'tipo' => 'Oficio'],
            ['nombre' => 'Frutero', 'tipo' => 'Oficio'],
            ['nombre' => 'Cerrajero', 'tipo' => 'Oficio'],
            ['nombre' => 'Cocinero', 'tipo' => 'Oficio'],
            ['nombre' => 'Deshollinador', 'tipo' => 'Oficio'],
            ['nombre' => 'Mecánico', 'tipo' => 'Oficio'],
            ['nombre' => 'Lavandero', 'tipo' => 'Oficio'],
            ['nombre' => 'Artesano', 'tipo' => 'Oficio'],
            ['nombre' => 'Pescador', 'tipo' => 'Oficio'],
            ['nombre' => 'Escultor', 'tipo' => 'Oficio'],
            ['nombre' => 'Tornero', 'tipo' => 'Oficio'],
            ['nombre' => 'Albañil', 'tipo' => 'Oficio'],
            ['nombre' => 'Editor', 'tipo' => 'Oficio'],
            ['nombre' => 'Barrendero', 'tipo' => 'Oficio'],
            ['nombre' => 'Fontanero o plomero', 'tipo' => 'Oficio'],
            ['nombre' => 'Obrero', 'tipo' => 'Oficio'],
            ['nombre' => 'Panadero', 'tipo' => 'Oficio'],
            ['nombre' => 'Carpintero	', 'tipo' => 'Oficio'],
            ['nombre' => 'Locutor', 'tipo' => 'Oficio'],
            ['nombre' => 'Barbero', 'tipo' => 'Oficio'],
            ['nombre' => 'Soldador', 'tipo' => 'Oficio'],
            ['nombre' => 'Escritor', 'tipo' => 'Oficio'],
            ['nombre' => 'Leñador', 'tipo' => 'Oficio'],
            ['nombre' => 'Pintor', 'tipo' => 'Oficio'],
            ['nombre' => 'Vendedor', 'tipo' => 'Oficio'],
            ['nombre' => 'Peletero', 'tipo' => 'Oficio'],
            ['nombre' => 'Sastre', 'tipo' => 'Oficio'],
            ['nombre' => 'Repartidor', 'tipo' => 'Oficio'],
            ['nombre' => 'Impresor', 'tipo' => 'Oficio'],
            ['nombre' => 'Pastor ganadero	', 'tipo' => 'Oficio'],
            ['nombre' => 'Cajero', 'tipo' => 'Oficio'],
            ['nombre' => 'Policía', 'tipo' => 'Oficio'],
            ['nombre' => 'Agricultor', 'tipo' => 'Oficio'],
            ['nombre' => 'Vigilante', 'tipo' => 'Oficio'],
            ['nombre' => 'Exterminador', 'tipo' => 'Oficio'],
            ['nombre' => 'Carnicero	', 'tipo' => 'Oficio'],
            ['nombre' => 'Animador', 'tipo' => 'Oficio'],
            ['nombre' => 'Peluquero', 'tipo' => 'Oficio'],
            ['nombre' => 'Abogado', 'tipo' => 'Profesión'],
            ['nombre' => 'Médico', 'tipo' => 'Profesió'],
            ['nombre' => 'cirujano', 'tipo' => 'Profesión'],
            ['nombre' => 'Paleontólogo', 'tipo' => 'Profesión'],
            ['nombre' => 'Ingeniero', 'tipo' => 'Profesión'],
            ['nombre' => 'Historiador', 'tipo' => 'Profesión'],
            ['nombre' => 'Geógrafo', 'tipo' => 'Profesión'],
            ['nombre' => 'Biólogo', 'tipo' => 'Profesión'],
            ['nombre' => 'Filólogo', 'tipo' => 'Profesión'],
            ['nombre' => 'Psicólogo', 'tipo' => 'Profesión'],
            ['nombre' => 'Matemático', 'tipo' => 'Profesión'],
            ['nombre' => 'Arquitecto', 'tipo' => 'Profesión'],
            ['nombre' => 'Computista', 'tipo' => 'Profesión'],
            ['nombre' => 'Profesor', 'tipo' => 'Profesión'],
            ['nombre' => 'Periodista', 'tipo' => 'Profesión'],
            ['nombre' => 'Botánico', 'tipo' => 'Profesión'],
            ['nombre' => 'Físico', 'tipo' => 'Profesión'],
            ['nombre' => 'Sociólogo', 'tipo' => 'Profesión'],
            ['nombre' => 'Farmacólogo', 'tipo' => 'Profesión'],
            ['nombre' => 'Químico	', 'tipo' => 'Profesión'],
            ['nombre' => 'Politólogo', 'tipo' => 'Profesión'],
            ['nombre' => 'Enfermero', 'tipo' => 'Profesión'],
            ['nombre' => 'Electricista', 'tipo' => 'Profesión'],
            ['nombre' => 'Bibliotecólogo', 'tipo' => 'Profesión'],
            ['nombre' => 'Paramédico', 'tipo' => 'Profesión'],
            ['nombre' => 'Técnico de sonido', 'tipo' => 'Profesión'],
            ['nombre' => 'Archivólogo', 'tipo' => 'Profesión'],
            ['nombre' => 'Músico', 'tipo' => 'Profesió'],
            ['nombre' => 'Filósofo', 'tipo' => 'Profesión'],
            ['nombre' => 'Secretaria', 'tipo' => 'Profesión'],
            ['nombre' => 'Traductor', 'tipo' => 'Profesión'],
            ['nombre' => 'Antropólogo	', 'tipo' => 'Profesión'],
            ['nombre' => 'Técnico en turismo', 'tipo' => 'Profesión'],
            ['nombre' => 'Economista', 'tipo' => 'Profesión'],
            ['nombre' => 'Administrador', 'tipo' => 'Profesión'],
            ['nombre' => 'Lingüista', 'tipo' => 'Profesión'],
            ['nombre' => 'Radiólogo', 'tipo' => 'Profesión'],
            ['nombre' => 'Contador', 'tipo' => 'Profesión'],
            ['nombre' => 'Psicoanalista', 'tipo' => 'Profesión'],
            ['nombre' => 'Ecólogo', 'tipo' => 'Profesión']
        ];

        foreach ($profesiones_oficios as $data) {
            Ocupaciones::create($data);
        }
    }
}

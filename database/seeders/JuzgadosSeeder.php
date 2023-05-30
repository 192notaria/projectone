<?php

namespace Database\Seeders;

use App\Models\CatalogoJuzgados;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JuzgadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $juzgados = [
            ["distrito" => "APATZINGÁN", "adscripcion" => "JUZGADO 1o CIVIL APATZINGÁN", "domicilio" => "AV. JOSÉ MARÍA MORELOS #166 INTERIOR 23, 24, 25, CENTRO"],
            ["distrito" => "APATZINGÁN", "adscripcion" => "JUZGADO 2o CIVIL APATZINGÁN", "domicilio" => "AVENIDA CONSTITUCIÓN DE 1814 NORTE #104, COL. LAZARO CÁRDENAS"],
            ["distrito" => "APATZINGÁN", "adscripcion" => "JUZGADO 3o CIVIL APATZINGÁN", "domicilio" => "AVE. CONSTITUCIÓN DE 1814 #2 ESQ. 5 DE FEBRERO , PLANTA BAJA, CENTRO"],
            ["distrito" => "HIDALGO", "adscripcion" => "JUZGADO 1o CIVIL HIDALGO", "domicilio" => "RAYÓN #11, PLANTA BAJA, CENTRO"],
            ["distrito" => "HIDALGO", "adscripcion" => "JUZGADO 2o CIVIL HIDALGO", "domicilio" => "CALLE RAYÓN #11, PLANTA BAJA, CENTRO"],
            ["distrito" => "JIQUILPAN", "adscripcion" => "JUZGADO CIVIL JIQUILPAN", "domicilio" => "CALLE CONSTITUCIÓN #70, CENTRO"],
            ["distrito" => "LA PIEDAD", "adscripcion" => "JUZGADO 1o CIVIL LA PIEDAD", "domicilio" => "MATAMOROS #144 INTERIOR 7, 8, 9 Y 10, CENTRO"],
            ["distrito" => "LA PIEDAD", "adscripcion" => "JUZGADO 2o CIVIL LA PIEDAD", "domicilio" => "MATAMOROS #144 INTERIOR 3, 4, 5 Y 6, CENTRO"],
            ["distrito" => "LÁZARO CÁRDENAS", "adscripcion" => "JUZGADO 1o CIVIL LÁZARO CÁRDENAS", "domicilio" => "AVENIDA MELCHOR OCAMPO #2(LOTE 2, MANZANA 1, UNIDAD 5), FRACC. LAS TRUCHAS"],
            ["distrito" => "LÁZARO CÁRDENAS", "adscripcion" => "JUZGADO 2o CIVIL LÁZARO CÁRDENAS", "domicilio" => "AVENIDA MELCHOR OCAMPO #2(LOTE 2, MANZANA 1, UNIDAD 5), FRACC. LAS TRUCHAS"],
            ["distrito" => "LÁZARO CÁRDENAS", "adscripcion" => "JUZGADO 3o CIVIL LÁZARO CÁRDENAS", "domicilio" => "AV. MELCHOR OCAMPO #2 INTERIOR 4, TERCER PISO, FRACC. LAS TRUCHAS"],
            ["distrito" => "LOS REYES", "adscripcion" => "JUZGADO 1o CIVIL LOS REYES", "domicilio" => "ALLENDE SUR #100 INTERIOR 5, 6, 7 Y 8, TERCER PISO, CENTRO"],
            ["distrito" => "LOS REYES", "adscripcion" => "JUZGADO 2o CIVIL LOS REYES", "domicilio" => "CALLE ALLENDE SUR #100, PRIMER PISO, CENTRO"],
            ["distrito" => "MARAVATÍO", "adscripcion" => "JUZGADO 1o CIVIL MARAVATÍO", "domicilio" => "FRANCISCO JAVIER MINA #144-B, CENTRO"],
            ["distrito" => "MARAVATÍO", "adscripcion" => "JUZGADO 2o CIVIL MARAVATÍO", "domicilio" => "CALLE JAVIER MINA #144-B, CENTRO"],
            ["distrito" => "PÁTZCUARO", "adscripcion" => "JUZGADO 1o CIVIL PÁTZCUARO", "domicilio" => "LIBRAMIENTO IGNACIO ZARAGOZA #S/NESQ. CALLE CIPRÉS, SEGUNDA PLANTA, CENTRO"],
            ["distrito" => "PÁTZCUARO", "adscripcion" => "JUZGADO 2o CIVIL PÁTZCUARO", "domicilio" => "LIBRAMIENTO IGNACIO ZARAGOZA #S/NESQ. CALLE CIPRÉS, SEGUNDA PLANTA, CENTRO"],
            ["distrito" => "PURUÁNDIRO", "adscripcion" => "JUZGADO CIVIL PURUÁNDIRO", "domicilio" => "CALLE LICENCIADO VERDAD #267, CENTRO"],
            ["distrito" => "SAHUAYO", "adscripcion" => "JUZGADO CIVIL SAHUAYO", "domicilio" => "JOSE SANCHEZ VILLASEÑOR #358DAMASO CARDENAS Y DAVID FRANCO RODRIGUEZ, COL. POPULAR"],
            ["distrito" => "TACÁMBARO", "adscripcion" => "JUZGADO CIVIL TACÁMBARO", "domicilio" => "IGNACIO ZARAGOZA #37, CENTRO"],
            ["distrito" => "URUAPAN", "adscripcion" => "JUZGADO 1o CIVIL URUAPAN", "domicilio" => "PASEO LÁZARO CÁRDENAS #2001, COL. LA JOYITA (COLONIA LINDA)"],
            ["distrito" => "URUAPAN", "adscripcion" => "JUZGADO 2o CIVIL URUAPAN", "domicilio" => "PASEO LÁZARO CÁRDENAS #2001, COL. LA JOYITA"],
            ["distrito" => "URUAPAN", "adscripcion" => "JUZGADO 3o CIVIL URUAPAN", "domicilio" => "PASEO LÁZARO CÁRDENAS #2001, COL. LA JOYITA (COLONIA LINDA)"],
            ["distrito" => "ZACAPU", "adscripcion" => "JUZGADO CIVIL ZACAPU", "domicilio" => "ZARAGOZA #754, CENTRO"],
            ["distrito" => "ZAMORA", "adscripcion" => "JUZGADO 1o CIVIL ZAMORA", "domicilio" => "CALLE APATZINGÁN #195ESQ. CON AV. VIRREY DE MENDOZA ORIENTE, PRIMER Y SEGUNDO PISO, COL. JARDINADAS"],
            ["distrito" => "ZAMORA", "adscripcion" => "JUZGADO 2o CIVIL ZAMORA", "domicilio" => "CALLE APATZINGÁN #195ESQ. CON AV. VIRREY DE MENDOZA ORIENTE, PRIMER Y SEGUNDO PISO, COL. JARDINADAS"],
            ["distrito" => "ZITÁCUARO", "adscripcion" => "JUZGADO CIVIL ZITÁCUARO", "domicilio" => "CALLE CUAUHTEMOC ORIENTE #11, CENTRO"],
        ];

        foreach ($juzgados as $key => $value) {
            CatalogoJuzgados::create($value);
        }
    }
}

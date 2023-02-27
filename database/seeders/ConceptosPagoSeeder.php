<?php

namespace Database\Seeders;

use App\Models\Catalogos_conceptos_pago;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConceptosPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $conceptos = [
            ['categoria_gasto_id' => 1, 'descripcion' => 'ISAI', 'precio_sugerido' => 0, 'impuestos' => 0.0, 'tipo_impuesto_id' => 1],
            ['categoria_gasto_id' => 1, 'descripcion' => 'Actos juridicos', 'precio_sugerido' => 0, 'impuestos' => 0.0, 'tipo_impuesto_id' => 1],
            ['categoria_gasto_id' => 1, 'descripcion' => 'Avisos preventivos', 'precio_sugerido' => 0, 'impuestos' => 0.0, 'tipo_impuesto_id' => 1],
            ['categoria_gasto_id' => 1, 'descripcion' => 'Cancelacion de hipoteca', 'precio_sugerido' => 0, 'impuestos' => 0.0, 'tipo_impuesto_id' => 1],
            ['categoria_gasto_id' => 1, 'descripcion' => 'Certificado', 'precio_sugerido' => 0, 'impuestos' => 0.0, 'tipo_impuesto_id' => 1],
            ['categoria_gasto_id' => 1, 'descripcion' => 'Derechos de registro', 'precio_sugerido' => 0, 'impuestos' => 0.0, 'tipo_impuesto_id' => 1],
            ['categoria_gasto_id' => 1, 'descripcion' => 'I.V.A', 'precio_sugerido' => 0, 'impuestos' => 0.0, 'tipo_impuesto_id' => 1],
            ['categoria_gasto_id' => 1, 'descripcion' => 'Recargos y actualizaciones', 'precio_sugerido' => 0, 'impuestos' => 0.0, 'tipo_impuesto_id' => 1],
            ['categoria_gasto_id' => 1, 'descripcion' => 'Trámite foráneo', 'precio_sugerido' => 0, 'impuestos' => 0.0, 'tipo_impuesto_id' => 1],
            ['categoria_gasto_id' => 1, 'descripcion' => 'I.S.R Comprador', 'precio_sugerido' => 0, 'impuestos' => 0.0, 'tipo_impuesto_id' => 1],
            ['categoria_gasto_id' => 2, 'descripcion' => 'I.S.R al Estado', 'precio_sugerido' => 0, 'impuestos' => 0.0, 'tipo_impuesto_id' => 1],
            ['categoria_gasto_id' => 2, 'descripcion' => 'I.S.R a la Federación', 'precio_sugerido' => 0, 'impuestos' => 0.0, 'tipo_impuesto_id' => 1],
            ['categoria_gasto_id' => 3, 'descripcion' => 'Plano', 'precio_sugerido' => 0, 'impuestos' => 0.0, 'tipo_impuesto_id' => 1],
            ['categoria_gasto_id' => 3, 'descripcion' => 'Avalúo', 'precio_sugerido' => 0, 'impuestos' => 0.0, 'tipo_impuesto_id' => 1],
            ['categoria_gasto_id' => 3, 'descripcion' => 'Diligencias y trámites', 'precio_sugerido' => 0, 'impuestos' => 0.0, 'tipo_impuesto_id' => 1],
            ['categoria_gasto_id' => 3, 'descripcion' => 'Publicaciones', 'precio_sugerido' => 0, 'impuestos' => 0.0, 'tipo_impuesto_id' => 1],
            ['categoria_gasto_id' => 3, 'descripcion' => 'Alta de RFC', 'precio_sugerido' => 0, 'impuestos' => 0.0, 'tipo_impuesto_id' => 1],
            ['categoria_gasto_id' => 3, 'descripcion' => 'Gastos notariales', 'precio_sugerido' => 0, 'impuestos' => 0.0, 'tipo_impuesto_id' => 1],
            ['categoria_gasto_id' => 3, 'descripcion' => 'Copias certificadas', 'precio_sugerido' => 0, 'impuestos' => 0.0, 'tipo_impuesto_id' => 1],
            ['categoria_gasto_id' => 3, 'descripcion' => 'Otros gastos', 'precio_sugerido' => 0, 'impuestos' => 0.0, 'tipo_impuesto_id' => 1],
            ['categoria_gasto_id' => 3, 'descripcion' => 'Recargos', 'precio_sugerido' => 0, 'impuestos' => 0.0, 'tipo_impuesto_id' => 1],
        ];

        foreach ($conceptos as $value) {
            Catalogos_conceptos_pago::create($value);
        }
    }
}

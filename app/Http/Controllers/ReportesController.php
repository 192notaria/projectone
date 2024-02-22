<?php

namespace App\Http\Controllers;

use App\Models\Proyectos;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportesController extends Controller
{

    public function reportes_graficas(){
        // $inicio_semana = Carbon::now()->startOfWeek()->format('y-m-d');
        // $fin_semana = Carbon::now()->endOfWeek()->format('y-m-d');
        $inicio_semana = '2024-01-29';
        $fin_semana = '2024-02-04';

        $proyectos = Proyectos::whereBetween('created_at', [$inicio_semana, $fin_semana])->get();

        $data = [
            'tittle' => 'Reporte semanal',
            'projects_data' => $proyectos
        ];

        // $pdf = \PDF::loadView('tables_views_report/reportes_semanales', $data);
        // return $pdf->download('archivo.pdf');
        return \PDF::loadView('tables_views_report/reportes_semanales', $data)
            ->stream('archivo.pdf');
    }
}

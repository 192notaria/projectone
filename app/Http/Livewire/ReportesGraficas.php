<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ReportesGraficas extends Component
{
    public function render()
    {
        return view('livewire.reportes-graficas');
    }

    public function reportes_graficas(){
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML('<h1>Styde.net</h1>');
        // return $pdf->download('mi-archivo.pdf');
        return response()->streamDownload(function () {
            $this->pdf->stream('documentname');
        }, 'documentname.pdf');
    }
}

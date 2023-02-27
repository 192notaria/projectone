<?php

namespace App\Http\Controllers;

use App\Models\Cobros;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
// use Barryvdh\DomPDF\Facade as PDF;

class UsuariosController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-usuarios|crear-usuarios|editar-usuarios|borrar-usuarios',['only'=>['index']]);
        $this->middleware('permission:crear-usuarios',['only' => ['create', 'store']]);
        $this->middleware('permission:editar-usuarios',['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-usuarios',['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administracion/usuarios');
    }

    public function generatePdf(Request $request){
        setlocale(LC_ALL, 'es_ES');
        $cobros = Cobros::find($request->id);
        if(!$cobros){
            return redirect(route('home'));
        }
        // view()->share('pdf-templates.recibos_pago', $cobros);
        // $pdf = PDF::loadView('pdf-templates.recibos_pago', ['recibos' => $cobros]);
        // return $pdf->stream();

        return view('pdf-templates.recibos_pago', compact('cobros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Guardias;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GuardiasController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-guardias|crear-guardias|editar-guardias|borrar-guardias', ['only'=>['index']]);
        $this->middleware('permission:crear-guardias',['only' => ['create', 'store']]);
        $this->middleware('permission:editar-guardias',['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-guardias',['only' => ['destroy']]);
    }

    public function index()
    {
        return view('administracion.usuarios.guardias');
    }


    public function getGuardias(){
        $now = Carbon::now();
        $guardias = Guardias::whereMonth("fecha_guardia", $now->month)->get();
        foreach($guardias as $guardia){
            if(date("l",strtotime($guardia->fecha_guardia)) == "Saturday"){
                $guardiasdata[] = [
                    "id" => $guardia->id,
                    "title" => $guardia->user->name . " " . $guardia->user->apaterno,
                    "start" => $guardia->fecha_guardia. " 10:00:00",
                    "end" => $guardia->fecha_guardia . " 12:30:00",
                    "extendedProps" => [
                        "calendar" => $guardia->solicitud_user_id ? "ChangeGuard" : (auth()->user()->id == $guardia->solicitud_user_id ? "Important" : "Work")
                    ]
                ];
            }else{
                $guardiasdata[] = [
                    "id" => $guardia->id,
                    "title" => $guardia->user->name . " " . $guardia->user->apaterno,
                    "start" => $guardia->fecha_guardia. " 15:30:00",
                    "end" => $guardia->fecha_guardia . " 17:00:00",
                    "extendedProps" => [
                        // Unparenthesized `a ? b : c ? d : e` is not supported. Use either `(a ? b : c) ? d : e` or `a ? b : (c ? d : e)`
                        "calendar" => $guardia->solicitud_user_id ? "ChangeGuard" : (auth()->user()->id == $guardia->solicitud_user_id ? "Important" : "Work")
                        // (is_front_page() ) ?  $intro_image ( :   ( ! get_header_image() )   ?   $intro_image :   get_header_image())
                    ]
                ];
            }
        }
        return $guardiasdata;
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Guardias as ModelsGuardias;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Guardias extends Component
{
    public $dias_semana;
    public $guardia_semanal = [];
    public $usuarios_array = [];
    public $usuarios_dia_anterior = [];
    public $usuarios_sabado = [];
    public $guardias = [];
    public $usuarios_db = [];
    public $fechas = [];
    public $guardias_cumplidas = [];
    public $usuarios_guardia_semanal = [];
    public $mensaje;
    public $nombre_usuario_guardia;
    public $guardia_id;
    public $fecha_cambio;
    public $dias_semanales = 0;
    public $dias_por_persona;
    public $mes_elejido;

    public $calendario = true;

    protected $listeners = [
        'modalcambiodeguardia' => 'cambiarguardia',
        'cambiodeguardia' => 'cambiodeguardia',
        'registrar_guardia_event' => 'abrir_registrar_guardia',
    ];

    public function render()
    {
        return view('livewire.guardias',[
            "usuarios" => User::orderBy("name", "ASC")->get()
        ]);
    }

    public function cambiarguardia($nombre, $id, $fecha){
        // $this->guardia_id = $id;
        // $this->fecha_cambio = date("Y-m-d", strtotime($fecha));
        $guardia = ModelsGuardias::find($id);
        $this->guardia_id = $guardia->id;
        $this->date_guardia = $guardia->fecha_guardia;
        $this->usuario_id = $guardia->user_id;

        // if($buscarguardia->user_id != auth()->user()->id){
        //     $this->mensaje = "Seguro que desea solicitar un cambio de guardia con";
        //     return $this->nombre_usuario_guardia = $nombre;
        // }

        // if($buscarguardia->user_id == auth()->user()->id && $buscarguardia->solicitud_user_id){
        //     $this->mensaje = "Seguro que desea solicitar un cambio de guardia con";
        // }

        // $this->mensaje = "No hay ninguna solicitud para cambio de guardia";
        // return $this->nombre_usuario_guardia = "";
    }

    public function cambiodeguardia(){
        $buscarguardia = ModelsGuardias::find($this->guardia_id);
        $buscarguardia->solicitud_user_id = auth()->user()->id;
        $buscarguardia->save();
        $this->dispatchBrowserEvent("solicitud-de-cambio");
        return notificarCambioGuardia($buscarguardia->user_id, auth()->user()->id, $this->fecha_cambio);
    }

    function calcular_fechas(){
        $timestamp1 = mktime(0,0,0,date("m", strtotime($this->_data_first_month_day())),date("d", strtotime($this->_data_first_month_day())),date("Y", strtotime($this->_data_first_month_day())));
        $timestamp2 = mktime(4,12,0,date("m", strtotime($this->_data_last_month_day())),date("d",strtotime($this->_data_last_month_day())),date("Y",strtotime($this->_data_last_month_day())));

        $segundos_diferencia = $timestamp1 - $timestamp2;
        $dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
        $dias_diferencia = abs($dias_diferencia);
        $dias_diferencia = floor($dias_diferencia);
        // dd(intval($dias_diferencia));
        $fecha = $this->_data_first_month_day();
        $cant_dias = intval($dias_diferencia) + 1;

        for ($i=0; $i < $cant_dias; $i++) {
            if(date("l",strtotime($fecha)) != "Saturday" && date("l",strtotime($fecha)) != "Sunday"){
                $this->dias_semanales++;
            }
            array_push($this->fechas,$fecha);
            $fecha = date("Y-m-d", strtotime($fecha."+ 1 days"));
        }
    }

    function _data_first_month_day() {
        $this->validate([
                "mes_elejido" => "required"
            ],
            ["mes_elejido.required" => "Es necesario seleccionar un mes para generar la guardia"]
        );
        $month = date('m');
        $year = date('Y');
        // dd($year);
        return date('Y-m-d', mktime(0,0,0, date('m', strtotime($this->mes_elejido)), 1, date('Y', strtotime($this->mes_elejido))));
    }

    function _data_last_month_day() {
        $this->validate([
                "mes_elejido" => "required"
            ],
            ["mes_elejido.required" => "Es necesario seleccionar un mes para generar la guardia"]
        );
        // $month = date('m');
        // $year = date('Y');
        $day = date("d", mktime(0,0,0,  date('m', strtotime($this->mes_elejido)) + 1, 0, date('Y', strtotime($this->mes_elejido))));
        return date('Y-m-d', mktime(0,0,0,  date('m', strtotime($this->mes_elejido)), $day, date('Y', strtotime($this->mes_elejido))));
    }


    public function limpiarguardia(){
        $this->guardia_semanal = [];
        $this->usuarios_array = [];
        $this->usuarios_dia_anterior = [];
        $this->usuarios_sabado = [];
        $this->guardias = [];
        $this->usuarios_db = [];
        $this->fechas = [];
        $this->guardias_cumplidas = [];
        $this->usuarios_guardia_semanal = [];
    }

    public $usuariosaleaotrios = [];
    public function generarGuardia(){
        $this->limpiarguardia();
        $this->calcular_fechas();

        $usuariosTotales = User::inRandomOrder()->whereHas("roles", function($data){
            $data->where('name', "ABOGADO")
                ->orWhere('name', "ABOGADO DE APOYO")
                ->orWhere('name', "CONTADOR")
                ->orWhere('name', "ABOGADO ADMINISTRADOR");
        })->get();

        $usuarios_db_semanal = User::inRandomOrder()->where('tipo_guardia', 'semanal')->whereHas("roles", function($data){
            $data->where('name', "ABOGADO")
                ->orWhere('name', "ABOGADO DE APOYO")
                ->orWhere('name', "CONTADOR")
                ->orWhere('name', "ABOGADO ADMINISTRADOR");
        })->get();

        $usuarios_semanal = count($usuarios_db_semanal);
        $equipos = round(count($usuarios_db_semanal) / 2);
        $team = 1;
        $fila_usuario = 0;

        $usuarios_fin_semana = count($usuariosTotales);
        $equipos_fin_semana = round(count($usuariosTotales) / 2);
        $fila_usuario_fin = 0;
        $team_fin = 1;

        foreach($this->fechas as $fecha){
            if(Carbon::create($fecha)->isoFormat('dddd') != 'domingo' && Carbon::create($fecha)->isoFormat('dddd') != 'sábado'){
                if($fila_usuario >= $usuarios_semanal){
                    $fila_usuario = 0;
                }

                if($team > $equipos){
                    $team = 1;
                    $this->usuariosaleaotrios = [];
                    $usuarios_db_semanal = User::inRandomOrder()->where('tipo_guardia', 'semanal')->whereHas("roles", function($data){
                        $data->where('name', "ABOGADO")
                            ->orWhere('name', "ABOGADO DE APOYO")
                            ->orWhere('name', "CONTADOR")
                            ->orWhere('name', "ABOGADO ADMINISTRADOR");
                    })->get();
                }

                if(isset($fechadata) && $team == 1){
                    if($usuarios_db_semanal[0]['id'] == $fechadata[count($fechadata) - 1]['guardia1']['id']){
                        return $this->generarGuardia();
                    }
                    if($usuarios_db_semanal[0]['id'] == $fechadata[count($fechadata) - 2]['guardia1']['id']){
                        return $this->generarGuardia();
                    }
                    if($usuarios_db_semanal[1]['id'] == $fechadata[count($fechadata) - 1]['guardia1']['id']){
                        return $this->generarGuardia();
                    }
                    if($usuarios_db_semanal[1]['id'] == $fechadata[count($fechadata) - 2]['guardia1']['id']){
                        return $this->generarGuardia();
                    }
                    if($usuarios_db_semanal[0]['id'] == $fechadata[count($fechadata) - 1]['guardia2']['id']){
                        return $this->generarGuardia();
                    }
                    if($usuarios_db_semanal[0]['id'] == $fechadata[count($fechadata) - 2]['guardia2']['id']){
                        return $this->generarGuardia();
                    }
                    if($usuarios_db_semanal[1]['id'] == $fechadata[count($fechadata) - 1]['guardia2']['id']){
                        return $this->generarGuardia();
                    }
                    if($usuarios_db_semanal[1]['id'] == $fechadata[count($fechadata) - 2]['guardia2']['id']){
                        return $this->generarGuardia();
                    }
                }

                $fechadata[] = [
                    "fecha" => $fecha,
                    "team" => $team,
                    "dia" => Carbon::create($fecha)->isoFormat('dddd D \d\e MMMM'),
                    "guardia1" => [
                        "id" => $usuarios_db_semanal[$fila_usuario]['id'],
                        "nombre" => $usuarios_db_semanal[$fila_usuario]['name'] . " " . $usuarios_db_semanal[$fila_usuario]['apaterno'],
                    ],
                    "guardia2" => [
                        "id" => isset($usuarios_db_semanal[$fila_usuario + 1]['id']) ? $usuarios_db_semanal[$fila_usuario + 1]['id'] : $usuarios_db_semanal[0]['id'],
                        "nombre" => isset($usuarios_db_semanal[$fila_usuario + 1]['name']) ? $usuarios_db_semanal[$fila_usuario + 1]['name'] . " " . $usuarios_db_semanal[$fila_usuario + 1]['apaterno'] : $usuarios_db_semanal[0]['name'] . " " . $usuarios_db_semanal[0]['apaterno'],
                    ],
                ];

                $fila_usuario = $fila_usuario + 2;
                $team = $team + 1;
            }
        }

        foreach($this->fechas as $fecha){
            if(Carbon::create($fecha)->isoFormat('dddd') == 'sábado'){
                if($fila_usuario_fin >= $usuarios_fin_semana){
                    $fila_usuario_fin = 0;
                }

                if($team_fin > $equipos_fin_semana){
                    $team_fin = 1;
                }

                $usuarioAleatorio = $this->usuario_aleatorio($usuarios_db_semanal, $fila_usuario + 1);

                if($usuarioAleatorio == $usuariosTotales[$fila_usuario_fin]['id']){
                    return $this->generarGuardia();
                }

                $fechadata[] = [
                    "fecha" => $fecha,
                    "team" => $team_fin,
                    "dia" => Carbon::create($fecha)->isoFormat('dddd D \d\e MMMM'),
                    "guardia1" => [
                        "id" => $usuariosTotales[$fila_usuario_fin]['id'],
                        "nombre" => $usuariosTotales[$fila_usuario_fin]['name'] . " " . $usuariosTotales[$fila_usuario_fin]['apaterno'],
                    ],
                    "guardia2" => [
                        "id" => isset($usuariosTotales[$fila_usuario_fin + 1]['id']) ? $usuariosTotales[$fila_usuario_fin + 1]['id'] : $usuariosTotales[$usuarioAleatorio]['id'],
                        "nombre" => isset($usuariosTotales[$fila_usuario_fin + 1]['name']) ? $usuariosTotales[$fila_usuario_fin + 1]['name'] . " " . $usuariosTotales[$fila_usuario_fin + 1]['apaterno'] : $usuariosTotales[$usuarioAleatorio]['name'] . " " . $usuariosTotales[$usuarioAleatorio]['apaterno'],
                    ],
                ];

                $fila_usuario_fin = $fila_usuario_fin + 2;
                $team_fin = $team_fin + 1;
            }
        }

        $this->guardia_semanal = $fechadata;
        // dd(array_count_values($this->guardias_cumplidas),$this->dias_semanales);
        // dd(count($this->guardias_cumplidas));
        // dd($fechadata);
    }

    public function usuario_aleatorio($array, $usuario){
        if(rand(count($array), 1) == 0) {
            if(rand(count($array), 1) == $usuario){
                return rand(count($array), 1) + 1;
            }
            return rand(count($array), 1);
        }

        if(rand(count($array), 1) == $usuario){
            return rand(count($array), 1) - 1;
        }

        return rand(count($array), 1) - 1;
    }

    public function guardarGuardia(){
        $now = date('m', strtotime($this->mes_elejido));
        $guardias = ModelsGuardias::whereMonth("fecha_guardia", $now)->first();

        if($guardias){
            return $this->dispatchBrowserEvent("existe-guardia","Ya existe una guarda registrada para este mes");
        }

        foreach($this->guardia_semanal as $guardia){
            $guardia1 = new ModelsGuardias;
            $guardia1->fecha_guardia = $guardia['fecha'];
            $guardia1->user_id = $guardia['guardia1']['id'];
            $guardia1->save();

            $guardia2 = new ModelsGuardias;
            $guardia2->fecha_guardia = $guardia['fecha'];
            $guardia2->user_id = $guardia['guardia2']['id'];
            $guardia2->save();
        }

        return $this->dispatchBrowserEvent("cerrar-modal-guardias","Se ha registrado la guardia con exito");
    }

    public $date_guardia;
    public $usuario_id = '';

    public function abrir_registrar_guardia($date){
        $date = date("Y-m-d", strtotime($date['start']));
        $this->date_guardia = $date;
        return $this->dispatchBrowserEvent("abrir-modal-new-guardia");
    }

    public function registrar_guardia(){
        $this->validate([
            "date_guardia" => "required",
            "usuario_id" => "required",
        ],[
            "date_guardia.required" => "Es necesario la fecha de la guardia",
            "usuario_id.required" => "Es necesario el usuario que dara la guardia",
        ]);
        $this->calendario = false;

        $guardia = new ModelsGuardias;
        $guardia->fecha_guardia = $this->date_guardia;
        $guardia->user_id = $this->usuario_id;
        $guardia->solicitud_user_id = null;
        $guardia->save();
        $this->calendario = true;

        $this->date_guardia = '';
        $this->usuario_id = '';
        // return redirect(request()->header('Referer'));
        return $this->dispatchBrowserEvent("cerrar-modal-new-guardia", "Guardia registrada");
    }

}

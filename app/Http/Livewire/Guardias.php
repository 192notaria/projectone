<?php

namespace App\Http\Livewire;

use App\Models\Guardias as ModelsGuardias;
use App\Models\User;
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
    public $mensaje;
    public $nombre_usuario_guardia;

    protected $listeners = [
        'modalcambiodeguardia' => 'cambiarguardia',
        'cambiodeguardia' => 'cambiarguardia',
    ];

    public function render()
    {
        return view('livewire.guardias');
    }

    public function cambiarguardia($nombre, $id){
        $buscarguardia = ModelsGuardias::find($id);
        if($buscarguardia->user_id != auth()->user()->id){
            $this->mensaje = "Seguro que desea solicitar un cambio de guardia con";
            return $this->nombre_usuario_guardia = $nombre;
        }
        $this->mensaje = "No hay ninguna solicitud para cambio de guardia";
        return $this->nombre_usuario_guardia = "";
    }

    public function cambiodeguardia($id){
        $buscarguardia = ModelsGuardias::find($id);
        $buscarguardia->solicitud_user_id = auth()->user()->id;
        $buscarguardia->save();
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
            array_push($this->fechas,$fecha);
            $fecha = date("Y-m-d", strtotime($fecha."+ 1 days"));
        }
    }

    function _data_first_month_day() {
        $month = date('m');
        $year = date('Y');
        return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
    }

    function _data_last_month_day() {
        $month = date('m');
        $year = date('Y');
        $day = date("d", mktime(0,0,0, $month+1, 0, $year));
        return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
    }


    public function limpiarguardia(){
        $this->guardia_semanal = [];
        $this->usuarios_array = [];
        $this->usuarios_dia_anterior = [];
        $this->usuarios_sabado = [];
        $this->guardias = [];
        $this->usuarios_db = [];
        $this->fechas = [];
    }

    public function generarGuardia(){
        $this->limpiarguardia();
        $this->calcular_fechas();
        $this->usuarios_db = User::whereHas("roles", function($data){
            $data->where('name', "ABOGADO")
                ->orWhere('name', "ABOGADO DE APOYO")
                ->orWhere('name', "CONTADOR")
                ->orWhere('name', "ABOGADO ADMINISTRADOR");
        })->get();

        foreach($this->fechas as $fecha){
            if(date("l",strtotime($fecha)) != "Sunday"){
                foreach($this->usuarios_db as $user){
                    if(date("l",strtotime($fecha)) == "Saturday"){
                        if(!in_array($user->name . " " . $user->apaterno . " " . $user->amaterno, $this->usuarios_sabado)){
                            $usuariodata = [
                                "id" => $user->id,
                                "nombre" => $user->name . " " . $user->apaterno . " " . $user->amaterno,
                            ];
                            array_push($this->usuarios_array, $usuariodata);
                        }
                    }else{
                        if(!in_array($user->name . " " . $user->apaterno . " " . $user->amaterno, $this->usuarios_dia_anterior) && $user->tipo_guardia == "semanal"){
                            $usuariodata = [
                                "id" => $user->id,
                                "nombre" => $user->name . " " . $user->apaterno . " " . $user->amaterno,
                            ];
                            array_push($this->usuarios_array, $usuariodata);
                        }
                    }
                }
                if(count($this->usuarios_array) > 1){
                    $data = array_rand($this->usuarios_array, 2);
                    if($this->usuarios_array[$data[0]]['nombre'] == "NATALIA ROSALES MENDOZA" && $this->usuarios_array[$data[1]]['nombre'] == "EUNICE RICO PANIAGUA" ||
                    $this->usuarios_array[$data[1]]['nombre'] == "NATALIA ROSALES MENDOZA" && $this->usuarios_array[$data[0]]['nombre'] == "EUNICE RICO PANIAGUA"){
                        $data = array_rand($this->usuarios_array, 2);
                    }

                    $guardia_data = [
                        "usuarios" => [
                            "primero" => $this->usuarios_array[$data[0]],
                            "segundo" => $this->usuarios_array[$data[1]],
                        ],
                        "fecha" => $fecha,
                        "dia" => date("l",strtotime($fecha))
                    ];

                    array_push($this->guardia_semanal, $guardia_data);
                    $this->usuarios_dia_anterior = [$this->usuarios_array[$data[0]]['nombre'], $this->usuarios_array[$data[1]]['nombre']];
                    if(date("l", strtotime($fecha)) == "Saturday"){
                        array_push($this->usuarios_sabado, $this->usuarios_array[$data[0]]['nombre']);
                        array_push($this->usuarios_sabado, $this->usuarios_array[$data[1]]['nombre']);
                    }
                    $this->usuarios_array = [];
                }
            }else{
                $this->usuarios_dia_anterior = [];
            }
        }
        // $this->guardia_semanal = $guardias;
    }

    public function guardarGuardia(){

        foreach($this->guardia_semanal as $guardia){
            foreach($guardia['usuarios'] as $usuariosguardia){
                $nuevaguardia = new ModelsGuardias;
                $nuevaguardia->fecha_guardia = $guardia['fecha'];
                $nuevaguardia->user_id = $usuariosguardia['id'];
                $nuevaguardia->save();
            }
        }
    }
}

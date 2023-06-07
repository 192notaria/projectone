<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyectos extends Model
{
    use HasFactory;
    protected $fillable = [
        "servicio_id",
        "cliente_id",
        "usuario_id",
        "status",
        "numero_escritura",
        "volumen",
    ];

    public function abogado(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function asistentes(){
        return $this->hasMany(ApoyoProyectos::class, 'proyecto_id');
    }

    public function servicio(){
        return $this->belongsTo(Servicios::class, 'servicio_id');
    }

    public function activiadVulnerable(){
        return $this->hasOne(ActividadVulnerable::class, 'proyecto_id');
    }

    public function cliente(){
        return $this->belongsTo(Clientes::class, 'cliente_id');
    }

    public function generalesCliente(){
        return $this->hasMany(Generales::class, 'proyecto_id');
    }

    public function getstatus(){
        return $this->hasOne(AvanceProyecto::class, 'proyecto_id', 'id')->latest();
    }

    public function avanceCount(){
        return $this->hasMany(AvanceProyecto::class, 'proyecto_id', 'id');
    }

    public function avance(){
        return $this->hasMany(AvanceProyecto::class, 'proyecto_id', 'id');
    }

    public function porcentaje(){
        return $this->hasMany(Servicios_Procesos_Servicio::class, 'servicio_id', 'servicio_id');
    }

    public function get_observaciones(){
        return $this->hasMany(Observaciones::class, 'proyecto_id');
    }

    public function apoyo(){
        return $this->hasMany(ApoyoProyectos::class, 'proyecto_id')->where("abogado_apoyo_id", auth()->user()->id);
    }

    public function costos_proyecto(){
        return $this->hasMany(Costos::class, 'proyecto_id');
    }

    public function comisiones_proyecto(){
        return $this->hasMany(Comisiones::class, 'proyecto_id');
    }

    public function pagos_recibidos(){
        return $this->hasMany(Cobros::class, 'proyecto_id');
    }

    public function egresos_data(){
        return $this->hasMany(Egresos::class, 'proyecto_id');
    }

    public function facturas(){
        return $this->hasMany(Facturas::class, 'proyecto_id');
    }

    public function bitacora(){
        return $this->hasMany(AvanceProyecto::class, 'proyecto_id');
    }

    public function observaciones_data(){
        return $this->hasMany(ObservacionesProyectos::class, 'proyecto_id');
    }

    public function documentos(){
        return $this->hasMany(Documentos::class, 'proyecto_id');
    }

    public function comisiones(){
        return $this->hasMany(Comisiones::class, 'proyecto_id');
    }

    public function partes(){
        return $this->hasMany(Partes::class, 'proyecto_id');
    }

    public function declaraciones(){
        return $this->hasMany(Declaranot::class, 'proyecto_id');
    }

    public function costo_total($id){
        $total = 0;
        $costos =  Costos::where("proyecto_id", $id)->get();
        foreach ($costos as $key => $value) {
            $subtotal = $value->subtotal;
            $gestoria = $value->gestoria;
            $impuesto = $value->subtotal * $value->impuestos / 100;
            $total = $total + $subtotal + $gestoria + $impuesto;
        }
        return $total;
    }

    public function costo_total_cotizacion($id){
        $total = 0;
        $costos =  CotizacionProyecto::where("proyecto_id", $id)->get();
        foreach ($costos as $key => $value) {
            $subtotal = $value->subtotal;
            $gestoria = $value->gestoria;
            $impuesto = $value->subtotal * $value->impuestos / 100;
            $total = $total + $subtotal + $gestoria + $impuesto;
        }
        return $total;
    }

    public function pagos_recibidos_total($id){
        $total = 0;
        $costos =  Cobros::where("proyecto_id", $id)->get();
        foreach ($costos as $key => $value) {
            $monto = $value->monto;
            $total = $total + $monto;
        }
        return $total;
    }

    public function egresos_registrados($id){
        $total = 0;
        $costos =  Egresos::where("proyecto_id", $id)->get();
        foreach ($costos as $key => $value) {
            $monto = $value->monto;
            $gestoria = $value->gestoria;
            $impuestos = $value->impuestos;
            $total = $total + $monto + $gestoria + $impuestos;
        }
        return $total;
    }

    public function comisiones_registradas($id){
        $total = 0;
        $costos =  Comisiones::where("proyecto_id", $id)->get();
        foreach ($costos as $key => $value) {
            $monto = $value->cantidad;
            $total = $total + $monto;
        }
        return $total;
    }

    public function omitido($proyecto_id, $proceso_id, $subproceso_id){
        $omitido = AvanceProyecto::where("proyecto_id", $proyecto_id)
            ->where("proceso_id", $proceso_id)
            ->where("subproceso_id", $subproceso_id)
            // ->where("omitido", 1)
            ->first();
        return $omitido;
    }

    public function costos_cotizacion(){
        return $this->hasMany(CotizacionProyecto::class, "proyecto_id");
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Colonias as ModelsColonias;
use App\Models\Municipios;
use Livewire\Component;
use Livewire\WithPagination;


class Colonias extends Component
{
    use WithPagination;
    public $buscarColonia;
    public $buscarMunicipio;
    public $cantidadColonias = 10;
    public $modal = false;
    public $modalborrar = false;

    public $colonia_id, $nombre_colonia, $cp;
    public $municipio_id, $municipio_nombre, $asentamiento, $ciudad_localidad;
    public $buscar_asentamiento, $ciudad_o_localidad, $codigo_postal;

    public function asignarCp($codigo){
        $this->codigo_postal = $codigo;
        $this->cp = "";
    }

    public function asignarAsentamiento($asentamiento){
        $this->asentamiento = $asentamiento;
        $this->buscar_asentamiento = "";
    }

    public function asignarCiudad($ciudad){
        // dd($ciudad);
        $this->ciudad_o_localidad = $ciudad;
        $this->ciudad_localidad = "";
    }

    public function asignarMunicipio($id){
        $buscarMunicipio = Municipios::find($id);
        $this->municipio_nombre = $buscarMunicipio->nombre;
        $this->municipio_id = $buscarMunicipio->id;
        $this->buscarMunicipio = "";
    }

    public function updatingBuscarColonia(){
        $this->resetPage();
    }

    public function updatingCantidadColonias(){
        $this->resetPage();
    }

    public function openBorrarColonia($id){
        $colonia = ModelsColonias::find($id);
        $this->colonia_id = $colonia->id;
        $this->modalborrar = true;
    }

    public function closeBorrarColonia(){
        $this->colonia_id = "";
        $this->modalborrar = false;
    }

    public function openModal($id){
        $this->colonia_id = $id;
        $this->modal = true;

        if($id != ""){
            $colonia = ModelsColonias::find($id);
            $this->nombre_colonia = $colonia->nombre;
            $this->codigo_postal = $colonia->codigo_postal;
            $this->municipio_id = $colonia->municipio;
            $this->municipio_nombre = $colonia->getMunicipio->nombre;
            $this->ciudad_o_localidad = $colonia->ciudad;
            $this->asentamiento = $colonia->asentamiento;
        }
    }

    public function closeModal(){
        $this->modal = false;
        $this->municipio_id = "";
        $this->municipio_nombre = "";
        $this->asentamiento = "";
        $this->ciudad_localidad = "";
        $this->ciudad_o_localidad = "";
        $this->codigo_postal = "";
        $this->colonia_id = "";
        $this->nombre_colonia = "";
    }

    public function borrarColonia(){
        ModelsColonias::find($this->colonia_id)->delete();
        $this->closeBorrarColonia();
    }

    public function saveColonia(){
        $this->validate([
            "nombre_colonia" => "required|min:3",
            "codigo_postal" => "required|min:3",
            "municipio_id" => "required|min:3",
            "ciudad_o_localidad" => "required|min:3",
            "asentamiento" => "required|min:3",
        ]);

        if($this->colonia_id == ""){
            $newcolonia = new ModelsColonias();
            $newcolonia->nombre = $this->nombre_colonia;
            $newcolonia->ciudad = $this->ciudad_o_localidad;
            $newcolonia->municipio = $this->municipio_id;
            $newcolonia->asentamiento = $this->asentamiento;
            $newcolonia->codigo_postal = $this->codigo_postal;
            $newcolonia->save();
            return $this->closeModal();
        }

        $colonia = ModelsColonias::find($this->colonia_id);
        $colonia->nombre = $this->nombre_colonia;
        $colonia->ciudad = $this->ciudad_o_localidad;
        $colonia->municipio = $this->municipio_id;
        $colonia->asentamiento = $this->asentamiento;
        $colonia->codigo_postal = $this->codigo_postal;
        $colonia->save();
        return $this->closeModal();

    }

    public function render()
    {
        return view('livewire.colonias',
            [
                'coloniasData' => ModelsColonias::orderBy('nombre','ASC')
                    ->where('nombre', 'LIKE', '%' . $this->buscarColonia . '%')
                    ->orWhere('codigo_postal', 'LIKE', '%' . $this->buscarColonia . '%')
                    ->orWhere('ciudad', 'LIKE', '%' . $this->buscarColonia . '%')
                    ->orWhere('asentamiento', 'LIKE', '%' . $this->buscarColonia . '%')
                    ->paginate($this->cantidadColonias),
                'ciudades' => $this->ciudad_localidad == "" ? [] : ModelsColonias::select('ciudad')
                    ->where('ciudad', 'LIKE', '%' . $this->ciudad_localidad . '%')
                    ->groupBy('ciudad')
                    ->orderby('ciudad', 'ASC')
                    ->take(10)
                    ->get(),
                'asentamientos' => $this->buscar_asentamiento == "" ? [] : ModelsColonias::select('asentamiento')
                    ->where('asentamiento', 'LIKE', '%' . $this->buscar_asentamiento . '%')
                    ->orderby('asentamiento', 'ASC')
                    ->groupBy('asentamiento')
                    ->take(20)
                    ->get(),
                'cps' => $this->cp == "" ? [] : ModelsColonias::select('codigo_postal')
                    ->where('codigo_postal', 'LIKE', '%' . $this->cp . '%')
                    ->orderby('codigo_postal', 'ASC')
                    ->groupBy('codigo_postal')
                    ->take(20)
                    ->get(),
                'municipios' => $this->buscarMunicipio == "" ? [] : Municipios::orderBy('nombre', 'ASC')
                    ->where('nombre', 'LIKE', '%' . $this->buscarMunicipio . '%')
                    ->get(),
            ]
        );
    }
}

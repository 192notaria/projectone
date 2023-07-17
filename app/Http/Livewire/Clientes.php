<?php

namespace App\Http\Livewire;

use App\Models\CatalogoDocumentosGenerales;
use App\Models\Clientes as ModelClientes;
use App\Models\Colonias;
use App\Models\DocumentosClientes;
use App\Models\DomiciliosClientes;
use App\Models\Municipios;
use App\Models\Ocupaciones;
use App\Models\Proyectos;
use App\Models\Servicios;
use App\Models\SubprocesosCatalogos;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Clientes extends Component
{
    use WithPagination, WithFileUploads;

    public $cliente_institucion = false;
    public $search;
    public $buscarMunicipio = "";
    public $id_cliente,
        $nombre,
        $apaterno,
        $amaterno,
        $municipio_nacimiento_id,
        $fecha_nacimiento,
        $email,
        $telefono,
        $ocupacion = "",
        $estado_civil = "",
        $curp,
        $rfc,
        $genero = "";
    public $admin_unico;

    public $modal = false;
    public $cantidadClientes = 5;

    public $idDomicilio, $calle, $colonia_id, $codigo_postal, $numero_ext, $numero_int;
    public $colonias = [];
    public $estados = [];
    public $municipios = [];
    public $paises = [];
    public $modalDomicilios = false;
    public $tipoDomiclio = "Agregar domiclio";

    public $modalBorrarCliente = false;
    public $modalNuevoProyecto = false;

    public $tipo_cliente = "";
    public $razon_social;

    public $proyectos_escrituras = [];
    public function render(){
        return view('livewire.clientes', [
            // "clientes" => ModelClientes::where(function($query){
            //         foreach (explode(" ", $this->search) as $key => $value) {
            //             $query->orWhere('nombre', 'LIKE', '%' . $value . '%')
            //                 ->orWhere('apaterno', 'LIKE', '%' . $value . '%')
            //                 ->orWhere('amaterno', 'LIKE', '%' . $value . '%');
            //         }
            //     })->paginate($this->cantidadClientes),
            "clientes" => ModelClientes::where(DB::raw("CONCAT(nombre, ' ', apaterno, ' ', amaterno)"), "LIKE", "%" . $this->search . "%")
                ->orWhere(function($query){
                    $query->where("telefono", "LIKE", "%" . $this->search . "%")
                        ->orWhere("fecha_nacimiento", "LIKE", "%" . $this->search . "%")
                        ->orWhere("estado_civil", "LIKE", "%" . $this->search . "%")
                        ->orWhere("genero", "LIKE", "%" . $this->search . "%")
                        ->orWhere("curp", "LIKE", "%" . $this->search . "%")
                        ->orWhere("rfc", "LIKE", "%" . $this->search . "%")
                        ->orWhere("email", "LIKE", "%" . $this->search . "%");
                })
                ->paginate($this->cantidadClientes),
            "municipiosData" => $this->buscarMunicipio == "" ? [] : Municipios::where('nombre', 'LIKE', $this->buscarMunicipio . '%')->get(),
            "ocupaciones" => Ocupaciones::orderBy("nombre", "ASC")->get(),
            // "servicios" => Servicios::orderBy("nombre", "ASC")->get(),
            "abogados" => $this->buscarAbogado == "" ? [] : User::where('name', 'LIKE', '%' . $this->buscarAbogado . '%')
                ->whereHas("roles", function($data){
                    $data->where('name', "ABOGADO");
                })->get(),
            "cliente_activo" => $this->id_cliente ? ModelClientes::find($this->id_cliente) : "",
            "catalogo_documentos_generales" => CatalogoDocumentosGenerales::orderBy("nombre")->get(),
            "municipios_data" => Municipios::orderBy("nombre", "ASC")->get()
        ]);
    }

    public function closeModalBorrarCliente(){
        $this->modalBorrarCliente = false;
    }

    public function updatingCantidadClientes(){
        $this->resetPage();
    }

    public function updatingSearch(){
        $this->resetPage();
    }

    protected function rules(){
        if($this->tipo_cliente == "Persona Fisica"){
            return [
                'nombre' => 'required|min:3',
                'apaterno' => 'required|min:3',
                'amaterno' => $this->amaterno != '' ? 'min:3' : '',
                'municipio_nacimiento_id' => '',
                'fecha_nacimiento' => '',
                'email' => $this->email != "" ? 'email' : "",
                'telefono' => $this->telefono != "" ? 'min:10' : "",
                'tipo_cliente' => 'required',
            ];
        }

        return [
            'email' => $this->email != "" ? 'email' : "",
            'telefono' => $this->telefono != "" ? 'min:10' : "",
            'tipo_cliente' => 'required',
            'razon_social' => 'required',
        ];
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function openModal(){
        $this->modal = true;
        $this->clearInputs();
    }

    public function closeModal(){
        $this->modal = false;
        $this->clearInputs();
    }

    public function clearInputs(){
        $this->nombre = "";
        $this->apaterno = "";
        $this->amaterno = "";
        $this->curp = "";
        $this->rfc = "";
        $this->fecha_nacimiento = "";
        $this->buscarMunicipio = "";
        $this->email = "";
        $this->telefono = "";
        $this->ocupacion = "";
        $this->estado_civil = "";
        $this->genero = "";
        $this->id_cliente = "";
        $this->tipo_cliente = "";
        $this->razon_social = "";
        $this->admin_unico = "";
    }

    public function selectMunicipio($id){
        $municipio = Municipios::find($id);
        $this->buscarMunicipio = $municipio->nombre . ", " . $municipio->getEstado->nombre . ", " . $municipio->getEstado->getPais->nombre;
        $this->municipio_nacimiento_id = $municipio->id;
    }

    public function editarCliente($id){
        // $this->openModal();
        $cliente = ModelClientes::find($id);
        $this->id_cliente = $id;
        $municipio = Municipios::find($cliente->municipio_nacimiento_id);
        $this->buscarMunicipio = isset($municipio->nombre) ? $municipio->nombre . ", " . $municipio->getEstado->nombre . ", " . $municipio->getEstado->getPais->nombre : "";

        $this->nombre = $cliente->nombre;
        $this->apaterno = $cliente->apaterno;
        $this->amaterno = $cliente->amaterno ?? "";
        $this->fecha_nacimiento = $cliente->fecha_nacimiento ?? "";
        $this->municipio_nacimiento_id = $cliente->municipio_nacimiento_id ?? "";
        $this->email = $cliente->email ?? "";
        $this->telefono = $cliente->telefono ?? "";
        $this->ocupacion = $cliente->ocupacion ?? "";
        $this->estado_civil = $cliente->estado_civil ?? "";
        $this->curp = $cliente->curp ?? "";
        $this->genero = $cliente->genero ?? "";
        $this->rfc = $cliente->rfc ?? "";
        $this->tipo_cliente = $cliente->tipo_cliente ?? "";
        $this->razon_social = $cliente->razon_social ?? "";

        return $this->dispatchBrowserEvent("open-new-cliente-modal");
    }

    public function nuevo_cliente(){
        $this->clearInputs();
        return $this->dispatchBrowserEvent("open-new-cliente-modal");
    }

    public function borrarCliente(){
        if($this->id_cliente != ""){
            ModelClientes::find($this->id_cliente)->delete();
        }
    }

    public function SelectBorrarCliente($id){
        $this->id_cliente = $id;
        $this->modalBorrarCliente = true;
    }

    public function save(){
        $validatedData = $this->validate();

        if($this->id_cliente != ""){
            $cliente = ModelClientes::find($this->id_cliente);
            $cliente->nombre = $this->nombre;
            $cliente->apaterno = $this->apaterno;
            $cliente->amaterno = $this->amaterno;
            $cliente->municipio_nacimiento_id = $this->municipio_nacimiento_id;
            $cliente->fecha_nacimiento = $this->fecha_nacimiento;
            $cliente->email = $this->email;
            $cliente->telefono = $this->telefono;
            $cliente->ocupacion = $this->ocupacion;
            $cliente->estado_civil = $this->estado_civil;
            $cliente->genero = $this->genero;
            $cliente->curp = $this->curp;
            $cliente->rfc = $this->rfc;
            $cliente->tipo_cliente = $this->tipo_cliente;
            $cliente->razon_social = $this->razon_social;
            $cliente->admin_unico = $this->admin_unico;
            $cliente->save();
            $this->clearInputs();
            return $this->dispatchBrowserEvent('close-new-cliente-modal');
        }

        $buscarCliente = ModelClientes::where('nombre', $this->nombre)
                ->where('apaterno', $this->apaterno)
                ->where('amaterno', $this->amaterno)
                ->where('fecha_nacimiento', $this->fecha_nacimiento)
                ->get();

            if(count($buscarCliente) > 0){
                return $this->addError('existeCliente', 'Este cliente ya esta registrado');
            }

            // $validatedData['nombre'] = mb_strtoupper($validatedData['nombre']);
            // $validatedData['apaterno'] = mb_strtoupper($validatedData['apaterno']);
            // $validatedData['amaterno'] = mb_strtoupper($validatedData['amaterno']);
            // $validatedData['email'] = mb_strtolower($validatedData['email']);

            $cliente = new ModelClientes;
            $cliente->nombre = mb_strtoupper($this->nombre);
            $cliente->apaterno = mb_strtoupper($this->apaterno);
            $cliente->amaterno = mb_strtoupper($this->amaterno ?? "");
            if($this->municipio_nacimiento_id) $cliente->municipio_nacimiento_id = $this->municipio_nacimiento_id;
            if($this->fecha_nacimiento) $cliente->fecha_nacimiento = $this->fecha_nacimiento;
            $cliente->email = mb_strtolower($this->email ?? "");
            if($this->telefono) $cliente->telefono = $this->telefono;
            if($this->ocupacion) $cliente->ocupacion = $this->ocupacion;
            $cliente->estado_civil = $this->estado_civil ?? "";
            $cliente->genero = $this->genero ?? "";
            $cliente->curp = $this->curp ?? "";
            $cliente->rfc = $this->rfc ?? "";
            $cliente->tipo_cliente = $this->tipo_cliente;
            $cliente->razon_social = $this->razon_social ?? "";
            $cliente->admin_unico = $this->admin_unico ?? "";
            $cliente->save();
            $this->clearInputs();
            return $this->dispatchBrowserEvent('close-new-cliente-modal');
    }

    public function saveClienteInst(){
        $this->validate([
            'nombre' => 'required',
            'telefono' => $this->telefono != "" ? 'min:10|integer' : '',
        ]);

        if($this->id_cliente == ""){
            $cliente = new ModelClientes;
            $cliente->nombre = $this->nombre;
            $cliente->telefono = $this->telefono;
            $cliente->representante_inst = $this->cliente_institucion ?? 0;
            $cliente->save();
            return $this->dispatchBrowserEvent('cliente_registrado', "Cliente registrado como representante de alguna institucion");
        }

        $cliente = ModelClientes::find($this->id_cliente);
        $cliente->nombre = $this->nombre;
        $cliente->telefono = $this->telefono;
        $cliente->representante_inst = $this->cliente_institucion ?? 0;
        $cliente->save();

        return $this->dispatchBrowserEvent('cliente_editado', "Cliente editado");
    }

    public function editClienteInst($id){
        $cliente = ModelClientes::find($id);
        $this->id_cliente = $id;
        $this->nombre = $cliente->nombre;
        $this->telefono = $cliente->telefono;
        $this->cliente_institucion = $cliente->representante_inst;
    }

    // ===================================================================================== DOMICILIOS ============================================================

    public function openModalDomicilios($id){
        $this->modalDomicilios = true;
        $this->clearInputsDomicilios();
        $this->id_cliente = $id;
    }

    public function closeModalDomicilios(){
        $this->modalDomicilios = false;
        $this->clearInputsDomicilios();
        $this->tipoDomiclio = "Agregar Domiclio";
        $this->colonias = [];
    }

    public function clearInputsDomicilios(){
        $this->idDomicilio= '';
        $this->calle= '';
        $this->colonia_id= '';
        $this->codigo_postal= '';
        $this->numero_ext= '';
        $this->numero_int= '';
        $this->id_cliente= '';
    }

    public function buscarCodigoPostal(){
        $this->colonias = Colonias::where('codigo_postal', $this->codigo_postal)->get();
    }

    public function resetSearch(){
        $this->calle= '';
        $this->numero_ext= '';
        $this->numero_int= '';
        $this->colonia_id= '';
        $this->colonias = [];
    }

    public function guardarDomicilio(){
        $validarDomicilios = $this->validate([
            'calle' => 'required|min:3',
            'colonia_id' => 'required',
            'numero_ext' => 'required',
            'numero_int' => '',
        ]);

        if($this->idDomicilio){
            $getDomiclio = DomiciliosClientes::find($this->idDomicilio);
            $getDomiclio->calle = $validarDomicilios['calle'];
            $getDomiclio->colonia_id = $validarDomicilios['colonia_id'];
            $getDomiclio->numero_ext = $validarDomicilios['numero_ext'];
            $getDomiclio->numero_int = $validarDomicilios['numero_int'];
            $getDomiclio->save();
            return $this->closeModalDomicilios();
        }

        $domicilio = new DomiciliosClientes;
        $domicilio->calle = $this->calle;
        $domicilio->colonia_id = $this->colonia_id;
        $domicilio->numero_ext = $this->numero_ext;
        $domicilio->numero_int = $this->numero_int;
        $domicilio->cliente_id = $this->id_cliente;

        $cliente = ModelClientes::find($this->id_cliente);
        $cliente->domicilio()->save($domicilio);
        return $this->closeModalDomicilios();
    }

    public function editarDomicilio($id, $id_cliente){
        $this->openModalDomicilios($id_cliente);
        $this->id_cliente = $id_cliente;
        $domiclio = DomiciliosClientes::find($id);
        $this->colonias = Colonias::where('codigo_postal', $domiclio->getColonia->codigo_postal)->get();
        $this->codigo_postal = $domiclio->getColonia->codigo_postal;
        $this->idDomicilio = $id;
        $this->calle = $domiclio->calle;
        $this->colonia_id = $domiclio->colonia_id;
        $this->numero_ext = $domiclio->numero_ext;
        $this->numero_int = $domiclio->numero_int;
        $this->id_cliente = $domiclio->id_cliente;
        $this->tipoDomiclio = "Editar domicilio";
    }


    // ===================================================================================== Nuevo Proyecto ============================================================
    public $buscarAbogado;
    public $numero_de_escritura;
    public $volumen;
    public $id_Abogado,
        $nombreAbogado,
        $apaternoAbogado,
        $amaternoAbogado,
        $generoAbogado,
        $telefonoAbogado,
        $fecha_nacimientoAbogado,
        $avatarAbogado,
        $emailAbogado;

    public $servicio_id = "";


    public function closeModalNuevoProyecto(){
        $this->modalNuevoProyecto = false;
        $this->clearInputsAbogado();
    }

    public function openModalNuevoProyecto($id){
        $this->modalNuevoProyecto = true;
        $this->id_cliente = $id;
    }

    public function clearInputsAbogado(){
        $this->id_cliente = "";
        $this->id_Abogado = "";
        $this->nombreAbogado = "";
        $this->apaternoAbogado = "";
        $this->amaternoAbogado = "";
        $this->generoAbogado = "";
        $this->telefonoAbogado = "";
        $this->fecha_nacimientoAbogado = "";
        $this->avatarAbogado = "";
        $this->emailAbogado = "";
        $this->servicio_id = "";
    }

    public function guardarProyecto(){
        $this->validate([
            "servicio_id" => "required",
            "id_Abogado" => "required",
            "numero_de_escritura" => $this->numero_de_escritura != "" ? "unique:proyectos,numero_escritura" : "",
        ]);
        $proyecto = new Proyectos;
        $proyecto->servicio_id = $this->servicio_id;
        $proyecto->cliente_id = $this->id_cliente;
        $proyecto->usuario_id = $this->id_Abogado;
        $proyecto->status = 0;
        $proyecto->numero_escritura = $this->numero_de_escritura;
        $proyecto->volumen = $this->volumen;
        $proyecto->save();

        $this->servicio_id = "";
        $this->id_cliente = "";
        $this->id_Abogado = "";
        $this->numero_de_escritura = "";
        return $this->dispatchBrowserEvent('cerrar-modal-nuevo-proyecto-clientes', 'Proyecto de escritura iniciado');
    }

    public function asignarAbogado($abogado){
        $this->buscarAbogado = "";
        $this->id_Abogado = $abogado['id'];
        $this->nombreAbogado = $abogado['name'];
        $this->apaternoAbogado = $abogado['apaterno'];
        $this->amaternoAbogado = $abogado['amaterno'];
        $this->generoAbogado = $abogado['genero'];
        $this->telefonoAbogado = $abogado['telefono'];
        $this->fecha_nacimientoAbogado = $abogado['fecha_nacimiento'];
        $this->avatarAbogado = $abogado['user_image'];
        $this->emailAbogado = $abogado['email'];
    }

    public function nuevoProyecto($id){
        $this->id_cliente = $id;
        $cliente = ModelClientes::find($id);
        if($cliente->representante_inst){
            $this->proyectos_escrituras = Servicios::orderBy("nombre","ASC")->where("nombre","Cancelacion de hipoteca")->get();
            return $this->dispatchBrowserEvent('abrir-modal-nuevo-proyecto-clientes');
        }

        $this->proyectos_escrituras = Servicios::orderBy("nombre","ASC")->get();
        return $this->dispatchBrowserEvent('abrir-modal-nuevo-proyecto-clientes');
    }

    public function open_upload_docs($id){
        $this->id_cliente = $id;
        return $this->dispatchBrowserEvent('open-upload-general-docs');
    }

    public $vista = "table";
    public $cliente_doc;
    public $tipo_doc = '';
    public function upload_doc_view($view){
        $this->vista = $view;
    }

    public function upload_doc(){
        $this->validate([
                "tipo_doc" => "required",
                "cliente_doc" => "required",
            ],
            [
                "tipo_doc.required" => "Es necesario seleccionar el tipo de documento",
                "cliente_doc.required" => "Es necesario importar el documento",
            ]
        );

        $doc = new DocumentosClientes;

        $cliente_activo = ModelClientes::find($this->id_cliente);
        $path = "/uploads/clientes/" . str_replace(" ", "_", $cliente_activo->nombre) . "_" . str_replace(" ", "_", $cliente_activo->apaterno) . "_" . str_replace(" ", "_", $cliente_activo->amaterno) . "/documentos";
        $store = $this->cliente_doc->storeAs(mb_strtolower($path), time() . $this->cliente_doc->getClientOriginalName(), 'public');
        $doc->nombre = $this->cliente_doc->getClientOriginalName();
        $doc->tipo = $this->tipo_doc;
        $doc->path = "storage/" . $store;
        $doc->cliente_id = $this->id_cliente;
        $doc->save();

        $this->vista = "table";
        $this->cliente_doc = "";
        $this->tipo_doc = "";
        return $this->dispatchBrowserEvent("success-notify", "Documento importado con exito");
    }

    function remove_doc($id){
        DocumentosClientes::find($id)->delete();
        // return $this->dispatchBrowserEvent("close-upload-general-docs");
        return $this->dispatchBrowserEvent("success-notify", "Documento removido");
    }


    public $warning_tittle;
    public $warning_message;
    function open_warning_modal(){
        $this->warning_tittle = 'Información faltante';
        $this->warning_message = 'Es necesario ingresar la información faltante del cliente';
        return $this->dispatchBrowserEvent("abrir-modal-warning");
    }
}

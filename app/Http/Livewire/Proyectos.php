<?php

namespace App\Http\Livewire;

use App\Models\ActasDestacas;
use App\Models\ActividadVulnerable;
use App\Models\Apoderados;
use App\Models\ApoyoProyectos;
use App\Models\AutorizacionCatastro;
use App\Models\AvanceProyecto;
use App\Models\Clientes;
use App\Models\Documentos;
use App\Models\Firmas;
use App\Models\Generales;
use App\Models\Herederos;
use App\Models\InformacionDelViajeDelMenor;
use App\Models\Mutuos;
use App\Models\Observaciones;
use App\Models\Paises;
use App\Models\ProcesosServicios;
use App\Models\Proyectos as ModelsProyectos;
use App\Models\RecibosPago;
use App\Models\RegistroFirmas;
use App\Models\Servicios;
use App\Models\Subprocesos;
use App\Models\SubprocesosCatalogos;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use NumberFormatter;
use PhpOffice\PhpWord\TemplateProcessor;
use Kreait\Firebase\Contract\Database;
use Livewire\WithPagination;



class Proyectos extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $database;
    public function mount(Database $database){
        $this->database = $database;
        // $reference = $database->getReference('/MARCO PEREZ DIAZ');
        // $snapshot = $reference->getSnapshot()->numChildren();
        // dd($snapshot);
    }

    public $proyecto_id;
    public $servicio;
    public $procesos;
    public $subprocesos;
    public $procesoActual;
    public $subprocesoActual;

    public $acta_nac;
    public $acta_matrimonio;
    public $curp;
    public $rfc;
    public $identificacion_oficial;
    public $comprobante_domicilio;

    public $fechayhoraInput;

    public $documentFile;

    public $tituloModal = "";
    public $comprador;

    public $tipoGenerales;

    public $buscarCliente;
    public $buscarComprador;
    public $num_comprobante;
    public $cuenta_predial;
    public $clave_catastral;
    public $search;

    public $modalTimeLine = false;

    public $modalAvance = false;
    public $modalVendedor = false;

    public $buscarAbogado;
    public $abogado_id;

    public $cantidadProyectos = 5;
    public $cliente_id;

    public $heredero_hijo = false;
    public $nombreacta;
    public $documentsActaDestacada = [];

    public $nombreapoderados;
    public $varios_generales_data = [];

    public $generales_data;
    public $document_id;

    public function render(){
        return view('livewire.proyectos',[
            "proyectos_escrituras" => Servicios::orderBy("nombre","ASC")->get(),
            // "proyectos" => ModelsProyectos::orderBy("created_at", "ASC")->paginate($this->cantidadProyectos),
            "compradores" => $this->buscarComprador == "" ? [] : Clientes::where('nombre', 'LIKE', '%' . $this->buscarComprador . '%')
                ->orWhere('apaterno', 'LIKE', '%' . $this->buscarComprador . '%')
                ->orWhere('amaterno', 'LIKE', '%' . $this->buscarComprador . '%')
                ->get(),
            "clientes" => $this->buscarCliente == "" ? [] : Clientes::where('nombre', 'LIKE', '%' . $this->buscarCliente . '%')
                ->orWhere('apaterno', 'LIKE', '%' . $this->buscarCliente . '%')
                ->orWhere('amaterno', 'LIKE', '%' . $this->buscarCliente . '%')
                ->get(),

            "proyectos" =>
            Auth::user()->hasRole('ADMINISTRADOR') ? ModelsProyectos::orderBy("numero_escritura", "ASC")
                // ->where('usuario_id', auth()->user()->id)
                ->where('status', 0)
                ->whereHas('cliente', function($q){
                    $q->where('nombre', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('apaterno', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('amaterno', 'LIKE', '%' . $this->search . '%');
                })
                // ->orWhereHas('servicio', function($serv){
                //     $serv->where('nombre', 'LIKE', '%' . $this->search . '%');
                // })
                ->paginate($this->cantidadProyectos)
            :
                ModelsProyectos::orderBy("numero_escritura", "ASC")
                ->where('usuario_id', auth()->user()->id)
                ->where('status', 0)
                ->whereHas('cliente', function($q){
                    $q->where('nombre', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('apaterno', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('amaterno', 'LIKE', '%' . $this->search . '%');
                })
                // ->orWhereHas('servicio', function($serv){
                //     $serv->where('nombre', 'LIKE', '%' . $this->search . '%');
                // })
                ->paginate($this->cantidadProyectos),

            "servicios" => Servicios::orderBy("nombre", "ASC")->get(),
            "abogados" => $this->buscarAbogado == "" ? [] : User::where('name', 'LIKE', '%' . $this->buscarAbogado . '%')
                ->whereHas("roles", function($data){
                    $data->where('name', "ABOGADO");
                })->get(),
            "abogados_apoyo" => $this->buscarAbogado == "" ? [] : User::where('name', 'LIKE', '%' . $this->buscarAbogado . '%')
                ->whereHas("roles", function($data){
                    $data
                        ->where('name', "ABOGADO DE APOYO")
                        ->orWhere('name', "ABOGADO");
                })->get(),
            "testigos" => $this->tituloModal == "Generales de los testigos" ?
                Generales::where('tipo', 'Generales de los testigos')
                ->where('proyecto_id', $this->proyecto_id)
                ->get() : [],
            "menores" => $this->tituloModal == "Generales de los menores" ?
                Generales::where('tipo', 'Generales de los menores')
                ->where('proyecto_id', $this->proyecto_id)
                ->get() : [],
            "socios" => $this->tituloModal == "Generales de los socios" ?
                Generales::where('tipo', 'Generales de los socios')
                ->where('proyecto_id', $this->proyecto_id)
                ->get() : [],
            "apoderados" => $this->tituloModal == "Generales de los apoderados" ?
                Generales::where('tipo', 'Generales de los apoderados')
                ->where('proyecto_id', $this->proyecto_id)
                ->get() : [],
            "varios" => Generales::where('tipo', $this->tituloModal)
                ->where('proyecto_id', $this->proyecto_id)
                ->get(),
            "herederos" => Herederos::where('proyecto_id', $this->proyecto_id)->get(),
            "paises" => Paises::orderBy("nombre","ASC")->get()
        ]);
    }

    public function cancelar_id($id){
        $this->proyecto_id = $id;
    }

    public function cancelarProyecto(){
        $proyecto = ModelsProyectos::find($this->proyecto_id);
        $proyecto->status = 1;
        $proyecto->save();
        $this->proyecto_id = "";
        return $this->dispatchBrowserEvent('cancelar-proyecto', "Proyecto Cancelado");
    }

    public function updatingSearch(){
        $this->resetPage();
    }

    public $agregarApoyoModal = false;
    public $abogadoApoyo;
    public $abogado_titlular_id;
    public function asignarAbogadoApoyo($id){
        $this->abogadoApoyo = User::find($id);
        $this->buscarAbogado = "";
    }

    public function saveAgregarApoyo(){
        $newApoyo = new ApoyoProyectos;
        $newApoyo->abogado_id = $this->abogado_titlular_id;
        $newApoyo->abogado_apoyo_id = $this->abogadoApoyo->id;
        $newApoyo->proyecto_id = $this->proyecto_id;
        $newApoyo->save();
        $this->closeModalAgregarApoyo();
    }

    public function removerApoyo($id){
        ApoyoProyectos::find($id)->delete();
    }

    public function openModalAgregarApoyo($proyecto_id, $abogado_id){
        $this->proyecto_id = $proyecto_id;
        $this->abogado_titlular_id = $abogado_id;
        $this->agregarApoyoModal = true;
    }

    public function closeModalAgregarApoyo(){
        $this->agregarApoyoModal = false;
        $this->abogadoApoyo = "";
        $this->abogado_titlular_id = "";
        $this->proyecto_id = "";
    }

    public function asignarCliente($cliente){
        $generales = Generales::where("proyecto_id", $this->proyecto_id)->where("cliente_id", $cliente['id'])->first();
        if($generales){
            $this->buscarCliente = "";
            $this->tipoGenerales = "";
            return $this->addError('asignar_error', $generales->cliente->nombre . ' ' .  $generales->cliente->apaterno . ' ' . $generales->cliente->amaterno . ' YA CUENTA CON ALGUNA ASIGNACIÓN');
        }
        $buscarCliente = Clientes::find($cliente['id']);
        $this->tipoGenerales = $buscarCliente;
        return $this->buscarCliente = "";
    }

    public function asignarHeredero($cliente){
        $generales = Herederos::where("proyecto_id", $this->proyecto_id)->where("cliente_id", $cliente['id'])->first();
        if($generales){
            $this->buscarCliente = "";
            $this->tipoGenerales = "";
            return $this->addError('asignar_error', $generales->cliente->nombre . ' ' .  $generales->cliente->apaterno . ' ' . $generales->cliente->amaterno . ' YA CUENTA CON ALGUNA ASIGNACIÓN');
        }
        $buscarCliente = Clientes::find($cliente['id']);
        $this->tipoGenerales = $buscarCliente;
        return $this->buscarCliente = "";
    }

    public function closeModalTimeLine(){
        $this->modalTimeLine = false;
    }

    public $serviciosTimeline = [];
    public $avanceTimeline = [];
    public function openModalTimeLine($servicio, $id){
        $buscarservicio = Servicios::find($servicio);
        $this->serviciosTimeline = $buscarservicio->procesos;

        $buscaravance = AvanceProyecto::where('proyecto_id', $id)->get();
        $this->avanceTimeline = $buscaravance;
        $this->modalTimeLine = true;
    }

    public $inputFiles = false;
    public function openModal(){
        $this->modalAvance = true;
        $this->inputFiles = true;
    }

    public function closeModal(){
        $this->modalAvance = false;
        $this->tipoGenerales = "";
        $this->acta_nac = "";
        $this->acta_matrimonio = "";
        $this->curp = "";
        $this->rfc = "";
        $this->identificacion_oficial = "";
        $this->comprobante_domicilio = "";
        $this->documentFile = "";
        $this->tituloModal = "";
        $this->num_comprobante = "";
        $this->cuenta_predial = "";
        $this->clave_catastral = "";
        $this->inputFiles = false;
    }

    public function avanzar($proyecto, $servicio){
        $servicioActual = Servicios::find($servicio);
        $this->proyecto_id = $proyecto;
        $this->servicio = $servicioActual;
        $procesos = $servicioActual->procesos;
        $avance = true;
        $avancesubproceso = true;
        $i = 0;
        $i2 = 0;

        do {
            $proceso = $procesos[$i];
            $avanceProyecto = AvanceProyecto::where('proyecto_id', $proyecto)
                ->where('proceso_id', $proceso['id'])->get();

            if(count($avanceProyecto) > 0){
                $subprocesos = Subprocesos::where("proceso_id", $proceso['id'])->get();
                $subproceso = $subprocesos[$i2];
                $avanceSubproceso = AvanceProyecto::where('proyecto_id', $proyecto)
                    ->where('proceso_id', $proceso['id'])
                    ->where('subproceso_id', $subproceso['subproceso_id'])->get();
                if(count($avanceSubproceso) == 0){
                    $procesoActual = ProcesosServicios::find($proceso['id']);
                    $subprocesoActual = SubprocesosCatalogos::find($subproceso['subproceso_id']);
                    $this->procesoActual = $procesoActual;
                    $this->subprocesoActual = $subprocesoActual;
                    $this->tituloModal = $this->subprocesoActual->nombre;
                    $avance = false;
                    // $this->openModal();
                }else{
                    if($i2 == count($subprocesos) - 1){
                        if($i == count($procesos) -1){
                            $avance = false;
                        }else{
                            $i++;
                        }
                        $i2 = 0;
                    }else{
                        $i2++;
                    }
                }
            }else{
                $procesoActual = ProcesosServicios::find($proceso['id']);
                $subprocesos = Subprocesos::where("proceso_id", $procesoActual['id'])->get();
                $subprocesoActual = SubprocesosCatalogos::find($subprocesos[0]['subproceso_id']);
                $this->procesoActual = $procesoActual;
                $this->subprocesoActual = $subprocesoActual;
                $this->tituloModal = $this->subprocesoActual->nombre;
                $avance = false;

                // $this->openModal();
            }
        } while ($avance == true);

        if(isset($subprocesoActual->tiposub->id)){
            if($this->subprocesoActual->tiposub->id != 10 && Auth::user()->hasRole('ABOGADO DE APOYO')){
                return $this->dispatchBrowserEvent('abrir-modal-no-autorizado');
            }

            if($this->subprocesoActual->tiposub->id == 1){
                return $this->dispatchBrowserEvent('abrir-modal-generales-testigos');
            }

            if($this->subprocesoActual->tiposub->id == 2){
                return $this->dispatchBrowserEvent('abrir-modal-generales-herederos');
            }

            if($this->subprocesoActual->tiposub->id == 3){
                return $this->dispatchBrowserEvent('abrir-modal-registrar-autorizacion-catastro');
            }

            if($this->subprocesoActual->tiposub->id == 5){
                return $this->dispatchBrowserEvent('abrir-modal-agendar-firma');
            }

            if($this->subprocesoActual->tiposub->id == 4){
                return $this->dispatchBrowserEvent('abrir-modal-generales-con-docs');
            }

            if($this->subprocesoActual->tiposub->id == 6){
                return $this->dispatchBrowserEvent('abrir-modal-subir-documentos');
            }

            if($this->subprocesoActual->tiposub->id == 8){
                return $this->dispatchBrowserEvent('abrir-modal-registrar-firma');
            }

            if($this->subprocesoActual->tiposub->id == 10){
                return $this->dispatchBrowserEvent('abrir-modal-recibo-pago');
            }

            if($this->subprocesoActual->tiposub->id == 11){
                return $this->dispatchBrowserEvent('abrir-modal-registrar-nombre-acta');
            }

            if($this->subprocesoActual->tiposub->id == 12){
                return $this->dispatchBrowserEvent('abrir-modal-subir-varios-documentos');
            }

            if($this->subprocesoActual->tiposub->id == 13){
                return $this->dispatchBrowserEvent('abrir-modal-registrar-nombre-apoderados');
            }

            if($this->subprocesoActual->tiposub->id == 14){
                return $this->dispatchBrowserEvent('abrir-modal-generales-menores');
            }

            if($this->subprocesoActual->tiposub->id == 15){
                return $this->dispatchBrowserEvent('abrir-modal-registrar-informacion-viaje');
            }

            if($this->subprocesoActual->tiposub->id == 16){
                return $this->dispatchBrowserEvent('abrir-modal-registrar-mutuos');
            }

            if($this->subprocesoActual->tiposub->id == 17){
                return $this->dispatchBrowserEvent('abrir-modal-generales-socios');
            }

            if($this->subprocesoActual->tiposub->id == 18){
                return $this->dispatchBrowserEvent('abrir-modal-generales-apoderados');
            }

            if($this->subprocesoActual->tiposub->id == 19){
                return $this->dispatchBrowserEvent('abrir-modal-generales-varios');
            }
        }
    }

    public function registrarAsignacion(){
        if($this->tituloModal == "Generales del testador" ||
            $this->tituloModal == "Generales de los testigos"
        ){
            $this->validate([
                'acta_nac' => $this->acta_nac != "" ? 'mimes:pdf' : "",
                'acta_matrimonio' => $this->acta_matrimonio != "" ? 'mimes:pdf' : "",
                'curp' => $this->curp != "" ? 'mimes:pdf' : "",
                'rfc' => $this->rfc != "" ? 'mimes:pdf' : "",
                'identificacion_oficial' => 'required|mimes:pdf',
                'comprobante_domicilio' => $this->comprobante_domicilio != "" ? 'mimes:pdf' : '',
            ]);
        }else{
            $this->validate([
                'acta_nac' => $this->acta_nac != "" ? 'mimes:pdf' : "",
                'acta_matrimonio' => $this->acta_matrimonio != "" ? 'mimes:pdf' : "",
                'curp' => 'required|mimes:pdf',
                'rfc' => 'required|mimes:pdf',
                'identificacion_oficial' => 'required|mimes:pdf',
                'comprobante_domicilio' => $this->comprobante_domicilio != "" ? 'mimes:pdf' : '',
            ]);
        }

        $proyecto = ModelsProyectos::find($this->proyecto_id);

        $generales = new Generales;
        $generales->cliente_id = $this->tipoGenerales['id'];
        $generales->proyecto_id = $this->proyecto_id;
        $generales->tipo = $this->subprocesoActual->nombre;

        $route = "/uploads/proyectos/" . str_replace(" ", "_", $proyecto->cliente->nombre) . "_" . str_replace(" ", "_", $proyecto->cliente->apaterno) . "_" . str_replace(" ", "_", $proyecto->cliente->amaterno) . "/" . str_replace(" ", "_", $this->servicio['nombre']) . "_" . $this->servicio['id'] . "/" . strtoupper(str_replace(" ", "_", $this->subprocesoActual->nombre)) . "_" . str_replace(' ', '_', $this->tipoGenerales['nombre']) . "_" . str_replace(' ', '_', $this->tipoGenerales['apaterno']) . "_" . str_replace(' ', '_', $this->tipoGenerales['amaterno']);

        if($this->acta_nac != ""){
            $FileName_acta_nac = "ACTA_NACIMIENTO_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." . $this->acta_nac->extension();
            $acta_nacRoute = $this->acta_nac->storeAs(mb_strtolower($route), $FileName_acta_nac, 'public');
            $generales->acta_nacimiento = "/storage/" . $acta_nacRoute;
        }
        if($this->acta_matrimonio != ""){
            $FileName_acta_matrimonio = "ACTA_Matrimonio_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->acta_matrimonio->extension();
            $acta_matrimonioRoute = $this->acta_matrimonio->storeAs(mb_strtolower($route), $FileName_acta_matrimonio, 'public');
            $generales->acta_matrimonio = "/storage/" . $acta_matrimonioRoute;
        }
        if($this->curp != ""){
            $FileName_curp = "CURP_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->curp->extension();
            $curpRoute = $this->curp->storeAs(mb_strtolower($route), $FileName_curp, 'public');
            $generales->curp = "/storage/" . $curpRoute;
        }
        if($this->rfc != ""){
            $FileName_rfc = "RFC_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->rfc->extension();
            $rfcRoute = $this->rfc->storeAs(mb_strtolower($route), $FileName_rfc, 'public');
            $generales->rfc = "/storage/" . $rfcRoute;
        }
        if($this->identificacion_oficial != ""){
            $FileName_identificacion_oficial = "Identificacion_oficial_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->identificacion_oficial->extension();
            $identificacion_oficialRoute = $this->identificacion_oficial->storeAs(mb_strtolower($route), $FileName_identificacion_oficial, 'public');
            $generales->identificacion_oficial_con_foto = "/storage/" . $identificacion_oficialRoute;
        }
        if($this->comprobante_domicilio != ""){
            $FileName_comprobante_domicilio = "Comprobante_de_domicilio_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->comprobante_domicilio->extension();
            $comprobante_domicilioRoute = $this->comprobante_domicilio->storeAs(mb_strtolower($route), $FileName_comprobante_domicilio, 'public');
            $generales->comprobante_domicilio = "/storage/" . $comprobante_domicilioRoute;
        }

        $generales->save();

        $avanceProyecto = new AvanceProyecto;
        $avanceProyecto->proyecto_id = $this->proyecto_id;
        $avanceProyecto->proceso_id = $this->procesoActual['id'];
        $avanceProyecto->subproceso_id = $this->subprocesoActual['id'];
        $avanceProyecto->save();
        $this->closeModal();

        return $this->dispatchBrowserEvent('cerrar-modal-generales-con-docs', "Registro exitoso");
        // $this->firebase($this->proyecto_id);
    }

    public function registrarTestigo(){
        $this->validate([
            'identificacion_oficial' => 'required|mimes:pdf',
        ]);

        $proyecto = ModelsProyectos::find($this->proyecto_id);

        $generales = new Generales;
        $generales->cliente_id = $this->tipoGenerales['id'];
        $generales->proyecto_id = $this->proyecto_id;
        $generales->tipo = $this->subprocesoActual->nombre;

        $route = "/uploads/proyectos/" . str_replace(" ", "_", $proyecto->cliente->nombre) . "_" . str_replace(" ", "_", $proyecto->cliente->apaterno) . "_" . str_replace(" ", "_", $proyecto->cliente->amaterno) . "/" . str_replace(" ", "_", $this->servicio['nombre']) . "_" . $this->servicio['id'] . "/" . strtoupper(str_replace(" ", "_", $this->subprocesoActual->nombre)) . "_" . str_replace(' ', '_', $this->tipoGenerales['nombre']) . "_" . str_replace(' ', '_', $this->tipoGenerales['apaterno']) . "_" . str_replace(' ', '_', $this->tipoGenerales['amaterno']);

        if($this->identificacion_oficial != ""){
            $FileName_identificacion_oficial = "Identificacion_oficial" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->identificacion_oficial->extension();
            $identificacion_oficialRoute = $this->identificacion_oficial->storeAs(mb_strtolower($route), $FileName_identificacion_oficial, 'public');
            $generales->identificacion_oficial_con_foto = "/storage/" . $identificacion_oficialRoute;
        }

        if($this->acta_nac != ""){
            $FileName_acta_nac = "ACTA_NACIMIENTO_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." . $this->acta_nac->extension();
            $acta_nacRoute = $this->acta_nac->storeAs(mb_strtolower($route), $FileName_acta_nac, 'public');
            $generales->acta_nacimiento = "/storage/" .$acta_nacRoute;
        }
        if($this->acta_matrimonio != ""){
            $FileName_acta_matrimonio = "ACTA_Matrimonio_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->acta_matrimonio->extension();
            $acta_matrimonioRoute = $this->acta_matrimonio->storeAs(mb_strtolower($route), $FileName_acta_matrimonio, 'public');
            $generales->acta_matrimonio = "/storage/" . $acta_matrimonioRoute;
        }
        if($this->curp != ""){
            $FileName_curp = "CURP_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->curp->extension();
            $curpRoute = $this->curp->storeAs(mb_strtolower($route), $FileName_curp, 'public');
            $generales->curp = "/storage/" . $curpRoute;
        }
        if($this->rfc != ""){
            $FileName_rfc = "RFC_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->rfc->extension();
            $rfcRoute = $this->rfc->storeAs(mb_strtolower($route), $FileName_rfc, 'public');
            $generales->rfc = "/storage/" . $rfcRoute;
        }
        if($this->comprobante_domicilio != ""){
            $FileName_comprobante_domicilio = "Comprobante_de_domicilio_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->comprobante_domicilio->extension();
            $comprobante_domicilioRoute = $this->comprobante_domicilio->storeAs(mb_strtolower($route), $FileName_comprobante_domicilio, 'public');
            $generales->comprobante_domicilio = "/storage/" . $comprobante_domicilioRoute;
        }

        $this->tipoGenerales = "";
        $generales->save();
    }

    public function registrarGenerales(){
        $this->validate([
            'identificacion_oficial' => 'required|mimes:pdf',
        ]);

        $proyecto = ModelsProyectos::find($this->proyecto_id);

        $generales = new Generales;
        $generales->cliente_id = $this->tipoGenerales['id'];
        $generales->proyecto_id = $this->proyecto_id;
        $generales->tipo = $this->subprocesoActual->nombre;

        $route = "/uploads/proyectos/" . str_replace(" ", "_", $proyecto->cliente->nombre) . "_" . str_replace(" ", "_", $proyecto->cliente->apaterno) . "_" . str_replace(" ", "_", $proyecto->cliente->amaterno) . "/" . str_replace(" ", "_", $this->servicio['nombre']) . "_" . $this->servicio['id'] . "/" . strtoupper(str_replace(" ", "_", $this->subprocesoActual->nombre)) . "_" . str_replace(' ', '_', $this->tipoGenerales['nombre']) . "_" . str_replace(' ', '_', $this->tipoGenerales['apaterno']) . "_" . str_replace(' ', '_', $this->tipoGenerales['amaterno']);

        if($this->identificacion_oficial != ""){
            $FileName_identificacion_oficial = "Identificacion_oficial" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->identificacion_oficial->extension();
            $identificacion_oficialRoute = $this->identificacion_oficial->storeAs(mb_strtolower($route), $FileName_identificacion_oficial, 'public');
            $generales->identificacion_oficial_con_foto = "/storage/" . $identificacion_oficialRoute;
        }

        if($this->acta_nac != ""){
            $FileName_acta_nac = "ACTA_NACIMIENTO_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." . $this->acta_nac->extension();
            $acta_nacRoute = $this->acta_nac->storeAs(mb_strtolower($route), $FileName_acta_nac, 'public');
            $generales->acta_nacimiento = "/storage/" . $acta_nacRoute;
        }
        if($this->acta_matrimonio != ""){
            $FileName_acta_matrimonio = "ACTA_Matrimonio_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->acta_matrimonio->extension();
            $acta_matrimonioRoute = $this->acta_matrimonio->storeAs(mb_strtolower($route), $FileName_acta_matrimonio, 'public');
            $generales->acta_matrimonio = "/storage/" . $acta_matrimonioRoute;
        }
        if($this->curp != ""){
            $FileName_curp = "CURP_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->curp->extension();
            $curpRoute = $this->curp->storeAs(mb_strtolower($route), $FileName_curp, 'public');
            $generales->curp = "/storage/" . $curpRoute;
        }
        if($this->rfc != ""){
            $FileName_rfc = "RFC_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->rfc->extension();
            $rfcRoute = $this->rfc->storeAs(mb_strtolower($route), $FileName_rfc, 'public');
            $generales->rfc = "/storage/" . $rfcRoute;
        }
        if($this->comprobante_domicilio != ""){
            $FileName_comprobante_domicilio = "Comprobante_de_domicilio_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->comprobante_domicilio->extension();
            $comprobante_domicilioRoute = $this->comprobante_domicilio->storeAs(mb_strtolower($route), $FileName_comprobante_domicilio, 'public');
            $generales->comprobante_domicilio = "/storage/" . $comprobante_domicilioRoute;
        }

        $this->tipoGenerales = "";
        $this->identificacion_oficial = "";
        $generales->save();
    }

    public function registrarHeredero(){
        $this->validate([
            'identificacion_oficial' => 'required|mimes:pdf|max:20000',
        ]);

        $proyecto = ModelsProyectos::find($this->proyecto_id);

        $generales = new Herederos;
        $generales->cliente_id = $this->tipoGenerales['id'];
        $generales->proyecto_id = $this->proyecto_id;
        $generales->tipo = $this->subprocesoActual->nombre;

        $route = "/uploads/proyectos/" . str_replace(" ", "_", $proyecto->cliente->nombre) . "_" . str_replace(" ", "_", $proyecto->cliente->apaterno) . "_" . str_replace(" ", "_", $proyecto->cliente->amaterno) . "/" . str_replace(" ", "_", $this->servicio['nombre']) . "_" . $this->servicio['id'] . "/" . strtoupper(str_replace(" ", "_", $this->subprocesoActual->nombre)) . "_" . str_replace(' ', '_', $this->tipoGenerales['nombre']) . "_" . str_replace(' ', '_', $this->tipoGenerales['apaterno']) . "_" . str_replace(' ', '_', $this->tipoGenerales['amaterno']);

        if($this->identificacion_oficial != ""){
            $FileName_identificacion_oficial = "Identificacion_oficial" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->identificacion_oficial->extension();
            $identificacion_oficialRoute = $this->identificacion_oficial->storeAs(mb_strtolower($route), $FileName_identificacion_oficial, 'public');
            $generales->identificacion_oficial_con_foto = "/storage/" . $identificacion_oficialRoute;
        }

        if($this->acta_nac != ""){
            $FileName_acta_nac = "ACTA_NACIMIENTO_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." . $this->acta_nac->extension();
            $acta_nacRoute = $this->acta_nac->storeAs(mb_strtolower($route), $FileName_acta_nac, 'public');
            $generales->acta_nacimiento = "/storage/" . $acta_nacRoute;
        }
        if($this->acta_matrimonio != ""){
            $FileName_acta_matrimonio = "ACTA_Matrimonio_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->acta_matrimonio->extension();
            $acta_matrimonioRoute = $this->acta_matrimonio->storeAs(mb_strtolower($route), $FileName_acta_matrimonio, 'public');
            $generales->acta_matrimonio = "/storage/" . $acta_matrimonioRoute;
        }
        if($this->curp != ""){
            $FileName_curp = "CURP_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->curp->extension();
            $curpRoute = $this->curp->storeAs(mb_strtolower($route), $FileName_curp, 'public');
            $generales->curp = "/storage/" . $curpRoute;
        }
        if($this->rfc != ""){
            $FileName_rfc = "RFC_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->rfc->extension();
            $rfcRoute = $this->rfc->storeAs(mb_strtolower($route), $FileName_rfc, 'public');
            $generales->rfc = "/storage/" . $rfcRoute;
        }
        if($this->comprobante_domicilio != ""){
            $FileName_comprobante_domicilio = "Comprobante_de_domicilio_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->comprobante_domicilio->extension();
            $comprobante_domicilioRoute = $this->comprobante_domicilio->storeAs(mb_strtolower($route), $FileName_comprobante_domicilio, 'public');
            $generales->comprobante_domicilio = "/storage/" . $comprobante_domicilioRoute;
        }

        $this->tipoGenerales = "";
        $generales->hijo = $this->heredero_hijo ? 1 : 0;
        $generales->save();
    }

    public function borrarTestigo($id){
        Generales::find($id)->delete();
    }

    public function borrarHeredero($id){
        Herederos::find($id)->delete();
    }

    public function guardarTestigos($tipo){
        $avanceProyecto = new AvanceProyecto;
        $avanceProyecto->proyecto_id = $this->proyecto_id;
        $avanceProyecto->proceso_id = $this->procesoActual['id'];
        $avanceProyecto->subproceso_id = $this->subprocesoActual['id'];
        $avanceProyecto->save();
        // $this->closeModal();
        // $this->firebase($this->proyecto_id);

        if($tipo == "testigos"){
            return $this->dispatchBrowserEvent("cerrar-modal-generales-testigos", "Testigos registrados con exito");
        }

        if($tipo == "menores"){
            return $this->dispatchBrowserEvent("cerrar-modal-generales-menores", "Menores registrados con exito");
        }

        if($tipo == "socios"){
            return $this->dispatchBrowserEvent("cerrar-modal-generales-socios", "Socios registrados con exito");
        }

        if($tipo == "apoderados"){
            return $this->dispatchBrowserEvent("cerrar-modal-generales-apoderados", "Apoderados registrados con exito");
        }
    }

    public function guardarGeneralesVarios(){
        $avanceProyecto = new AvanceProyecto;
        $avanceProyecto->proyecto_id = $this->proyecto_id;
        $avanceProyecto->proceso_id = $this->procesoActual['id'];
        $avanceProyecto->subproceso_id = $this->subprocesoActual['id'];
        $avanceProyecto->save();
        // $this->closeModal();
        // $this->firebase($this->proyecto_id);

        return $this->dispatchBrowserEvent("cerrar-modal-generales-varios", "Registro guardado con exito");
    }

    public function guardarHeredero(){
        $avanceProyecto = new AvanceProyecto;
        $avanceProyecto->proyecto_id = $this->proyecto_id;
        $avanceProyecto->proceso_id = $this->procesoActual['id'];
        $avanceProyecto->subproceso_id = $this->subprocesoActual['id'];
        $avanceProyecto->save();
        // $this->closeModal();
        // $this->firebase($this->proyecto_id);
        $this->dispatchBrowserEvent("cerrar-modal-generales-herederos", "Herederos registrados");
    }

    public function asignacionSinDocs(){
        $generales = new Generales;
        $generales->cliente_id = $this->tipoGenerales->id;
        $generales->proyecto_id = $this->proyecto_id;
        $generales->tipo = $this->subprocesoActual->nombre;
        $generales->save();

        $avanceProyecto = new AvanceProyecto;
        $avanceProyecto->proyecto_id = $this->proyecto_id;
        $avanceProyecto->proceso_id = $this->procesoActual['id'];
        $avanceProyecto->subproceso_id = $this->subprocesoActual['id'];
        $avanceProyecto->save();
        $this->closeModal();
        // $this->firebase($this->proyecto_id);
    }

    public function uploadDocument(){
        // Certificacion de libertad de gravamen
        if($this->tituloModal == "Importar proyecto" || $this->tituloModal == 'Aviso de testamento'){
            $this->validate([
                "documentFile" => "required|mimes:pdf,doc,docx",
            ]);
        }elseif(
            $this->tituloModal == "Importar inventario y avaluo" ||
            $this->tituloModal == "Importar sesiones de derechos hereditarios" ||
            $this->tituloModal == "Importar edictos" ||
            $this->tituloModal == "Importar testamento" ||
            $this->tituloModal == "Certificacion de libertad de gravamen"
        ){
            $this->validate([
                "documentFile" => $this->documentFile != "" ? "mimes:pdf" : "",
            ]);
        }else{
            $this->validate([
                "documentFile" => "required|mimes:pdf",
            ]);
        }

        $newdocument = new Documentos;
        $proyecto = ModelsProyectos::find($this->proyecto_id);

        if($this->documentFile != ""){
            $route = "/uploads/proyectos/" . str_replace(" ", "_", $proyecto->cliente->nombre) . "_" . str_replace(" ", "_", $proyecto->cliente->apaterno) . "_" . str_replace(" ", "_", $proyecto->cliente->amaterno) . "/" . str_replace(" ", "_", $this->servicio['nombre']) . "_" . $this->servicio['id'] . "/documentos";

            $fileName = time() . "_" . strtoupper(str_replace(" ", "_", $this->subprocesoActual->nombre)) . "." . $this->documentFile->extension();
            $uploadData = $this->documentFile->storeAs(mb_strtolower($route), $fileName, 'public');
            $newdocument->storage = "/storage/" . $uploadData;
        }else{
            $uploadData = "";
            $newdocument->storage = $uploadData;
        }

        $newdocument->nombre = $this->subprocesoActual->nombre;
        $newdocument->cliente_id = $proyecto->cliente->id;
        $newdocument->proyecto_id = $proyecto->id;
        $newdocument->save();

        $avanceProyecto = new AvanceProyecto;
        $avanceProyecto->proyecto_id = $this->proyecto_id;
        $avanceProyecto->proceso_id = $this->procesoActual['id'];
        $avanceProyecto->subproceso_id = $this->subprocesoActual['id'];
        $avanceProyecto->save();

        $this->closeModal();
        return $this->dispatchBrowserEvent('cerrar-modal-subir-documentos', "Documento registrado con exito");
        // $this->firebase($this->proyecto_id);
    }


    public function uploadNewDocument(){
        $this->validate([
            "documentFile" => "required|mimes:pdf,doc,docx",
        ]);

        $newdocument = Documentos::find($this->document_id);
        $proyecto = ModelsProyectos::find($this->proyecto_id);
        $this->servicio = $proyecto->servicio;

        $route = "/uploads/proyectos/" . str_replace(" ", "_", $proyecto->cliente->nombre) . "_" . str_replace(" ", "_", $proyecto->cliente->apaterno) . "_" . str_replace(" ", "_", $proyecto->cliente->amaterno) . "/" . str_replace(" ", "_", $this->servicio['nombre']) . "_" . $this->servicio['id'] . "/documentos";

        $fileName = time() . "_" . strtoupper(str_replace(" ", "_", $this->subprocesoActual->nombre)) . "." . $this->documentFile->extension();
        $uploadData = $this->documentFile->storeAs(mb_strtolower($route), $fileName, 'public');
        $newdocument->storage = "/storage/" . $uploadData;

        $newdocument->save();

        // $this->closeModal();
        // $this->firebase($this->proyecto_id);
        return $this->dispatchBrowserEvent('cerrar-modal-editar-documentos', "Documento editado con exito");
    }

    public function agendarfecha(){
        // $this->firebase($this->proyecto_id);
        $proyecto = ModelsProyectos::find($this->proyecto_id);

        $agregarMinutos = strtotime('+' . $proyecto->servicio->tiempo_firma . ' minute', strtotime($this->fechayhoraInput));
        $agregarMinutos = date("Y-m-d H:i:s", $agregarMinutos);

        $buscarFirmas = Firmas::where('fecha_inicio', 'LIKE', '%' . date("Y-m-d", strtotime($this->fechayhoraInput)) . '%')->get();
        $firmasignada = false;
        $i = 0;
        $errorMessage = "";

        if(count($buscarFirmas) > 0){
            do {
                $firmas = $buscarFirmas[$i];
                $firstCheck = $this->checkTimeRange(date("H:i", strtotime($firmas['fecha_inicio'])), date("H:i", strtotime($firmas['fecha_fin'])), date("H:i", strtotime($this->fechayhoraInput)));
                $secondCheck = $this->checkTimeRange(date("H:i", strtotime($firmas['fecha_inicio'])), date("H:i", strtotime($firmas['fecha_fin'])), date("H:i", strtotime($agregarMinutos)));
                // dd($firstCheck, $secondCheck);
                if($firstCheck == true || $secondCheck == true){
                    $firmasignada = true;
                    $errorMessage = "Esta fecha y hora no esta disponible ya que existe una firma para " . $firmas['nombre'] . " de " . date("H:i", strtotime($firmas['fecha_inicio'])) . " a " . date("H:i", strtotime($firmas['fecha_fin']));
                    return $this->addError('invalidDate', $errorMessage);
                }else{
                    if($i == count($buscarFirmas) -1){
                        $firmasignada = true;
                    }else{
                        $i++;
                    }
                }
            } while ($firmasignada == false);
        }

        // if($firmasignada){
        //     $this->addError('invalidDate', $errorMessage);
        // }

        // dd($firmasignada);
        $newfirma = new Firmas;
        $newfirma->nombre = $proyecto->servicio->nombre;
        $newfirma->fecha_inicio = $this->fechayhoraInput;
        $newfirma->fecha_fin = $agregarMinutos;
        $newfirma->proceso_id = $this->procesoActual['id'];
        $newfirma->cliente_id = $proyecto->cliente->id;;
        $newfirma->proyecto_id = $proyecto->id;
        $newfirma->save();

        $avanceProyecto = new AvanceProyecto;
        $avanceProyecto->proyecto_id = $this->proyecto_id;
        $avanceProyecto->proceso_id = $this->procesoActual['id'];
        $avanceProyecto->subproceso_id = $this->subprocesoActual['id'];
        $avanceProyecto->save();

        $this->fechayhoraInput = "";
        // $this->closeModal();
        return $this->dispatchBrowserEvent('cerrar-modal-agendar-firma');
    }

    public function registrarFirma(){
        $proyecto = ModelsProyectos::find($this->proyecto_id);

        $newfirma = new RegistroFirmas();
        $newfirma->nombre = $this->subprocesoActual['nombre'];
        $newfirma->fechayhora = $this->fechayhoraInput;
        $newfirma->proceso_id = $this->procesoActual['id'];
        $newfirma->subproceso_id = $this->subprocesoActual['id'];
        $newfirma->cliente_id = $proyecto->cliente->id;;
        $newfirma->proyecto_id = $proyecto->id;
        $newfirma->save();

        $avanceProyecto = new AvanceProyecto;
        $avanceProyecto->proyecto_id = $this->proyecto_id;
        $avanceProyecto->proceso_id = $this->procesoActual['id'];
        $avanceProyecto->subproceso_id = $this->subprocesoActual['id'];
        $avanceProyecto->save();

        // $this->closeModal();
        $this->fechayhoraInput = "";
        // $this->firebase($this->proyecto_id);
        return $this->dispatchBrowserEvent('cerrar-modal-registrar-firma', "Fecha para entrega de documentos registrada");
    }

    function checkTimeRange($from, $to, $input){
        $dateFrom = DateTime::createFromFormat('!H:i', $from);
        $dateTo = DateTime::createFromFormat('!H:i', $to);
        $dateInput = DateTime::createFromFormat('!H:i', $input);
        if($dateFrom > $dateTo) $dateTo->modify('+1 day');
        return ($dateFrom <= $dateInput && $dateInput <= $dateTo) || ($dateFrom <= $dateInput->modify('+1 day') && $dateInput <= $dateTo);
    }

    public function registrarAutorizacion(){
        $this->validate([
            'num_comprobante' => 'required',
            'cuenta_predial' => 'required',
            'clave_catastral' => 'required'
        ]);

        $nuevaAutorizacion = new AutorizacionCatastro();
        $nuevaAutorizacion->comprobante = $this->num_comprobante;
        $nuevaAutorizacion->cuenta_predial = $this->cuenta_predial;
        $nuevaAutorizacion->clave_catastral = $this->clave_catastral;
        $nuevaAutorizacion->proceso_id = $this->procesoActual['id'];;
        $nuevaAutorizacion->subproceso_id = $this->subprocesoActual['id'];;
        $nuevaAutorizacion->proyecto_id = $this->proyecto_id;

        $avanceProyecto = new AvanceProyecto;
        $avanceProyecto->proyecto_id = $this->proyecto_id;
        $avanceProyecto->proceso_id = $this->procesoActual['id'];
        $avanceProyecto->subproceso_id = $this->subprocesoActual['id'];
        $avanceProyecto->save();

        // $this->closeModal();
        // $this->firebase($this->proyecto_id);
        $this->num_comprobante = '';
        $this->cuenta_predial = '';
        $this->clave_catastral = '';
        return $this->dispatchBrowserEvent('cerrar-modal-registrar-autorizacion-catastro', "Autorizacion registrada");
    }

    public $letras = "";
    public $numero = 2008;

    public function numeroaletras(){
        $hora = date('H');
        $minutos = date('i');
        $formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        // $this->letras = $formatterES->format($this->numero);
        $this->letras = $hora . ":" . $minutos;
    }

    public function downloadProyect($proyecto_id){
        setlocale(LC_ALL, 'es_ES');
        $formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        $templateprocessor = new TemplateProcessor('word-template/compraventastemplate.docx');
        $proyecto = ModelsProyectos::find($proyecto_id);
        $dateObj   = DateTime::createFromFormat('!m', date("m", strtotime($proyecto->created_at)));
        $monthName = strftime('%B', $dateObj->getTimestamp());

        $vendedor = "";
        $comprador = "";

        foreach($proyecto->generalesCliente as $general) {
            if($general->tipo == "Generales del comprador"){
                $comprador = $general;
            }

            if($general->tipo == "Generales del vendedor"){
                $vendedor = $general;
            }
        }

        $vendedordateObj = DateTime::createFromFormat('!m', date("m", strtotime($vendedor->cliente->fecha_nacimiento)));
        $mesnacvendedor = strftime('%B', $vendedordateObj->getTimestamp());

        $compradordateObj = DateTime::createFromFormat('!m', date("m", strtotime($comprador->cliente->fecha_nacimiento)));
        $mesnaccomprador = strftime('%B', $compradordateObj->getTimestamp());

        // dd($mesnacvendedor);

        $templateprocessor->setValue('id_proyecto', $proyecto->id . " " . strtoupper($formatterES->format($proyecto->id)));
        $templateprocessor->setValue('hora_minutos', date("H:i", strtotime($proyecto->created_at)));
        $templateprocessor->setValue('texto_hora', $formatterES->format(date("H", strtotime($proyecto->created_at))));
        $templateprocessor->setValue('texto_minutos', $formatterES->format(date("i", strtotime($proyecto->created_at))));
        $templateprocessor->setValue('dia', date("d", strtotime($proyecto->created_at)));
        $templateprocessor->setValue('texto_dia', $formatterES->format(date("d", strtotime($proyecto->created_at))));
        $templateprocessor->setValue('texto_mes', $monthName);
        $templateprocessor->setValue('year', date("Y", strtotime($proyecto->created_at)));
        $templateprocessor->setValue('texto_year', $formatterES->format(date("Y", strtotime($proyecto->created_at))));
        $templateprocessor->setValue('vendedor', $vendedor->cliente->nombre . " " . $vendedor->cliente->apaterno . " " . $vendedor->cliente->amaterno);
        $templateprocessor->setValue('comprador', $comprador->cliente->nombre . " " . $comprador->cliente->apaterno . " " . $comprador->cliente->amaterno);

        $templateprocessor->setValue('edo_civil_vendedor', strtolower($vendedor->cliente->estado_civil));
        $templateprocessor->setValue('ocupación_vendedor', strtolower($vendedor->cliente->getOcupacion->nombre));
        $templateprocessor->setValue('origen_vendedor', $vendedor->cliente->getMunicipio->nombre . ", " . $vendedor->cliente->getMunicipio->getEstado->nombre . ", " . $vendedor->cliente->getMunicipio->getEstado->getPais->nombre);
        $templateprocessor->setValue('dia_nac_vendedor', date("d", strtotime($vendedor->cliente->fecha_nacimiento)));
        $templateprocessor->setValue('dia_nac_vendedor_text', $formatterES->format(date("d", strtotime($vendedor->cliente->fecha_nacimiento))));
        $templateprocessor->setValue('mes_vendedor', $mesnacvendedor);
        $templateprocessor->setValue('year_nac_vendedor', date("Y", strtotime($vendedor->cliente->fecha_nacimiento)));
        $templateprocessor->setValue('year_nac_vendedor_text', $formatterES->format(date("Y", strtotime($vendedor->cliente->fecha_nacimiento))));
        $templateprocessor->setValue('dom_calle_vendedor', mb_strtolower($vendedor->cliente->domicilio->calle));
        $templateprocessor->setValue('dom_colonia_vendedor', mb_strtolower($vendedor->cliente->domicilio->getColonia->nombre));
        $templateprocessor->setValue('dom_num_vendedor', $vendedor->cliente->domicilio->numero_ext);
        $templateprocessor->setValue('dom_num_vendedor_text', $formatterES->format($vendedor->cliente->domicilio->numero_ext));
        $templateprocessor->setValue('dom_cp_vendedor', $vendedor->cliente->domicilio->getColonia->codigo_postal);
        $templateprocessor->setValue('curp_vendedor', $vendedor->cliente->curp);

        $templateprocessor->setValue('edo_civil_comprador', strtolower($comprador->cliente->estado_civil));
        $templateprocessor->setValue('ocupación_comprador', strtolower($comprador->cliente->getOcupacion->nombre));
        $templateprocessor->setValue('origen_comprador', $comprador->cliente->getMunicipio->nombre . ", " . $comprador->cliente->getMunicipio->getEstado->nombre . ", " . $comprador->cliente->getMunicipio->getEstado->getPais->nombre);
        $templateprocessor->setValue('dia_nac_comprador', date("d", strtotime($comprador->cliente->fecha_nacimiento)));
        $templateprocessor->setValue('dia_nac_comprador_text', $formatterES->format(date("d", strtotime($comprador->cliente->fecha_nacimiento))));
        $templateprocessor->setValue('mes_comprador', $mesnaccomprador);
        $templateprocessor->setValue('year_nac_comprador', date("Y", strtotime($comprador->cliente->fecha_nacimiento)));
        $templateprocessor->setValue('year_nac_comprador_text', $formatterES->format(date("Y", strtotime($comprador->cliente->fecha_nacimiento))));
        $templateprocessor->setValue('dom_calle_comprador', mb_strtolower($comprador->cliente->domicilio->calle));
        $templateprocessor->setValue('dom_colonia_comprador', mb_strtolower($comprador->cliente->domicilio->getColonia->nombre));
        $templateprocessor->setValue('dom_num_comprador', $comprador->cliente->domicilio->numero_ext);
        $templateprocessor->setValue('dom_num_comprador_text', $formatterES->format($comprador->cliente->domicilio->numero_ext));
        $templateprocessor->setValue('dom_cp_comprador', $comprador->cliente->domicilio->getColonia->codigo_postal);
        $templateprocessor->setValue('curp_comprador', $comprador->cliente->curp);

        $filename = "DocumentoPrueba";
        $templateprocessor->saveAs($filename . '.docx');
        return response()->download($filename . ".docx")->deleteFileAfterSend(true);
    }

    public $modalNuevoProyecto = false;
    public $servicio_id = "";
    public $nombreCliente;
    public $apaternoCliente;
    public $amaternoCliente;
    public $generoCliente;
    public $telefonoCliente;
    public $fecha_nacimientoCliente;
    public $emailCliente;

    public function openModalNuevoProyecto(){
        $this->modalNuevoProyecto = true;
    }

    public function closeModalNuevoProyecto(){
        $this->modalNuevoProyecto = false;
    }

    public function asignarClienteNp($cliente){
        $this->buscarCliente = "";
        $this->cliente_id = $cliente['id'];
        $this->nombreCliente = $cliente['nombre'];
        $this->apaternoCliente = $cliente['apaterno'];
        $this->amaternoCliente = $cliente['amaterno'];
        $this->generoCliente = $cliente['genero'];
        $this->telefonoCliente = $cliente['telefono'];
        $this->fecha_nacimientoCliente = $cliente['fecha_nacimiento'];
        $this->emailCliente = $cliente['email'];
    }

    public function saveProyecto(){
        $this->validate([
            "cliente_id" => "required",
            "cliente_id" => "required",
        ]);
    }

    public function firebase($proyecto_id){
        if($this->hasConnection()){
            $proyecto = ModelsProyectos::find($proyecto_id);
            $arrayTemp = [];

            // $reference = $database->getReference('/people');
            // $snapshot = $reference->getSnapshot()->getValue();

            foreach ($proyecto->avance as $key => $value) {
                $data = [];
                array_push($arrayTemp, $data);
                $arrayTemp[$value->proceso->nombre] = $arrayTemp[$key];
                unset($arrayTemp[$key]);
            }

            foreach ($proyecto->avance as $key => $value) {
                $newdata = [
                    "subproceso" => $value->subproceso->nombre,
                    "fecha_hora" => $value->subproceso->created_at,
                ];
                array_push($arrayTemp[$value->proceso->nombre], $newdata);
            }

            $this->database = app('firebase.database');
            $this->database->getReference("actos/" . $proyecto->cliente->nombre . " " . $proyecto->cliente->apaterno . " " . $proyecto->cliente->amaterno . "/" .$proyecto->servicio->nombre . "_" . $proyecto->servicio->id)
            ->set([
                'cliente' => $proyecto->cliente->nombre . " " . $proyecto->cliente->apaterno . " " . $proyecto->cliente->amaterno,
                'avance' => $arrayTemp
            ]);
        }
    }

    function hasConnection() {
        $ch = curl_init("https://www.google.com");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($httpcode>=200 && $httpcode<300) ? TRUE : FALSE;
    }

    public $modalObservaciones = false;
    public $modalVerObservaciones = false;
    public $observacion_id, $tituloObservacion, $descripcionObservacion, $imgobservacion;

    public function openModalObservaciones($id){
        $this->proyecto_id = $id;
        $this->modalObservaciones = true;
    }
    public function closeModalObservaciones(){
        $this->modalObservaciones = false;
        $this->imgobservacion = "";
        $this->proyecto_id = "";
        $this->observacion_id = "";
        $this->tituloObservacion = "";
        $this->descripcionObservacion = "";
    }

    public function saveObservacion(){
        $this->validate([
            'tituloObservacion' => 'required|max:250',
            'descripcionObservacion' => 'required',
            'imgobservacion' => $this->imgobservacion != "" ? 'image' : "",
        ]);

        $newobservacion = new Observaciones();
        $newobservacion->titulo = $this->tituloObservacion;
        $newobservacion->descripcion = $this->descripcionObservacion;

        if($this->imgobservacion != ""){
            $route = "/uploads/img/observaciones";
            $filename = "Observacion_" . $this->proyecto_id . "_" . time() . "." . $this->imgobservacion->extension();
            $imgpath = $this->imgobservacion->storeAs(mb_strtolower($route), $filename, 'public');
            $newobservacion->img_path = "/storage/" . $imgpath;
        }

        $newobservacion->proyecto_id = $this->proyecto_id;
        $newobservacion->save();
        $this->closeModalObservaciones();
    }

    public function verObservacion($id){
        $observacion = Observaciones::find($id);
        $this->tituloObservacion = $observacion->titulo;
        $this->descripcionObservacion = $observacion->descripcion;
        $this->imgobservacion = $observacion->img_path;
        $this->modalVerObservaciones = true;
    }

    public function cerrarModalVerObservacion(){
        $this->tituloObservacion = "";
        $this->descripcionObservacion = "";
        $this->imgobservacion = "";
        $this->modalVerObservaciones = false;
    }


    public function editarSubproceso($id){
        $avance = AvanceProyecto::find($id);
        // dd($avance->subproceso->tiposub->id, $avance->subproceso->tiposub->nombre);

        //DATOS DE AUTORIZACION DE CATASTRO
        if($avance->subproceso->tiposub->id == 3){

        }

        //DATOS DE AUTORIZACION DE CATASTRO
        if($avance->subproceso->tiposub->id == 3){

        }

        if($avance->subproceso->tiposub->id == 4){
            $generales = Generales::where("proyecto_id", $avance->proyecto_id)
                ->where("tipo", $avance->subproceso->nombre)->first();
            $this->generales_data = $generales;
            $this->tipoGenerales = $generales->cliente;
            $this->buscarCliente = "";
            $this->proyecto_id = $avance->proyecto_id;
            $this->subprocesoActual = $avance->subproceso;
            $this->tituloModal = $avance->subproceso->nombre;
            return $this->dispatchBrowserEvent('abrir-editar-generales-docs', "Abrir modal");
        }

        // Fecha y hora
        if($avance->subproceso->tiposub->id == 5){

        }

        // Documentos (PDF)
        // if($avance->subproceso->tiposub->id == 6){

        //     return $this->dispatchBrowserEvent('abrir-modal-subir-documentos ');
        // }

        // Fecha y hora de solicitud
        if($avance->subproceso->tiposub->id == 8){

        }

        // Recibos de pago
        if($avance->subproceso->tiposub->id == 10){
            $generales = RecibosPago::where("proyecto_id", $avance->proyecto_id)
                ->where("subproceso_id", $avance->subproceso_id)->get();
                $this->gasto_de_recibo = $generales->gasto_de_recibo;
                $this->gasto_de_gestoria = $generales->gasto_de_gestoria;
            return $this->dispatchBrowserEvent('abrir-modal-editar-recibos-pago');
        }
        dd($avance->subproceso->tiposub->id);

        // $this->closeModalTimeLine();
    }

    public function editarGeneralesDocs(){
        $proyecto = ModelsProyectos::find($this->proyecto_id);
        $route = "/uploads/proyectos/" . str_replace(" ", "_", $proyecto->cliente->nombre) . "_" . str_replace(" ", "_", $proyecto->cliente->apaterno) . "_" . str_replace(" ", "_", $proyecto->cliente->amaterno) . "/" . str_replace(" ", "_", $this->servicio['nombre']) . "_" . $this->servicio['id'] . "/" . strtoupper(str_replace(" ", "_", $this->subprocesoActual->nombre)) . "_" . str_replace(' ', '_', $this->tipoGenerales['nombre']) . "_" . str_replace(' ', '_', $this->tipoGenerales['apaterno']) . "_" . str_replace(' ', '_', $this->tipoGenerales['amaterno']);
        $generales = Generales::find($this->generales_data->id);

        $generales->cliente_id = $this->tipoGenerales->id;

        if($this->acta_nac != ""){
            $FileName_acta_nac = "ACTA_NACIMIENTO_" . $this->tipoGenerales->nombre . "_" . $this->tipoGenerales->apaterno . "_" . $this->tipoGenerales->amaterno . "." . $this->acta_nac->extension();
            $acta_nacRoute = $this->acta_nac->storeAs(mb_strtolower($route), $FileName_acta_nac, 'public');
            $generales->acta_nacimiento = "/storage/" .$acta_nacRoute;
        }
        if($this->acta_matrimonio != ""){
            $FileName_acta_matrimonio = "ACTA_Matrimonio_" . $this->tipoGenerales->nombre . "_" . $this->tipoGenerales->apaterno . "_" . $this->tipoGenerales->amaterno . "." .  $this->acta_matrimonio->extension();
            $acta_matrimonioRoute = $this->acta_matrimonio->storeAs(mb_strtolower($route), $FileName_acta_matrimonio, 'public');
            $generales->acta_matrimonio = "/storage/" . $acta_matrimonioRoute;
        }
        if($this->curp != ""){
            $FileName_curp = "CURP_" . $this->tipoGenerales->nombre . "_" . $this->tipoGenerales->apaterno . "_" . $this->tipoGenerales->amaterno . "." .  $this->curp->extension();
            $curpRoute = $this->curp->storeAs(mb_strtolower($route), $FileName_curp, 'public');
            $generales->curp = "/storage/" . $curpRoute;
        }
        if($this->rfc != ""){
            $FileName_rfc = "RFC_" . $this->tipoGenerales->nombre . "_" . $this->tipoGenerales->apaterno . "_" . $this->tipoGenerales->amaterno . "." .  $this->rfc->extension();
            $rfcRoute = $this->rfc->storeAs(mb_strtolower($route), $FileName_rfc, 'public');
            $generales->rfc = "/storage/" . $rfcRoute;
        }
        if($this->identificacion_oficial != ""){
            $FileName_identificacion_oficial = "Identificacion_oficial_" . $this->tipoGenerales->nombre . "_" . $this->tipoGenerales->apaterno . "_" . $this->tipoGenerales->amaterno . "." .  $this->identificacion_oficial->extension();
            $identificacion_oficialRoute = $this->identificacion_oficial->storeAs(mb_strtolower($route), $FileName_identificacion_oficial, 'public');
            $generales->identificacion_oficial_con_foto = "/storage/" . $identificacion_oficialRoute;
        }
        if($this->comprobante_domicilio != ""){
            $FileName_comprobante_domicilio = "Comprobante_de_domicilio_" . $this->tipoGenerales->nombre . "_" . $this->tipoGenerales->apaterno . "_" . $this->tipoGenerales->amaterno . "." .  $this->comprobante_domicilio->extension();
            $comprobante_domicilioRoute = $this->comprobante_domicilio->storeAs(mb_strtolower($route), $FileName_comprobante_domicilio, 'public');
            $generales->comprobante_domicilio = "/storage/" . $comprobante_domicilioRoute;
        }
        $generales->save();
        return $this->dispatchBrowserEvent('cerrar-editar-generales-docs', "$generales->tipo" . " ha sido editado");
    }

    public $proyectos_escritura = [];

    public function verRegistroSubproceso($id){
        $avance = AvanceProyecto::find($id);
        $this->tituloModal = $avance->subproceso->nombre;
        $this->subprocesoActual = SubprocesosCatalogos::find($avance->subproceso_id);

        if($avance->subproceso->tiposub->id == 4){
            $this->generales_data = Generales::where("proyecto_id", $avance->proyecto_id)
                ->where("tipo", $avance->subproceso->nombre)->first();
            return $this->dispatchBrowserEvent('abrir-vista_previa');
        }

        if($avance->subproceso->tiposub->id == 6){
            $this->proyectos_escritura = Documentos::where("proyecto_id", $avance->proyecto_id)
                ->where("nombre", $avance->subproceso->nombre)->get();
            return $this->dispatchBrowserEvent('abrir-modal-proyecto');
        }

        if($avance->subproceso->tiposub->id == 11){
            $nombreacta = ActasDestacas::where("proyecto_id", $avance->proyecto_id)->first();
            $this->nombreacta = $nombreacta->nombre;
            return $this->dispatchBrowserEvent('abrir-modal-nombre-acta');
        }

        if($avance->subproceso->tiposub->id == 19){
            $this->varios_generales_data = Generales::where("proyecto_id", $avance->proyecto_id)
                ->where("tipo", $avance->subproceso->nombre)->get();
            return $this->dispatchBrowserEvent('abrir-modal-vista-varios-generales');
        }

        // dd($avance->subproceso->tiposub->id);
    }


// Registrar recbios de pago
    public $recibo_pago_id;
    public $gasto_de_recibo = 0.0;
    public $gasto_de_gestoria = 0.0;
    public $totalRecbio = 0.0;
    public $recibo_de_pago;

    public function gastoRecibo(){
        $this->totalRecbio = $this->gasto_de_recibo + $this->gasto_de_gestoria;
    }

    public function registrarReciboPago(){
        $this->validate([
            "gasto_de_recibo" => "required",
            "gasto_de_gestoria" => "required",
            "recibo_de_pago" => "required",
        ]);

        $proyecto = ModelsProyectos::find($this->proyecto_id);
        $route = "/uploads/proyectos/" . str_replace(" ", "_", $proyecto->cliente->nombre) . "_" . str_replace(" ", "_", $proyecto->cliente->apaterno) . "_" . str_replace(" ", "_", $proyecto->cliente->amaterno) . "/" . str_replace(" ", "_", $this->servicio['nombre']) . "_" . $this->servicio['id'] . "/documentos";
        $fileName = mb_strtolower(str_replace(" ", "_", $this->subprocesoActual->nombre)) . "." . $this->recibo_de_pago->extension();
        $uploadData = $this->recibo_de_pago->storeAs(mb_strtolower($route), $fileName, 'public');

        $recibo = new RecibosPago;
        $recibo->nombre = $this->subprocesoActual->nombre;
        $recibo->path = "/storage/" . $uploadData;
        $recibo->costo_recibo = $this->gasto_de_recibo;
        $recibo->gastos_gestoria = $this->gasto_de_gestoria;
        $recibo->proyecto_id = $this->proyecto_id;
        $recibo->subproceso_id = $this->subprocesoActual->id;
        $recibo->save();

        $avanceProyecto = new AvanceProyecto;
        $avanceProyecto->proyecto_id = $this->proyecto_id;
        $avanceProyecto->proceso_id = $this->procesoActual['id'];
        $avanceProyecto->subproceso_id = $this->subprocesoActual['id'];
        $avanceProyecto->save();

        $this->gasto_de_recibo = 0;
        $this->gasto_de_gestoria = 0;
        $this->recibo_de_pago = "";

        return $this->dispatchBrowserEvent('cerrar-modal-recibo-pago', "Recibo de pago registrado con exito");
    }

    public function editarReciboPago(){
        $this->validate([
            "gasto_de_recibo" => "required",
            "gasto_de_gestoria" => "required",
            "recibo_de_pago" => $this->recibo_de_pago != "" ? "required" : "",
        ]);

        $proyecto = ModelsProyectos::find($this->proyecto_id);
        $route = "/uploads/proyectos/" . str_replace(" ", "_", $proyecto->cliente->nombre) . "_" . str_replace(" ", "_", $proyecto->cliente->apaterno) . "_" . str_replace(" ", "_", $proyecto->cliente->amaterno) . "/" . str_replace(" ", "_", $this->servicio['nombre']) . "_" . $this->servicio['id'] . "/documentos";
        $fileName = mb_strtolower(str_replace(" ", "_", $this->subprocesoActual->nombre)) . "." . $this->recibo_de_pago->extension();
        $uploadData = $this->recibo_de_pago->storeAs(mb_strtolower($route), $fileName, 'public');
        $recibo = new RecibosPago;

        $recibo = RecibosPago::find($this->recibo_pago_id);
        $recibo->path = "/storage/" . $uploadData;
        $recibo->costo_recibo = $this->gasto_de_recibo;
        $recibo->gastos_gestoria = $this->gasto_de_gestoria;
        $recibo->save();

        $this->gasto_de_recibo = 0;
        $this->gasto_de_gestoria = 0;
        $this->recibo_de_pago = "";

        return $this->dispatchBrowserEvent('cerrar-modal-editar-recibos-pago', "Recibo de pago editado");
    }

    public function asignarnombredelacta(){
        $this->validate([
            "nombreacta" => "required"
        ]);

        $nombreacta = new ActasDestacas;
        $nombreacta->nombre = $this->nombreacta;
        $nombreacta->proyecto_id = $this->proyecto_id;
        $nombreacta->save();

        $avanceProyecto = new AvanceProyecto;
        $avanceProyecto->proyecto_id = $this->proyecto_id;
        $avanceProyecto->proceso_id = $this->procesoActual['id'];
        $avanceProyecto->subproceso_id = $this->subprocesoActual['id'];
        $avanceProyecto->save();

        $this->nombreacta = "";
        return $this->dispatchBrowserEvent('cerrar-modal-registrar-nombre-acta', "Nombre del acta registrado");
    }

    public function importarArchivos(){
        $this->validate([
            'documentsActaDestacada.*' => 'mimes:pdf',
        ]);

        $proyecto = ModelsProyectos::find($this->proyecto_id);

        foreach ($this->documentsActaDestacada as $documentFile) {
            $newdocument = new Documentos;
            $route = "/uploads/proyectos/" . str_replace(" ", "_", $proyecto->cliente->nombre) . "_" . str_replace(" ", "_", $proyecto->cliente->apaterno) . "_" . str_replace(" ", "_", $proyecto->cliente->amaterno) . "/" . str_replace(" ", "_", $this->servicio['nombre']) . "_" . $this->servicio['id'] . "/documentos";

            $fileName = strtoupper(str_replace(" ", "_", $this->subprocesoActual->nombre)) . $documentFile->getClientOriginalName();
            $uploadData = $documentFile->storeAs(mb_strtolower($route), $fileName, 'public');
            $newdocument->storage = "/storage/" . $uploadData;
            $newdocument->nombre = $this->subprocesoActual->nombre . " " . $fileName;
            $newdocument->cliente_id = $proyecto->cliente->id;
            $newdocument->proyecto_id = $proyecto->id;
            $newdocument->save();
        }

        $avanceProyecto = new AvanceProyecto;
        $avanceProyecto->proyecto_id = $this->proyecto_id;
        $avanceProyecto->proceso_id = $this->procesoActual['id'];
        $avanceProyecto->subproceso_id = $this->subprocesoActual['id'];
        $avanceProyecto->save();
        $this->documentsActaDestacada = [];
        return $this->dispatchBrowserEvent('cerrar-modal-subir-varios-documentos', "Documentos registrados");
    }

    public function registrarapoderados(){
        $this->validate([
            "nombreapoderados" => "required"
        ]);

        $apoderados = new Apoderados;
        $apoderados->apoderados = $this->nombreapoderados;
        $apoderados->proyecto_id = $this->proyecto_id;
        $apoderados->save();

        $avanceProyecto = new AvanceProyecto;
        $avanceProyecto->proyecto_id = $this->proyecto_id;
        $avanceProyecto->proceso_id = $this->procesoActual['id'];
        $avanceProyecto->subproceso_id = $this->subprocesoActual['id'];
        $avanceProyecto->save();

        $this->nombreapoderados = "";

        return $this->dispatchBrowserEvent('cerrar-modal-registrar-nombre-apoderados', "Nombres de los apoderados registrados");
    }

    public $pais_procedencia = "";
    public $pais_destino = "";
    public $aereolinea;
    public $numero_vuelo;
    public $nombre_garita;
    public $tiempo_extranjero;
    public $domicilio_destino;
    public $personas_viaje;

    public function registrarinformacionmenor(){
        $this->validate([
            "pais_procedencia" => "required",
            "pais_destino" => "required",
            "tiempo_extranjero" => "required",
            "domicilio_destino" => "required",
            "personas_viaje" => "required"
        ]);

        $infoviaje = new InformacionDelViajeDelMenor;
        $infoviaje->pais_procedencia = $this->pais_procedencia;
        $infoviaje->pais_destino = $this->pais_destino;
        $infoviaje->aereolinea = $this->aereolinea;
        $infoviaje->numero_vuelo = $this->numero_vuelo;
        $infoviaje->nombre_garita = $this->nombre_garita;
        $infoviaje->tiempo_extranjero = $this->tiempo_extranjero;
        $infoviaje->domicilio_destino = $this->domicilio_destino;
        $infoviaje->personas_viaje = $this->personas_viaje;
        $infoviaje->proyecto_id = $this->proyecto_id;
        $infoviaje->save();

        $avanceProyecto = new AvanceProyecto;
        $avanceProyecto->proyecto_id = $this->proyecto_id;
        $avanceProyecto->proceso_id = $this->procesoActual['id'];
        $avanceProyecto->subproceso_id = $this->subprocesoActual['id'];
        $avanceProyecto->save();

        $this->pais_procedencia = "";
        $this->pais_destino = "";
        $this->aereolinea = "";
        $this->numero_vuelo = "";
        $this->nombre_garita = "";
        $this->tiempo_extranjero = "";
        $this->domicilio_destino = "";
        $this->personas_viaje = "";

        return $this->dispatchBrowserEvent('cerrar-modal-registrar-informacion-viaje', "Informacion del viaje registrada");
    }

    public $cantidad_mutuo;
    public $forma_pago_mutuo;
    public $tiempo_mutuo;

    public function registrarInfoMutuo(){
        $this->validate([
            "cantidad_mutuo" => "required",
            "forma_pago_mutuo" => "required",
            "tiempo_mutuo" => "required",
        ]);

        $mutuo = new Mutuos;
        $mutuo->cantidad = $this->cantidad_mutuo;
        $mutuo->forma_pago = $this->forma_pago_mutuo;
        $mutuo->tiempo = $this->tiempo_mutuo;
        $mutuo->proyecto_id = $this->proyecto_id;
        $mutuo->save();

        $avanceProyecto = new AvanceProyecto;
        $avanceProyecto->proyecto_id = $this->proyecto_id;
        $avanceProyecto->proceso_id = $this->procesoActual['id'];
        $avanceProyecto->subproceso_id = $this->subprocesoActual['id'];
        $avanceProyecto->save();

        $this->cantidad_mutuo = "";
        $this->forma_pago_mutuo = "";
        $this->tiempo_mutuo = "";

        return $this->dispatchBrowserEvent('cerrar-modal-registrar-mutuos', "Informacion registrada");
    }

    public $id_Abogado;
    public $numero_de_escritura;
    public $volumen;
    public $avatarAbogado;
    public $nombreAbogado;
    public $apaternoAbogado;
    public $amaternoAbogado;
    public $generoAbogado;
    public $telefonoAbogado;
    public $emailAbogado;
    public $fecha_nacimientoAbogado;

    public function editarProyecto($id){
        $proyecto = ModelsProyectos::find($id);
        $this->proyecto_id = $id;
        $this->numero_de_escritura = $proyecto->numero_escritura;
        $this->volumen = $proyecto->volumen;
        $this->id_Abogado = $proyecto->usuario_id;
        $this->avatarAbogado = $proyecto->abogado->user_image;
        $this->nombreAbogado = $proyecto->abogado->nombre;
        $this->apaternoAbogado = $proyecto->abogado->apaterno;
        $this->amaternoAbogado = $proyecto->abogado->amaterno;
        $this->generoAbogado = $proyecto->abogado->genero;
        $this->telefonoAbogado = $proyecto->abogado->telefono;
        $this->emailAbogado = $proyecto->abogado->email;
        $this->fecha_nacimientoAbogado = $proyecto->abogado->fecha_nacimiento;
        $this->servicio_id = $proyecto->servicio_id;
        return $this->dispatchBrowserEvent('abrir-modal-nuevo-proyecto-clientes');
    }

    public function guardarProyecto(){
        $this->validate([
            "numero_de_escritura" => "required|unique:proyectos,numero_escritura," . $this->proyecto_id,
            "volumen" => "required",
        ]);

        $proyecto = ModelsProyectos::find($this->proyecto_id);
        $proyecto->numero_escritura = $this->numero_de_escritura;
        $proyecto->volumen = $this->volumen;
        $proyecto->servicio_id = $this->servicio_id;
        $proyecto->save();
        $this->firebase($this->proyecto_id);
        return $this->dispatchBrowserEvent('cerrar-modal-nuevo-proyecto-clientes', "Registro editado");
    }

    public function cambiar_documento_escritura($id){
        $documento = Documentos::find($id);
        $this->proyecto_id = $documento->proyecto_id;
        $this->document_id = $id;
        $this->dispatchBrowserEvent('cerrar-modal-proyecto-temp');
        return $this->dispatchBrowserEvent('abrir-modal-editar-documentos');
    }

    public $qrData = "Sin informacion";

    public function generarQr($id){
        $proyecto = ModelsProyectos::find($id);
        $this->qrData = $proyecto->servicio->nombre;
        return $this->dispatchBrowserEvent('abrir-modal-generar-qr');
    }

    public $avividad_vulnerable = false;
    public $avividad_vulnerable_id;

    public function actividadvulnerable($id){
        $proyecto = ModelsProyectos::find($id);
        $this->proyecto_id = $proyecto->id;
        if(isset($proyecto->activiadVulnerable->id)){
            $this->avividad_vulnerable_id = $proyecto->activiadVulnerable->id;
            $this->avividad_vulnerable = $proyecto->activiadVulnerable->activo;
        }
        return $this->dispatchBrowserEvent('abrir-modal-registrar-actividad-vulnerable');
    }

    public function guardarActividadVulnerable(){
        if($this->avividad_vulnerable_id == ''){
            $actividad = new ActividadVulnerable;
            $actividad->proyecto_id = $this->proyecto_id;
            $actividad->activo = $this->avividad_vulnerable != '' ? 1 : 0;
            $actividad->save();
            return $this->dispatchBrowserEvent('cerrar-modal-registrar-actividad-vulnerable', "Actividad registrada");
        }

        $actividad = ActividadVulnerable::find($this->avividad_vulnerable_id);
        $actividad->activo = $this->avividad_vulnerable ? 1 : 0;
        $actividad->save();
        return $this->dispatchBrowserEvent('cerrar-modal-registrar-actividad-vulnerable', "Actividad editada");
    }

    public function clearActividad(){
        $this->avividad_vulnerable = false;
        $this->avividad_vulnerable_id = '';
    }
}

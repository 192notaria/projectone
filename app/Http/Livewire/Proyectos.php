<?php

namespace App\Http\Livewire;

use App\Models\ApoyoProyectos;
use App\Models\AutorizacionCatastro;
use App\Models\AvanceProyecto;
use App\Models\Clientes;
use App\Models\Documentos;
use App\Models\Firmas;
use App\Models\Generales;
use App\Models\Observaciones;
use App\Models\ProcesosServicios;
use App\Models\Proyectos as ModelsProyectos;
use App\Models\RegistroFirmas;
use App\Models\Servicios;
use App\Models\Subprocesos;
use App\Models\SubprocesosCatalogos;
use App\Models\User;
use DateTime;
use Livewire\Component;
use Livewire\WithFileUploads;
use NumberFormatter;
use PhpOffice\PhpWord\TemplateProcessor;
use Kreait\Firebase\Contract\Database;


class Proyectos extends Component
{
    use WithFileUploads;

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

    public $cantidadProyectos = 10;

    public function render(){
        return view('livewire.proyectos',[
            // "proyectos" => ModelsProyectos::orderBy("created_at", "ASC")->paginate($this->cantidadProyectos),
            "compradores" => $this->buscarComprador == "" ? [] : Clientes::where('nombre', 'LIKE', '%' . $this->buscarComprador . '%')
                ->orWhere('apaterno', 'LIKE', '%' . $this->buscarComprador . '%')
                ->orWhere('amaterno', 'LIKE', '%' . $this->buscarComprador . '%')
                ->get(),
            "clientes" => $this->buscarCliente == "" ? [] : Clientes::where('nombre', 'LIKE', '%' . $this->buscarCliente . '%')
                ->orWhere('apaterno', 'LIKE', '%' . $this->buscarCliente . '%')
                ->orWhere('amaterno', 'LIKE', '%' . $this->buscarCliente . '%')
                ->get(),

            "proyectos" => ModelsProyectos::orderBy("created_at", "ASC")
                ->whereHas('cliente', function($q){
                    $q->where('nombre', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('apaterno', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('amaterno', 'LIKE', '%' . $this->search . '%');
                })
                ->orWhereHas('servicio', function($serv){
                    $serv->where('nombre', 'LIKE', '%' . $this->search . '%');
                })
                ->paginate($this->cantidadProyectos),

            "servicios" => Servicios::orderBy("nombre", "ASC")->get(),
            "abogados" => $this->buscarAbogado == "" ? [] : User::where('name', 'LIKE', '%' . $this->buscarAbogado . '%')
                ->whereHas("roles", function($data){
                    $data->where('name', "ABOGADO");
                })->get(),
            "abogados_apoyo" => $this->buscarAbogado == "" ? [] : User::where('name', 'LIKE', '%' . $this->buscarAbogado . '%')
                ->whereHas("roles", function($data){
                    $data->where('name', "ABOGADO DE APOYO");
                })->get()
        ]);
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

    public function avanzar($proyecto, $procesos, $servicio){
        $this->proyecto_id = $proyecto;
        $this->servicio = $servicio;
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
                    $this->openModal();
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
                $this->openModal();
            }
        } while ($avance == true);
    }

    public function registrarAsignacion(){
        $this->validate([
            'acta_nac' => 'required|mimes:pdf|max:20000',
            'acta_matrimonio' => 'required|mimes:pdf|max:20000',
            'curp' => 'required|mimes:pdf|max:20000',
            'rfc' => 'required|mimes:pdf|max:20000',
            'identificacion_oficial' => 'required|mimes:pdf|max:20000',
            'comprobante_domicilio' => 'required|mimes:pdf|max:20000',
        ]);

        $proyecto = ModelsProyectos::find($this->proyecto_id);

        $generales = new Generales;
        $generales->cliente_id = $this->tipoGenerales['id'];
        $generales->proyecto_id = $this->proyecto_id;
        $generales->tipo = $this->subprocesoActual->nombre;

        $route = "uploads/proyectos/" . $proyecto->cliente->nombre . "_" . $proyecto->cliente->apaterno . "_" . $proyecto->cliente->amaterno . "/" . $this->servicio['nombre'] . "_" . $this->servicio['id'] . "/" . strtoupper(str_replace(" ", "_", $this->subprocesoActual->nombre)) . "_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'];
        if($this->acta_nac != ""){
            $FileName_acta_nac = "ACTA_NACIMIENTO_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." . $this->acta_nac->extension();
            $acta_nacRoute = $this->acta_nac->storeAs($route, $FileName_acta_nac);
            $generales->acta_nacimiento = $acta_nacRoute;
        }
        if($this->acta_matrimonio != ""){
            $FileName_acta_matrimonio = "ACTA_Matrimonio_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->acta_matrimonio->extension();
            $acta_matrimonioRoute = $this->acta_matrimonio->storeAs($route, $FileName_acta_matrimonio);
            $generales->acta_matrimonio = $acta_matrimonioRoute;
        }
        if($this->curp != ""){
            $FileName_curp = "CURP_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->curp->extension();
            $curpRoute = $this->curp->storeAs($route, $FileName_curp);
            $generales->curp = $curpRoute;
        }
        if($this->rfc != ""){
            $FileName_rfc = "RFC_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->rfc->extension();
            $rfcRoute = $this->rfc->storeAs($route, $FileName_rfc);
            $generales->rfc = $rfcRoute;
        }
        if($this->identificacion_oficial != ""){
            $FileName_identificacion_oficial = "Acta_nacimiento_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->identificacion_oficial->extension();
            $identificacion_oficialRoute = $this->identificacion_oficial->storeAs($route, $FileName_identificacion_oficial);
            $generales->identificacion_oficial_con_foto = $identificacion_oficialRoute;
        }
        if($this->comprobante_domicilio != ""){
            $FileName_comprobante_domicilio = "Acta_nacimiento_" . $this->tipoGenerales['nombre'] . "_" . $this->tipoGenerales['apaterno'] . "_" . $this->tipoGenerales['amaterno'] . "." .  $this->comprobante_domicilio->extension();
            $comprobante_domicilioRoute = $this->comprobante_domicilio->storeAs($route, $FileName_comprobante_domicilio);
            $generales->comprobante_domicilio = $comprobante_domicilioRoute;
        }

        // if($tipo == "vendedor"){

        // }else{
        //     $route = "uploads/proyectos/" . $proyecto->cliente->nombre . "_" . $proyecto->cliente->apaterno . "_" . $proyecto->cliente->amaterno . "/" . $this->servicio['nombre'] . "_" . $this->servicio['id'] . "/" . "COMPRADOR_" . $this->comprador['nombre'] . "_" . $this->comprador['apaterno'] . "_" . $this->comprador['amaterno'];
        //     $FileName_acta_nac = "ACTA_NACIMIENTO_" . $this->comprador['nombre'] . "_" . $this->comprador['apaterno'] . "_" . $this->comprador['amaterno'] . "." . $this->acta_nac->extension();
        //     $FileName_acta_matrimonio = "ACTA_Matrimonio_" . $this->comprador['nombre'] . "_" . $this->comprador['apaterno'] . "_" . $this->comprador['amaterno'] . "." .  $this->acta_matrimonio->extension();
        //     $FileName_curp = "CURP_" . $this->comprador['nombre'] . "_" . $this->comprador['apaterno'] . "_" . $this->comprador['amaterno'] . "." .  $this->curp->extension();
        //     $FileName_rfc = "RFC_" . $this->comprador['nombre'] . "_" . $this->comprador['apaterno'] . "_" . $this->comprador['amaterno'] . "." .  $this->rfc->extension();
        //     $FileName_identificacion_oficial = "Acta_nacimiento_" . $this->comprador['nombre'] . "_" . $this->comprador['apaterno'] . "_" . $this->comprador['amaterno'] . "." .  $this->identificacion_oficial->extension();
        //     $FileName_comprobante_domicilio = "Acta_nacimiento_" . $this->comprador['nombre'] . "_" . $this->comprador['apaterno'] . "_" . $this->comprador['amaterno'] . "." .  $this->comprobante_domicilio->extension();
        // }

        $generales->save();

        $avanceProyecto = new AvanceProyecto;
        $avanceProyecto->proyecto_id = $this->proyecto_id;
        $avanceProyecto->proceso_id = $this->procesoActual['id'];
        $avanceProyecto->subproceso_id = $this->subprocesoActual['id'];
        $avanceProyecto->save();
        $this->closeModal();
        $this->firebase($this->proyecto_id);
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
        $this->firebase($this->proyecto_id);
    }

    public function uploadDocument($documentName){
        $this->validate([
            "documentFile" => "required|mimes:pdf"
        ]);

        $proyecto = ModelsProyectos::find($this->proyecto_id);
        $route = "uploads/proyectos/" . $proyecto->cliente->nombre . "_" . $proyecto->cliente->apaterno . "_" . $proyecto->cliente->amaterno . "/" . $this->servicio['nombre'] . "_" . $this->servicio['id'] . "/documentos";
        $fileName = strtoupper(str_replace(" ", "_", $documentName)) . "." . $this->documentFile->extension();
        $uploadData = $this->documentFile->storeAs($route, $fileName);

        $newdocument = new Documentos;
        $newdocument->nombre = $documentName;
        $newdocument->storage = $uploadData;
        $newdocument->cliente_id = $proyecto->cliente->id;
        $newdocument->proyecto_id = $proyecto->id;
        $newdocument->save();

        $avanceProyecto = new AvanceProyecto;
        $avanceProyecto->proyecto_id = $this->proyecto_id;
        $avanceProyecto->proceso_id = $this->procesoActual['id'];
        $avanceProyecto->subproceso_id = $this->subprocesoActual['id'];
        $avanceProyecto->save();

        $this->closeModal();
        $this->firebase($this->proyecto_id);
    }



    public function agendarfecha(){
        $proyecto = ModelsProyectos::find($this->proyecto_id);

        $newfirma = new Firmas;
        $newfirma->nombre = $proyecto->servicio->nombre;
        $newfirma->fecha_inicio = $this->fechayhoraInput;
        $newfirma->fecha_fin = $this->fechayhoraInput;
        $newfirma->proceso_id = $this->procesoActual['id'];
        $newfirma->cliente_id = $proyecto->cliente->id;;
        $newfirma->proyecto_id = $proyecto->id;
        $newfirma->save();

        $avanceProyecto = new AvanceProyecto;
        $avanceProyecto->proyecto_id = $this->proyecto_id;
        $avanceProyecto->proceso_id = $this->procesoActual['id'];
        $avanceProyecto->subproceso_id = $this->subprocesoActual['id'];
        $avanceProyecto->save();

        $this->closeModal();
        $this->firebase($this->proyecto_id);
        // $agregarMinutos = strtotime('+' . $proyecto->servicio->tiempo_firma . ' minute', strtotime($this->fechayhoraInput));
        // $agregarMinutos = date("Y-m-d H:i:s", $agregarMinutos);

        // $buscarFirmas = Firmas::where('fecha_inicio', 'LIKE', '%' . date("Y-m-d", strtotime($this->fechayhoraInput)) . '%')
        //     ->get();
        // $firmasignada = false;
        // $i = 0;
        // $errorMessage = "";

        // if(count($buscarFirmas) > 0){
        //     do {
        //         $firmas = $buscarFirmas[$i];
        //         $firstCheck = $this->checkTimeRange(date("H:i", strtotime($firmas['fecha_inicio'])), date("H:i", strtotime($firmas['fecha_fin'])), date("H:i", strtotime($this->fechayhoraInput)));
        //         $secondCheck = $this->checkTimeRange(date("H:i", strtotime($firmas['fecha_inicio'])), date("H:i", strtotime($firmas['fecha_fin'])), date("H:i", strtotime($agregarMinutos)));
        //         // dd($firstCheck, $secondCheck);
        //         if($firstCheck == true || $secondCheck == true){
        //             $firmasignada = true;
        //             $errorMessage = "Esta fecha y hora no esta disponible ya que existe una firma para " . $firmas['nombre'] . " de " . date("H:i", strtotime($firmas['fecha_inicio'])) . " a " . date("H:i", strtotime($firmas['fecha_fin']));
        //         }else{
        //             if($i == count($buscarFirmas) -1){
        //                 $firmasignada = true;
        //             }else{
        //                 $i++;
        //             }
        //         }
        //     } while ($firmasignada == false);
        // }

        // if($firmasignada){
        //     return $this->addError('invalidDate', $errorMessage);
        // }


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

        $this->closeModal();
        $this->firebase($this->proyecto_id);
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

        $this->closeModal();
        $this->firebase($this->proyecto_id);
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
            $this->database->getReference($proyecto->cliente->nombre . " " . $proyecto->cliente->apaterno . " " . $proyecto->cliente->amaterno . "/" .$proyecto->servicio->nombre . "_" . $proyecto->servicio->id)
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
            'tituloObservacion' => 'required|max:50',
            'descripcionObservacion' => 'required|max:100',
            'imgobservacion' => 'image',
        ]);

        $newobservacion = new Observaciones();
        $newobservacion->titulo = $this->tituloObservacion;
        $newobservacion->descripcion = $this->descripcionObservacion;

        if($this->imgobservacion != ""){
            $route = "uploads/img/observaciones";
            $filename = "Observacion_" . $this->proyecto_id . "_" . time() . "." . $this->imgobservacion->extension();
            $imgpath = $this->imgobservacion->storeAs($route, $filename, 'public');
            $newobservacion->img_path = $imgpath;
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
}

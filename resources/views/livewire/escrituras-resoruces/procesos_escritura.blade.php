<div wire:ignore.self class="modal fade modal-procesos-escritura" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <ul>
                    <li>Acto: {{$proyecto_activo->servicio->nombre ?? "S/S"}}</li>
                    <li>Cliente: {{$proyecto_activo->cliente->nombre ?? ""}} {{$proyecto_activo->cliente->apaterno ?? ""}} {{$proyecto_activo->cliente->amaterno ?? ""}}</li>
                    <li>Numero de Escritura: {{$proyecto_activo->numero_escritura ?? "S/N"}}</li>
                </ul>
            </div>
            <div class="modal-header">
                <div class="simple-tab">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @can('ver-avance-proyecto')
                            <li class="nav-item" role="presentation">
                                <button wire:ignore.self class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Avance</button>
                            </li>
                        @endcan
                        @can('ver-general-proyecto')
                            <li class="nav-item" role="presentation">
                                <button wire:ignore.self class="nav-link" id="general-tab" data-bs-toggle="tab" data-bs-target="#general-tab-pane" type="button" role="tab" aria-controls="general-tab-pane" aria-selected="false">General</button>
                            </li>
                        @endcan
                        @can('ver-anticipos-proyecto')
                            <li class="nav-item" role="presentation">
                                <button wire:ignore.self class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Anticipos</button>
                            </li>
                        @endcan
                        @can('ver-facturas-proyecto')
                            <li class="nav-item" role="presentation">
                                <button wire:ignore.self class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Facturas</button>
                            </li>
                        @endcan
                        @can('ver-comisiones-proyecto')
                            <li class="nav-item" role="presentation">
                                <button wire:ignore.self class="nav-link" id="comisiones-tab" data-bs-toggle="tab" data-bs-target="#comisiones-tab-pane" type="button" role="tab" aria-controls="comisiones-tab-pane" aria-selected="false">Comisiones</button>
                            </li>
                        @endcan
                        @can('ver-bitacora-proyecto')
                            <li class="nav-item" role="presentation">
                                <button wire:ignore.self class="nav-link" id="bitacora-tab" data-bs-toggle="tab" data-bs-target="#bitacora-tab-pane" type="button" role="tab" aria-controls="bitacora-tab-pane" aria-selected="false">Bitacora</button>
                            </li>
                        @endcan
                        @can('ver-partes-proyecto')
                            <li class="nav-item" role="presentation">
                                <button wire:ignore.self class="nav-link" id="partes-tab" data-bs-toggle="tab" data-bs-target="#partes-tab-pane" type="button" role="tab" aria-controls="partes-tab-pane" aria-selected="false">Partes</button>
                            </li>
                        @endcan
                        @can('ver-observaciones-proyecto')
                            <li class="nav-item" role="presentation">
                                <button wire:ignore.self class="nav-link" id="observaciones-tab" data-bs-toggle="tab" data-bs-target="#observaciones-tab-pane" type="button" role="tab" aria-controls="observaciones-tab-pane" aria-selected="false">Observaciones</button>
                            </li>
                        @endcan
                        @can('ver-documentos-proyecto')
                            <li class="nav-item" role="presentation">
                                <button wire:ignore.self class="nav-link" id="documentos-tab" data-bs-toggle="tab" data-bs-target="#documentos-tab-pane" type="button" role="tab" aria-controls="documentos-tab-pane" aria-selected="false">Documentos</button>
                            </li>
                        @endcan
                        @can('ver-qr')
                            <li class="nav-item" role="presentation">
                                <button wire:ignore.self class="nav-link" id="qr-tab" data-bs-toggle="tab" data-bs-target="#qr-tab-pane" type="button" role="tab" aria-controls="qr-tab-pane" aria-selected="false">QR</button>
                            </li>
                        @endcan
                    </ul>
                </div>
            </div>

            <style>
                .mysidenav {
                    height: auto;
                    padding-bottom: 20px;
                    width: 0;
                    position: fixed;
                    z-index: 1;
                    top: 50;
                    right: 0;
                    background-color: #191e3a;
                    overflow-x: hidden;
                    padding-top: 60px;
                    transition: 0.5s;
                    -webkit-box-shadow: -10px 12px 14px -8px rgba(0,0,0,0.75);
                    -moz-box-shadow: -10px 12px 14px -8px rgba(0,0,0,0.75);
                    box-shadow: -10px 12px 14px -8px rgba(0,0,0,0.75);
                }

                .mysidenav a {
                    padding: 8px 8px 8px 32px;
                    text-decoration: none;
                    font-size: 25px;
                    color: #818181;
                    display: block;
                    transition: 0.3s;
                }

                .mysidenav a:hover {
                    color: #f1f1f1;
                }

                .mysidenav .closebtn {
                    position: absolute;
                    top: 0;
                    right: 25px;
                    font-size: 20px;
                    margin-left: 50px;
                }

                #main {
                    transition: margin-left .5s;
                    padding: 20px;
                }

                @media screen and (max-height: 450px) {
                    .mysidenav {padding-top: 15px;}
                    .mysidenav a {font-size: 18px;}
                }
            </style>

            <div class="modal-body">
                <div wire:ignore.self id="mySidenav" class="mysidenav">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><i class="fa-solid fa-circle-xmark"></i></a>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 mt-1 mb-2">
                                <button wire:click='abrirModalNuevoCosto' style="width: 100%;" class="btn btn-info"><i class="fa-solid fa-circle-plus"></i> Agregar costo</button>
                            </div>
                            <div class="col-lg-12 mt-1 mb-4">
                                <div class="btn-group-vertical" role="group" aria-label="Vertical button group" style="width: 100%;">
                                    <button wire:click='abrirModalPagos({{$total_pago + $total_impuestos}})' type="button" class="btn btn-info"><i class="fa-solid fa-cash-register"></i> Registrar pago</button>
                                    <button wire:click='abrirModalEgresos' type="button" class="btn btn-info"><i class="fa-solid fa-money-bill-transfer"></i> Registrar egresos</button>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-between mb-2 mt-2">
                                    <span>Subtotal: </span>
                                    <span>${{number_format($total_pago, 2)}}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2 mt-2">
                                    <span>Impuestos: </span>
                                    <span>${{number_format($total_impuestos, 2)}}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2 mt-2">
                                    <span>Descuentos: </span>
                                    <span>${{number_format($proyecto_activo['descuento'] ?? 0, 2)}}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2 mt-2">
                                    <h5 class="text-white">Total:</h5>
                                    @php
                                        $costoTotal = 0;
                                        if(isset($proyecto_activo['descuento'])){
                                            $costoTotal = $total_pago + $total_impuestos - $proyecto_activo['descuento'];
                                        }
                                    @endphp
                                    <h5 class="text-white">${{number_format($costoTotal, 2)}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="simple-tab">
                    <div class="tab-content" id="myTabContent">
                        <div wire:ignore.self class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                            <div class="vertical-pill">
                                <div class="d-flex align-items-start">
                                    <div style="min-width: 20%; max-width: 20%;" class="nav flex-column align-items-start nav-pills me-2 bg-light-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        @foreach ($procesos_data as $key => $proceso)
                                            <button wire:click='subprocesosTimeline({{$proceso->id}})' style="width: 100%; text-align: left !important;" class="mb-1 nav-link @if($proceso->id == $proceso_activo) active bg-primary @endif">
                                                <span class="badge
                                                    @if($proceso->id == $proceso_activo) active
                                                        bg-light-info
                                                    @else
                                                        bg-light-success
                                                    @endif
                                                    ">{{$key + 1}}
                                                </span> {{$proceso->nombre}} <i style="font-size: 20px;" class="{{$proceso->icon}}"></i>

                                            </button>
                                        @endforeach
                                    </div>
                                    <div style="width: 100%; max-width: 80%;" class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active">
                                            @if (count($subprocesos_data) > 0)
                                                <div class="row">

                                                    <div class="col-lg-3">
                                                        @foreach ($subprocesos_data as $key => $sub)
                                                            <div class="mt-container mx-auto">
                                                                <div class="timeline-alter">
                                                                    <a href="#" wire:click='subprocesosData({{$sub->id}}, {{$key + 1}})'>
                                                                        <div class="item-timeline">
                                                                            <div class="t-usr-txt">
                                                                                <p @if($sub->avance($proyecto_id, $proceso_activo)) class="bg-success" @endif>
                                                                                    <span class="text-white">{{$key + 1}}</span>
                                                                                </p>
                                                                            </div>
                                                                            <div class="t-text">
                                                                                <p @if ($key + 1 == $active_sub) class="text-primary" @endif>
                                                                                    {{$sub->catalogosSubprocesos->nombre}}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <div class="col-lg-9">
                                                        {{-- {{$proyecto_activo->id}} - {{$proceso_activo}} - {{$subproceso_activo->id}}
                                                        <br>
                                                        {{$proyecto_activo->omitido($proyecto_activo->id, $proceso_activo, $subproceso_activo->subproceso_id)}} --}}
                                                        @if ($tipo_subproceso == 3)
                                                            @if (!$proyecto_activo->omitido($proyecto_activo->id, $proceso_activo, $subproceso_activo->subproceso_id))
                                                                @can("omitir-subproceso")
                                                                    <button wire:loading.attr="disabled" wire:click='open_moda_omitir' class="btn btn-danger mb-2"><i class="fa-solid fa-forward"></i> Omitir</button>
                                                                @endcan
                                                            @endif
                                                            @include('livewire.subprocesos-resource.autorizacion-catastro')
                                                        @endif
                                                        @if ($tipo_subproceso == 5)
                                                            @if (!$proyecto_activo->omitido($proyecto_activo->id, $proceso_activo, $subproceso_activo->subproceso_id))
                                                                @can("omitir-subproceso")
                                                                    <button wire:loading.attr="disabled" wire:click='open_moda_omitir' class="btn btn-danger mb-2"><i class="fa-solid fa-forward"></i> Omitir</button>
                                                                @endcan
                                                            @endif
                                                            @include('livewire.subprocesos-resource.agendar-firma')
                                                        @endif
                                                        @if ($tipo_subproceso == 6)
                                                            @if (!$proyecto_activo->omitido($proyecto_activo->id, $proceso_activo, $subproceso_activo->subproceso_id))
                                                                @can("omitir-subproceso")
                                                                    <button wire:loading.attr="disabled" wire:click='open_moda_omitir' class="btn btn-danger mb-2"><i class="fa-solid fa-forward"></i> Omitir</button>
                                                                @endcan
                                                            @endif
                                                            @include('livewire.subprocesos-resource.documentos-subprocesos')
                                                        @endif
                                                        @if ($tipo_subproceso == 8)
                                                            @if (!$proyecto_activo->omitido($proyecto_activo->id, $proceso_activo, $subproceso_activo->subproceso_id))
                                                                @can("omitir-subproceso")
                                                                    <button wire:loading.attr="disabled" wire:click='open_moda_omitir' class="btn btn-danger mb-2"><i class="fa-solid fa-forward"></i> Omitir</button>
                                                                @endcan
                                                            @endif
                                                            @include('livewire.subprocesos-resource.registrar-firma')
                                                        @endif
                                                        @if ($tipo_subproceso == 10)
                                                            @if (!$proyecto_activo->omitido($proyecto_activo->id, $proceso_activo, $subproceso_activo->subproceso_id))
                                                                @can("omitir-subproceso")
                                                                    <button wire:loading.attr="disabled" wire:click='open_moda_omitir' class="btn btn-danger mb-2"><i class="fa-solid fa-forward"></i> Omitir</button>
                                                                @endcan
                                                            @endif
                                                            @include('livewire.subprocesos-resource.recibos-pago')
                                                        @endif
                                                        @if ($tipo_subproceso == 19)
                                                            @if (!$proyecto_activo->omitido($proyecto_activo->id, $proceso_activo, $subproceso_activo->subproceso_id))
                                                                @can("omitir-subproceso")
                                                                    <button wire:loading.attr="disabled" wire:click='open_moda_omitir' class="btn btn-danger mb-2"><i class="fa-solid fa-forward"></i> Omitir</button>
                                                                @endcan
                                                            @endif
                                                            @include('livewire.subprocesos-resource.varios-generales')
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div wire:ignore.self class="tab-pane fade" id="general-tab-pane" role="tabpanel" aria-labelledby="general-tab" tabindex="0">
                            <div class="row">
                                @if ($proyecto_activo != [])
                                    @include('livewire.subprocesos-resource.generales-proyecto')
                                @endif
                            </div>
                        </div>
                        <div wire:ignore.self class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                            @include('livewire.subprocesos-resource.pagos')
                        </div>
                        <div wire:ignore.self class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                            @include('livewire.subprocesos-resource.facturas')
                        </div>
                        <div wire:ignore.self class="tab-pane fade" id="comisiones-tab-pane" role="tabpanel" aria-labelledby="comisiones-tab" tabindex="0">
                            @include('livewire.subprocesos-resource.comisiones')
                        </div>
                        <div wire:ignore.self class="tab-pane fade" id="bitacora-tab-pane" role="tabpanel" aria-labelledby="bitacora-tab" tabindex="0">
                            @include('livewire.subprocesos-resource.bitacora')
                        </div>
                        <div wire:ignore.self class="tab-pane fade" id="partes-tab-pane" role="tabpanel" aria-labelledby="partes-tab" tabindex="0">
                            @include('livewire.subprocesos-resource.partes')
                        </div>
                        <div wire:ignore.self class="tab-pane fade" id="observaciones-tab-pane" role="tabpanel" aria-labelledby="observaciones-tab" tabindex="0">
                            @include('livewire.subprocesos-resource.observaciones')
                        </div>
                        <div wire:ignore.self class="tab-pane fade" id="documentos-tab-pane" role="tabpanel" aria-labelledby="documentos-tab" tabindex="0">
                            @include('livewire.subprocesos-resource.documentos')
                        </div>
                        <div wire:ignore.self class="tab-pane fade" id="qr-tab-pane" role="tabpanel" aria-labelledby="qr-tab" tabindex="0">
                            @include('livewire.subprocesos-resource.qr')
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:loading.attr="disabled" wire:click='closeProcesos' class="btn btn-outline-danger" data-bs-dismiss="modal">
                    <i class="flaticon-cancel-12"></i> Cerrar
                </button>
                <button wire:loading.attr="disabled" wire:click='terminarProyecto' class="btn btn-outline-success">
                    <i class="fa-solid fa-circle-check"></i> Terminar Proyecto
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .snackbar-container{
        z-index: 100000;
    }
</style>

<script>
    window.addEventListener('abrir-modal-procesos-escritura', event => {
        $(".modal-procesos-escritura").modal("show")
    })

    window.addEventListener('cerrar-modal-procesos-escritura', event => {
        $(".modal-procesos-escritura").modal("hide")
    })

    window.addEventListener('remover-registro-generales', event => {
        var myAudio= document.createElement('audio')
        myAudio.src = "{{ url("/v3/src/assets/audio/notification.mp3") }}"
        myAudio.play()

        Snackbar.show({
            text: event.detail,
            actionTextColor: '#fff',
            backgroundColor: '#4261ee',
            pos: 'bottom-right',
            duration: 5000,
            actionText: '<i class="fa-solid fa-circle-xmark"></i>'
        })
    })

    window.addEventListener('registro-generales', event => {
        var myAudio= document.createElement('audio')
        myAudio.src = "{{ url("/v3/src/assets/audio/notification.mp3") }}"
        myAudio.play()

        Snackbar.show({
            text: event.detail,
            actionTextColor: '#fff',
            backgroundColor: '#4261ee',
            pos: 'bottom-right',
            duration: 5000,
            actionText: '<i class="fa-solid fa-circle-xmark"></i>'
        })
    })

    window.addEventListener('registrar-avance', event => {
        var myAudio= document.createElement('audio')
        myAudio.src = "{{ url("/v3/src/assets/audio/notification.mp3") }}"
        myAudio.play()

        Snackbar.show({
            text: event.detail,
            actionTextColor: '#fff',
            backgroundColor: '#4261ee',
            pos: 'bottom-right',
            duration: 5000,
            actionText: '<i class="fa-solid fa-circle-xmark"></i>'
        })
    })

    window.addEventListener('sin-generales-registrados', event => {
        var myAudio= document.createElement('audio')
        myAudio.src = "{{ url("/v3/src/assets/audio/notification.mp3") }}"
        myAudio.play()

        Snackbar.show({
            text: event.detail,
            actionTextColor: '#fff',
            backgroundColor: '#E75151',
            pos: 'top-center',
            duration: 5000,
            actionText: '<i class="fa-solid fa-circle-xmark"></i>'
        })
    })

    window.addEventListener('remover-documento-escritura', event => {
        var myAudio= document.createElement('audio')
        myAudio.src = "{{ url("/v3/src/assets/audio/notification.mp3") }}"
        myAudio.play()

        Snackbar.show({
            text: event.detail,
            actionTextColor: '#fff',
            backgroundColor: '#E75151',
            pos: 'top-center',
            duration: 5000,
            actionText: '<i class="fa-solid fa-circle-xmark"></i>'
        })
    })

    window.addEventListener('documento-invalido', event => {
        var myAudio= document.createElement('audio')
        myAudio.src = "{{ url("/v3/src/assets/audio/notification.mp3") }}"
        myAudio.play()

        Snackbar.show({
            text: event.detail,
            actionTextColor: '#fff',
            backgroundColor: '#E75151',
            pos: 'top-center',
            duration: 5000,
            actionText: '<i class="fa-solid fa-circle-xmark"></i>'
        })
    })

    window.addEventListener('documentacion-guardada', event => {
        var myAudio= document.createElement('audio')
        myAudio.src = "{{ url("/v3/src/assets/audio/notification.mp3") }}"
        myAudio.play()

        Snackbar.show({
            text: event.detail,
            actionTextColor: '#fff',
            backgroundColor: '#4261ee',
            pos: 'bottom-right',
            duration: 5000,
            actionText: '<i class="fa-solid fa-circle-xmark"></i>'
        })
    })

    // documentacion-no-guardada
    window.addEventListener('alert-error', event => {
        var myAudio= document.createElement('audio')
        myAudio.src = "{{ url("/v3/src/assets/audio/notification.mp3") }}"
        myAudio.play()

        Snackbar.show({
            text: event.detail,
            actionTextColor: '#fff',
            backgroundColor: '#E75151',
            pos: 'top-center',
            duration: 5000,
            actionText: '<i class="fa-solid fa-circle-xmark"></i>'
        })
    })

    window.addEventListener('open-side-box', event => {
        document.getElementById("mySidenav").style.width = "250px";
    })

    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
</script>

<div wire:ignore.self class="modal fade modal-escritura-detalles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="simple-tab">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button wire:ignore.self class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general-tab-pane" type="button" role="tab" aria-controls="general-tab-pane" aria-selected="false">General</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button wire:ignore.self class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Pagos</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button wire:ignore.self class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Facturas</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button wire:ignore.self class="nav-link" id="comisiones-tab" data-bs-toggle="tab" data-bs-target="#comisiones-tab-pane" type="button" role="tab" aria-controls="comisiones-tab-pane" aria-selected="false">Comisiones</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button wire:ignore.self class="nav-link" id="bitacora-tab" data-bs-toggle="tab" data-bs-target="#bitacora-tab-pane" type="button" role="tab" aria-controls="bitacora-tab-pane" aria-selected="false">Bitacora</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button wire:ignore.self class="nav-link" id="partes-tab" data-bs-toggle="tab" data-bs-target="#partes-tab-pane" type="button" role="tab" aria-controls="partes-tab-pane" aria-selected="false">Partes</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button wire:ignore.self class="nav-link" id="observaciones-tab" data-bs-toggle="tab" data-bs-target="#observaciones-tab-pane" type="button" role="tab" aria-controls="observaciones-tab-pane" aria-selected="false">Observaciones</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button wire:ignore.self class="nav-link" id="documentos-tab" data-bs-toggle="tab" data-bs-target="#documentos-tab-pane" type="button" role="tab" aria-controls="documentos-tab-pane" aria-selected="false">Documentos</button>
                        </li>
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
                                    <span>${{number_format($escritura_activa['descuento'] ?? 0, 2)}}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2 mt-2">
                                    <h5 class="text-white">Total:</h5>
                                    @php
                                        $costoTotal = 0;
                                        if(isset($escritura_activa['descuento'])){
                                            $costoTotal = $total_pago + $total_impuestos - $escritura_activa['descuento'];
                                        }
                                    @endphp
                                    <h5 class="text-white">${{number_format($costoTotal, 2)}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($escritura_activa)
                    <div class="simple-tab">
                        <div class="tab-content" id="myTabContent">
                            <div wire:ignore.self class="tab-pane show active fade" id="general-tab-pane" role="tabpanel" aria-labelledby="general-tab" tabindex="0">
                                <div class="row">
                                    @include('livewire.escritura_resources.tabs.general')
                                </div>
                            </div>
                            <div wire:ignore.self class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                @include('livewire.escritura_resources.tabs.pagos')
                            </div>
                            <div wire:ignore.self class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                                @include('livewire.escritura_resources.tabs.facturas')
                            </div>
                            <div wire:ignore.self class="tab-pane fade" id="comisiones-tab-pane" role="tabpanel" aria-labelledby="comisiones-tab" tabindex="0">
                                {{-- @include('livewire.subprocesos-resource.comisiones') --}}
                            </div>
                            <div wire:ignore.self class="tab-pane fade" id="bitacora-tab-pane" role="tabpanel" aria-labelledby="bitacora-tab" tabindex="0">
                                {{-- @include('livewire.subprocesos-resource.bitacora') --}}
                            </div>
                            <div wire:ignore.self class="tab-pane fade" id="partes-tab-pane" role="tabpanel" aria-labelledby="partes-tab" tabindex="0">
                                {{-- @include('livewire.subprocesos-resource.partes') --}}
                            </div>
                            <div wire:ignore.self class="tab-pane fade" id="observaciones-tab-pane" role="tabpanel" aria-labelledby="observaciones-tab" tabindex="0">
                                {{-- @include('livewire.subprocesos-resource.observaciones') --}}
                            </div>
                            <div wire:ignore.self class="tab-pane fade" id="documentos-tab-pane" role="tabpanel" aria-labelledby="documentos-tab" tabindex="0">
                                {{-- @include('livewire.subprocesos-resource.documentos') --}}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-danger" data-bs-dismiss="modal">
                    <i class="flaticon-cancel-12"></i> Cerrar
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
    window.addEventListener('abrir-modal-escritura-detalles', event => {
        $(".modal-escritura-detalles").modal("show")
    })

    window.addEventListener('cerrar-modal-escritura-detalles', event => {
        $(".modal-escritura-detalles").modal("hide")
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

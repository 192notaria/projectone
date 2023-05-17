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
                @if ($escritura_activa)
                    <div class="simple-tab">
                        <div class="tab-content" id="myTabContent">
                            <div wire:ignore.self class="tab-pane show active fade" id="general-tab-pane" role="tabpanel" aria-labelledby="general-tab" tabindex="0">
                                <div class="row">
                                    @include('livewire.escritura_resources.tabs.general')
                                </div>
                            </div>
                            <div wire:ignore.self class="tab-pane fade" id="bitacora-tab-pane" role="tabpanel" aria-labelledby="bitacora-tab" tabindex="0">
                                @include("livewire.escritura_resources.bitacora")
                            </div>
                            <div wire:ignore.self class="tab-pane fade" id="partes-tab-pane" role="tabpanel" aria-labelledby="partes-tab" tabindex="0">
                                @include('livewire.escritura_resources.partes')
                            </div>
                            <div wire:ignore.self class="tab-pane fade" id="observaciones-tab-pane" role="tabpanel" aria-labelledby="observaciones-tab" tabindex="0">
                                @include('livewire.escritura_resources.observaciones')
                            </div>
                            <div wire:ignore.self class="tab-pane fade" id="documentos-tab-pane" role="tabpanel" aria-labelledby="documentos-tab" tabindex="0">
                                @include('livewire.escritura_resources.documentos')
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

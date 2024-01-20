<div class="row gx-3 gy-3">

    @if ($proyecto_activo)
        @if (isset($proyecto_activo->recibos_archivo->path))
            <div class="col-lg-12">
                <a href="/{{$proyecto_activo->recibos_archivo->path}}" target="_blank">
                    <div class="card bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Ver recibo <i class="fa-solid fa-file-arrow-down"></i></h5>
                            <p class="mb-0 text-white">Visualice el recibo importado al archivar el expediente</p>
                        </div>
                    </div>
                </a>
            </div>
        @else
            <div class="col-lg-6">
                <a href="#" wire:click='recibo_archivo'>
                    <div class="card bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Descargar recibo <i class="fa-solid fa-file-arrow-down"></i></h5>
                            <p class="mb-0 text-white">Descargue el recibo que contendra la infromación de la persona que entrega el expediente</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-6">
                <a href="#" wire:click='abrirModalArchivar'>
                    <div class="card bg-danger">
                        <div class="card-body">
                            <h5 class="card-title">Archivar <i class="fa-solid fa-box-archive"></i></h5>
                            <p class="mb-0 text-white">Registra el proceso de archivo de documentacion fisica</p>
                        </div>
                    </div>
                </a>
            </div>
        @endif
    @endif

</div>

<div wire:ignore.self class="modal fade modal-archivar"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Achivar</h5>
                <button wire:click='closeModal' type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <x-file-pond name="reciboArchivo" wire:model="reciboArchivo"
                        :options="['labelIdle' => 'Cargar un archivo... o arrastra y suelta. En formato PDF']">
                    </x-file-pond>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='cerrarModalArchivar' wire:loading.attr='disabled' class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button type="button" wire:click='archivarExpediente' wire:loading.attr='disabled' class="btn btn-outline-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
     window.addEventListener('abrir-modal-archivar', event => {
        $(".modal-archivar").modal("show")
    })

    window.addEventListener('cerrar-modal-archivar', event => {
        $(".modal-archivar").modal("hide")
    })
</script>

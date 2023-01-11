<div wire:ignore.self class="modal fade modal-registrar-autorizacion-catastro"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">{{$tituloModal}}</h5>
                <button wire:click='closeModal' type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 mt-2">
                            <label for="">Numero de comprobante</label>
                            <input wire:model='num_comprobante' type="text" class="form-control" placeholder="2021-2-123">
                            @error('num_comprobante') <span class="mt-3 badge badge-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-lg-12 mt-2">
                            <label for="">Cuenta predial</label>
                            <input wire:model='cuenta_predial' type="text" class="form-control" placeholder="1-123-2-123">
                            @error('cuenta_predial') <span class="mt-3 badge badge-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-lg-12 mt-2">
                            <label for="">Clave catastral</label>
                            <input wire:model='clave_catastral' type="text" class="form-control" placeholder="12-123-2-3-4-23-4-123-2-2">
                            @error('clave_catastral') <span class="mt-3 badge badge-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='closeModal' class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click='registrarAutorizacion' type="button" class="btn btn-outline-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-registrar-autorizacion-catastro', event => {
        $(".modal-registrar-autorizacion-catastro").modal("show")
    })

    window.addEventListener('cerrar-modal-registrar-autorizacion-catastro', event => {
        $(".modal-registrar-autorizacion-catastro").modal("hide")

        var myAudio= document.createElement('audio')
        myAudio.src = "{{ url("/v3/src/assets/audio/notification.mp3") }}"
        myAudio.play()

        Snackbar.show({
            text: event.detail,
            actionTextColor: '#fff',
            backgroundColor: '#00ab55',
            pos: 'top-center',
            duration: 5000,
            actionText: '<i class="fa-solid fa-circle-xmark"></i>'
        })
    })
</script>

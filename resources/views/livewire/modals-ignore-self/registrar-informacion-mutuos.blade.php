<div wire:ignore.self class="modal fade modal-registrar-mutuos"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
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
                        <div class="col-lg-6 mb-3">
                            <label for="">Cantidad</label>
                            <input type="number" class="form-control" wire:model='cantidad_mutuo'>
                            @error('cantidad_mutuo') <span class="mt-3 badge badge-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="">Forma de pago</label>
                            <input type="text" class="form-control" wire:model='forma_pago_mutuo'>
                            @error('forma_pago_mutuo') <span class="mt-3 badge badge-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="">Tiempo</label>
                            <input type="text" class="form-control" wire:model='tiempo_mutuo'>
                            @error('tiempo_mutuo') <span class="mt-3 badge badge-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='closeModal' class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click='registrarInfoMutuo' type="button" class="btn btn-outline-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-registrar-mutuos', event => {
        $(".modal-registrar-mutuos").modal("show")
    })

    window.addEventListener('cerrar-modal-registrar-mutuos', event => {
        $(".modal-registrar-mutuos").modal("hide")

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

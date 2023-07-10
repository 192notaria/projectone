<div wire:ignore.self class="modal fade modal-borrar-pago" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Borrar Pago</h5>
            </div>
            <div class="modal-body">
                <h4 class="text-danger">¿Esta seguro de borrar este pago?</h4>
            </div>
            <div class="modal-footer">
                <button wire:loading.attr="disabled" wire:click='borrar_pago' class="btn btn-outline-primary">Continuar</button>
                <button wire:loading.attr="disabled" wire:click='clear_inputs' class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-borrar-pago', event => {
        $(".modal-borrar-pago").modal("show")
    })

    window.addEventListener('cerrar-modal-borrar-pago', event => {
        $(".modal-borrar-pago").modal("hide")

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

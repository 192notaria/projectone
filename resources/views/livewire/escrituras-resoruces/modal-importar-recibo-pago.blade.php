<div wire:ignore.self class="modal fade modal-importar-recibo-pago"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Importar recibo de pago</h5>
            </div>
            <div class="modal-body">
                <div class="row gx-3 gy-3">
                    <div class="col-lg-12">
                        <label for="">Importar</label>
                        <x-file-pond wire:model='recibo_pdf'></x-file-pond>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="text-danger me-3" data-bs-dismiss="modal">Cancelar</a>
                <button wire:click='importar_recibo_pago' class="btn btn-outline-success">Importar</button>
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
    window.addEventListener('abrir-modal-importar-recibo-pago', event => {
        $(".modal-importar-recibo-pago").modal("show")
    })

    window.addEventListener('cerrar-modal-importar-recibo-pago', event => {
        $(".modal-importar-recibo-pago").modal("hide")

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

<div wire:ignore.self class="modal fade modal-registrar-observaciones"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Registrar observaciones</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 mb-2 mt-2">
                        <label for="">Observaciones</label>
                        <textarea wire:model='observaciones_proyecto' class="form-control" cols="30" rows="10" placeholder="Observaciones o comentarios acerca de este proyecto..."></textarea>
                        @error("observaciones_proyecto")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='registrar_observaciones' class="btn btn-outline-success">Guardar</button>
                <button wire:click='clearEgresos' class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>
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
    window.addEventListener('abrir-modal-registrar-observaciones', event => {
        $(".modal-registrar-observaciones").modal("show")
    })

    window.addEventListener('cerrar-modal-registrar-observaciones', event => {
        $(".modal-registrar-observaciones").modal("hide")

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

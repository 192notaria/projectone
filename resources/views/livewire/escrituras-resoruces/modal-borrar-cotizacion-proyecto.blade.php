<div wire:ignore.self class="modal fade modal-borrarCotizacionesRegistradas"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Borrar Cotización</h5>
            </div>
            <div class="modal-body">
                <div class="row gx-3 gy-3">
                    <div class="col-lg-12">
                        <h4 class="text-danger">Estas seguro de borrar esta cotizacion del proyecto</h4>
                        <p>La puedes agregar de nuevo en esta misma sección</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="text-primary me-3" data-bs-dismiss="modal">Cancelar</a>
                <button wire:click='borrarCotizacionProyecto' class="btn btn-outline-danger">Borrar</button>
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
    window.addEventListener('abrir-modal-borrarCotizacionesRegistradas', event => {
        $(".modal-borrarCotizacionesRegistradas").modal("show")
    })

    window.addEventListener('cerrar-modal-borrarCotizacionesRegistradas', event => {
        $(".modal-borrarCotizacionesRegistradas").modal("hide")

        // var myAudio= document.createElement('audio')
        // myAudio.src = "{{ url("/v3/src/assets/audio/notification.mp3") }}"
        // myAudio.play()

        // Snackbar.show({
        //     text: event.detail,
        //     actionTextColor: '#fff',
        //     backgroundColor: '#00ab55',
        //     pos: 'top-center',
        //     duration: 5000,
        //     actionText: '<i class="fa-solid fa-circle-xmark"></i>'
        // })
    })
</script>

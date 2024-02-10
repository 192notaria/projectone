<div wire:ignore.self class="modal fade modal-agregar-traslado-dominio"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Nuevo traslado de dominio</h5>
            </div>
            <div class="modal-body">
                <div class="row gx-3 gy-3">
                    <div class="col-lg-12">
                        <h4 class="text-danger">¿Estas seguro de agregar un nuevo traslado de dominio?</h4>
                        <p>Esta accion no se puede revertir</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="text-primary me-3" data-bs-dismiss="modal">Cancelar</a>
                <button wire:click='borrarCotizacionProyecto' class="btn btn-outline-danger">Continuar</button>
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
    window.addEventListener('abrir-modal-agregar-traslado-dominio', event => {
        $(".modal-agregar-traslado-dominio").modal("show")
    })

    window.addEventListener('cerrar-modal-agregar-traslado-dominio', event => {
        $(".modal-agregar-traslado-dominio").modal("hide")
    })
</script>

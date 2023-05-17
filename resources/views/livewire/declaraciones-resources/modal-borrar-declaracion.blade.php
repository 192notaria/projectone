<div wire:ignore.self class="modal fade modal-borrar-declaracion"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-between" style="width: 100%;">
                    <h5>Borrar Declaración</h5>
                </div>
            </div>
            <div class="modal-body">
                <div class="row gx-3 gy-3">
                    <div class="col-lg-12 text-danger">
                        <h4>¿Esta seguro de borrar esta declaración?</h4>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" data-bs-dismiss="modal" class="me-4">
                    Cancelar
                </a>
                <button wire:click='eliminar_declaracion' class="btn btn-danger" wire:click='registrar_declaracion'>
                    Borrar
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
    window.addEventListener('abrir-modal-borrar-declaracion', event => {
        $(".modal-borrar-declaracion").modal("show")
    })

    window.addEventListener('cerrar-modal-borrar-declaracion', event => {
        $(".modal-borrar-declaracion").modal("hide")
    })
</script>

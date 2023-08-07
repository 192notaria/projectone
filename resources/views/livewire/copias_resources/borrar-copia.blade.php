<div wire:ignore.self class="modal fade modal-eliminar-copia"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Eliminar Copia Certificada</h5>
            </div>
            <div class="modal-body">
                <div class="row gx-3 gy-3">
                    <h4 class="text-danger">¿Esta seguro de eliminar esta copia?</h4>
                    <p>Esta accion no se puede revertir</p>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="text-danger me-3" data-bs-dismiss="modal">Cancelar</a>
                <button wire:loading.attr='disabled' wire:click='borrar_copia' class="btn btn-outline-success">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-eliminar-copia', event => {
        $(".modal-eliminar-copia").modal("show")
    })

    window.addEventListener('cerrar-modal-eliminar-copia', event => {
        $(".modal-eliminar-copia").modal("hide")
    })
</script>

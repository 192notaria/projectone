<div wire:ignore.self class="modal fade modal-borrar-egreso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Borrar Egreso</h5>
            </div>
            <div class="modal-body">
                <h4 class="text-danger">¿Esta seguro de borrar este egreso?</h4>
            </div>
            <div class="modal-footer">
                <button wire:loading.attr="disabled" wire:click='borrar_egreso' class="btn btn-outline-primary">Continuar</button>
                <button wire:loading.attr="disabled" wire:click='clear_inputs' class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-borrar-egreso', event => {
        $(".modal-borrar-egreso").modal("show")
    })

    window.addEventListener('cerrar-modal-borrar-egreso', event => {
        $(".modal-borrar-egreso").modal("hide")
    })
</script>

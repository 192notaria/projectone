<div wire:ignore.self class="modal fade modal-omitir-subproceso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Omitir</h5>
            </div>
            <div class="modal-body">
                <h4 class="text-danger">¿Esta seguro que desea omitir este subproceso?</h4>
            </div>
            <div class="modal-footer">
                <button wire:click='omitir_subproceso' class="btn btn-outline-primary">Omitir</button>
                <button class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-omitir-subproceso', event => {
        $(".modal-omitir-subproceso").modal("show")
    })

    window.addEventListener('cerrar-modal-omitir-subproceso', event => {
        $(".modal-omitir-subproceso").modal("hide")
    })
</script>

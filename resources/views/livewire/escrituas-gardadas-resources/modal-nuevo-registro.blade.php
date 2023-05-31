<div wire:ignore.self class="modal fade modal-escrituras-guardadas" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row gy-3 gx-3">
                    <div class="col-lg-12">
                        <label for="">Número de escritura</label>
                        <input type="number" class="form-control" wire:model='numero_escritura'>
                    </div>
                    <div class="col-lg-12">
                        <label for="">Volumen</label>
                        <input type="number" class="form-control" wire:model='volumen'>
                    </div>
                    <div class="col-lg-6">
                        <label for="">Folio inicio</label>
                        <input type="number" class="form-control" wire:model='f_inicio'>
                    </div>
                    <div class="col-lg-6">
                        <label for="">Folio final</label>
                        <input type="number" class="form-control" wire:model='f_final'>
                    </div>
                    <div class="col-lg-12">
                        <label for="">Fecha escritura</label>
                        <input type="datetime-local" class="form-control" wire:model='fecha'>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" data-bs-dismiss="modal" class="me-3">Cerrar</a>
                <button wire:click='registrar' class="btn btn-outline-success" data-bs-dismiss="modal">Guardar</button>
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
    window.addEventListener('open-modal-escrituras-guardadas', event => {
        $(".modal-escrituras-guardadas").modal("show")
    })

    window.addEventListener('close-modal-escrituras-guardadas', event => {
        $(".modal-escrituras-guardadas").modal("hide")
    })
</script>

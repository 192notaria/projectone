<div wire:ignore.self class="modal fade modal-registrar-cliente"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Registrar cliente</h5>
            </div>
            <div class="modal-body">
                <div class="row gx-3 gy-3">
                    <div class="col-lg-12">
                        <label for="">Nombre</label>
                        <input type="text" class="form-control" wire:model='nombre'>
                    </div>
                    <div class="col-lg-12">
                        <label for="">Apellido Paterno</label>
                        <input type="text" class="form-control" wire:model='apaterno'>
                    </div>
                    <div class="col-lg-12">
                        <label for="">Apellido Materno</label>
                        <input type="text" class="form-control" wire:model='amaterno'>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="text-danger me-3" href="#" data-bs-dismiss="modal">Cerrar</a>
                <button wire:click='registrarCliente' class="btn btn-outline-success">Guardar</button>
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
    window.addEventListener('abrir-modal-registrar-cliente', event => {
        $(".modal-registrar-cliente").modal("show")
        new TomSelect('#tom-select-id');
    })

    window.addEventListener('cerrar-modal-registrar-cliente', event => {
        $(".modal-registrar-cliente").modal("hide")
    })
</script>

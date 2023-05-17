<div wire:ignore.self class="modal fade modal-crear-registro"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-between" style="width: 100%;">
                    <h5>Nuevo registro</h5>
                </div>
            </div>
            <div class="modal-body">
                <div class="row gx-3 gy-4">
                    <div class="col-lg-12">
                        <label for="">Nombre</label>
                        <input type="text" class="form-control" wire:model='nombre'>
                    </div>
                    <div class="col-lg-12">
                        <label for="">Descripción</label>
                        <textarea class="form-control" cols="30" rows="10" wire:model='descripcion'></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a wire:loading.remove data-bs-dismiss="modal" href="#" class="me-2">
                    Cerrar
                </a>
                <button wire:loading.remove wire:click='guardar_registro' class="btn btn-outline-success">
                    Guardar
                </button>
                <span wire:loading><div class="spinner-border text-success align-self-center "></div></span>
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
    window.addEventListener('abrir-modal-crear-registro', event => {
        $(".modal-crear-registro").modal("show")
    })

    window.addEventListener('cerrar-modal-crear-registro', event => {
        $(".modal-crear-registro").modal("hide")
    })
</script>

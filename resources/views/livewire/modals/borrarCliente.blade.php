<!-- Modal Domicilios-->
<div class="modal @if($modalBorrarCliente) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modalBorrarCliente) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modalBorrarCliente) aria-modal="true" @endif  @if(!$modalBorrarCliente) aria-hidden="true" @endif>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Borrar Cliente</h5>
                <button wire:click='closeModalBorrarCliente' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                    <i class="fa-solid fa-circle-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <span class="fw-bold text-primary">¿Esta seguro que desea borrar al cliente?</span><br>
                <span class="text-danger">Esta información no podra recuperarse</span>
            </div>
            <div class="modal-footer">
                <button wire:click='closeModalBorrarCliente' class="btn btn-outline-primary" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click='borrarCliente' type="button" class="btn btn-outline-danger">Borrar</button>
            </div>
        </div>
    </div>
</div>

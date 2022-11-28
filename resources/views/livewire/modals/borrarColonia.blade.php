<div class="modal @if($modalborrar) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modalborrar) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modalborrar) aria-modal="true" @endif  @if(!$modalborrar) aria-hidden="true" @endif>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Borrar Colonia</h5>
                <button wire:click='closeBorrarColonia' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                    <i class="fa-solid fa-circle-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <span class="fw-bold text-primary">¿Esta seguro que desea borrar esta Colonia?</span>
                <br>
                <span class="text-danger">Esta información no podra recuperarse</span>
            </div>
            <div class="modal-footer">
                <button wire:click='closeBorrarColonia' class="btn btn-outline-primary" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click='borrarColonia' type="button" class="btn btn-outline-danger">Borrar</button>
            </div>
        </div>
    </div>
</div>

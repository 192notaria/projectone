<div class="modal @if($modalAvance) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modalAvance) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modalAvance) aria-modal="true" @endif  @if(!$modalAvance) aria-hidden="true" @endif>
    <div class="modal-dialog modal-lg" role="document">
        <form wire:submit.prevent="agendarfecha">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$subprocesoActual->nombre}}</h5>
                    <button wire:click='closeModal' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="">Seleccione la fecha y hora para la entrega del proyecto</label>
                                <input wire:model='fechayhoraInput' type="datetime-local" class="form-control">
                                @error('invalidDate') <span class="mt-3 badge badge-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click='closeModal' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                    <button @if ($fechayhoraInput == "") disabled @endif type="submit" class="btn btn-outline-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

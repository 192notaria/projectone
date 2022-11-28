<div class="modal @if($modalAvance) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modalAvance) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modalAvance) aria-modal="true" @endif  @if(!$modalAvance) aria-hidden="true" @endif>
    <div class="modal-dialog modal-lg" role="document">
        <form wire:submit.prevent="registrarAutorizacion">
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
                            <div class="col-lg-12 mt-2">
                                <label for="">Numero de comprobante</label>
                                <input wire:model='num_comprobante' type="text" class="form-control" placeholder="2021-2-123">
                                @error('num_comprobante') <span class="mt-3 badge badge-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-lg-12 mt-2">
                                <label for="">Cuenta predial</label>
                                <input wire:model='cuenta_predial' type="text" class="form-control" placeholder="1-123-2-123">
                                @error('cuenta_predial') <span class="mt-3 badge badge-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-lg-12 mt-2">
                                <label for="">Clave catastral</label>
                                <input wire:model='clave_catastral' type="text" class="form-control" placeholder="12-123-2-3-4-23-4-123-2-2">
                                @error('clave_catastral') <span class="mt-3 badge badge-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click='closeModal' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                    <button
                        @if ($num_comprobante == "") disabled @endif
                        @if ($cuenta_predial == "") disabled @endif
                        @if ($clave_catastral == "") disabled @endif
                        type="submit" class="btn btn-outline-primary">Guardar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

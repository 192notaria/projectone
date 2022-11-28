
    <div class="modal @if($modalNuevo) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modalNuevo) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modalNuevo) aria-modal="true" @endif  @if(!$modalNuevo) aria-hidden="true" @endif>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{$modalTittle}}</h5>
                    <button wire:click='closeModalNew' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="">Nombre del servicio</label>
                                <input wire:model='nombre_del_servicio' type="text" class="form-control" placeholder="Compraventas, Divorcios...">
                                @error('nombre_del_servicio') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-12 mt-4">
                            <div class="form-group">
                                <label for="">Tiempo para firma de proyecto (Minutos)</label>
                                <input wire:model='tiempo_firma' type="number" class="form-control" placeholder="Compraventas, Divorcios...">
                                @error('tiempo_firma') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click='closeModalNew' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                    <button wire:click='save' type="button" class="btn btn-outline-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

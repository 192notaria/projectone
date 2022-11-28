
    <!-- Modal Timeline-->
    <div class="modal @if($modalNewSubproceso) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modalNewSubproceso) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modalNewSubproceso) aria-modal="true" @endif  @if(!$modalNewSubproceso) aria-hidden="true" @endif>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo Subproceso</h5>
                    <button wire:click='closeModal' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Nombre del subproceso</label>
                            <input wire:model='nombresubproceso' type="text" class="form-control" placeholder="Subproceso...">
                            @error('nombresubproceso') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-lg-12">
                            <label for="">Tipo</label>
                            <select wire:model='tiposub' class="form-select">
                                <option value="" selected disabled>Seleccionar...</option>
                                @foreach ($tipos as $tipo)
                                    <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                @endforeach
                            </select>
                            @error('nombresubproceso') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click='closeModal' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                    <button wire:click='save' type="button" class="btn btn-outline-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

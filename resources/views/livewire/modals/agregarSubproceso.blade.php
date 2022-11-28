  <!-- Modal -->
  <div class="modal @if($modalSuprocesos) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modalSuprocesos) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modalSuprocesos) aria-modal="true" @endif  @if(!$modalSuprocesos) aria-hidden="true" @endif>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Asignar subproceso</h5>
                <button wire:click='closeModalSubprocesos' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                    <i class="fa-solid fa-circle-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <label for="">Subproceso</label>
                            <select class="form-select" wire:model='subproceso_id'>
                                <option value="" selected disabled>Seleccionar...</option>
                                @foreach ($catalogos_subprocesos as $sub)
                                    <option value="{{$sub->id}}">{{$sub->nombre}}</option>
                                @endforeach
                            </select>
                            @error('subproceso_id') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='closeModalSubprocesos' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click='saveSubprocess' type="button" class="btn btn-outline-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

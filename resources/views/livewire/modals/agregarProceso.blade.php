<div class="modal @if($modalProcesos) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modalProcesos) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modalProcesos) aria-modal="true" @endif  @if(!$modalProcesos) aria-hidden="true" @endif>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Proceso</h5>
                <button wire:click='closeModalProcesos' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                    <i class="fa-solid fa-circle-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <label for="">Proceso</label>
                            <select class="form-select" wire:model='proceso_servicio_id'>
                                <option value="" selected disabled>Seleccionar...</option>
                                @foreach ($procesos as $proceso)
                                    <option value="{{$proceso->id}}">{{$proceso->nombre}}</option>
                                @endforeach
                            </select>
                            @error('ExisteProceso') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='closeModalProcesos' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click='asignarProceso' type="button" class="btn btn-outline-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

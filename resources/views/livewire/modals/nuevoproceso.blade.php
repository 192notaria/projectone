
    <!-- Modal Timeline-->
    <div class="modal @if($modalNewProceso) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modalNewProceso) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modalNewProceso) aria-modal="true" @endif  @if(!$modalNewProceso) aria-hidden="true" @endif>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{$modalTittle}}</h5>
                    <button wire:click='closeModal' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Nombre del proceso</label>
                            <input wire:model='nombreProceso' type="text" class="form-control" placeholder="Proceso...">
                            @error('nombreProceso') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-lg-12">
                            <label for="">Icono</label>
                            <select wire:model='icondata' class="form-control">
                                <option value="" selected disabled>Seleccionar...</option>
                                @foreach ($icons as $icono)
                                    <option value="{{$icono->icon}}">
                                        {{$icono->icon}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click='closeModal' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                    <button wire:click='saveNewProcess' type="button" class="btn btn-outline-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

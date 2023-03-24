<div class="col-lg-12 mb-3">
    <div class="d-flex justify-content-between">
        <div>
            <button wire:click='cambiarVistaComision(0)' class="btn btn-danger"><i class="fa-solid fa-chevron-left"></i> Regresar</button>
            <button wire:click='registrarComision' class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
        </div>
        <div>
            <button wire:click='cambiarVistaComision(2)' class="btn btn-primary"><i class="fa-solid fa-user-secret"></i> Registrar Promotor</button>
        </div>
    </div>
</div>

<div class="col-lg-6 mb-3">
    <div class="form-group autocomplete">
        <label for="">Promotor</label>
        @if (!$promotor_asignado)
            <input wire:model='buscarPromotor' type="text" class="form-control" placeholder="Buscar...">
            @error('buscarPromotor')
                <span class="text-danger"{{$message}}></span>
            @enderror
            <div class="autocomplete-items">
                @foreach ($promotores as $promotor)
                    <a wire:click='asignarPromotor({{$promotor}})'>
                        <div>
                            <strong>
                                {{$promotor->nombre}} {{$promotor->apaterno}} {{$promotor->amaterno}}
                            </strong>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
        <br>
            <button class="btn btn-success position-relative mb-2 me-4">
                <span class="btn-text-inner">
                    {{$promotor_asignado['nombre']}} {{$promotor_asignado['apaterno']}} {{$promotor_asignado['amaterno']}}
                </span>
                <a wire:click='removerPromotor'>
                    <span class="badge badge-danger counter"><i class="fa-solid fa-xmark"></i></span>
                </a>
            </button>
        @endif
    </div>
</div>
<div class="col-lg-6 mb-3">
    <label for="">Cantidad</label>
    <input type="number" class="form-control" placeholder="Cantidad..." wire:model='cantidad_comision'>
    @error('cantidad_comision')
        <span class="text-danger"{{$message}}></span>
    @enderror
</div>
<div class="col-lg-12 mb-3">
    <label for="">Observaciones</label>
    <textarea class="form-control" cols="30" rows="10" wire:model='observaciones_comision'></textarea>
</div>

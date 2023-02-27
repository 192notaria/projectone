<div class="card">
    <div class="card-header">
        <h5>
            {{$subprocesos_info->nombre}}
            {{$subprocesos_info->tipo_id}}
            - {{$subproceso_activo->id}}

            @if ($subproceso_activo->avance($proyecto_id, $proceso_activo))
                <i class="fa-solid fa-circle-check text-success"></i>
            @endif
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            @if ($firmas)
                <div class="col-lg-12 mb-3">
                    <p>Fecha de inicio: <span class="badge badge-success">{{$firmas->fecha_inicio}}</span></p>
                    <p>Fecha de terminacion: <span class="badge badge-success">{{$firmas->fecha_fin}}</span></p>
                    @if (!$subproceso_activo->avance( $proyecto_id, $sub->proceso_id ))
                        <button wire:click='cancelarFirma({{$firmas->id}})' class="btn btn-danger">Cancelar Firma</button>
                    @endif
                </div>
            @else
                <div class="col-lg-12">
                    <input wire:model='fecha_firma' wire:change='agendarFirma' type="datetime-local" class="form-control">
                    @error('invalidDate')
                        <span class="badge badge-danger mt-3">{{$message}}</span>
                    @enderror
                </div>
                <div class="col-lg-12 mb-2 mt-2">
                    <button wire:click='guardarFechaFirma' class="btn btn-outline-success">Agendar Firma</button>
                </div>
            @endif
        </div>
    </div>
    <div class="card-footer">
        <div class="col-lg-12 mt-3">
            @if (!$subproceso_activo->avance( $proyecto_id, $sub->proceso_id ) && $firmas)
                <button wire:click='guardarAvance' class="btn btn-outline-success">Guardar avance</button>
            @endif
        </div>
    </div>
</div>

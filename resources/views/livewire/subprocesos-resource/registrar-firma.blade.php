<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>
            {{$subprocesos_info->nombre}}
            {{-- {{$subprocesos_info->tipo_id}}
            - {{$subproceso_activo->id}} --}}
            @if ($subproceso_activo->avance($proyecto_id, $proceso_activo))
                <i class="fa-solid fa-circle-check text-success"></i>
            @endif
        </h5>
        @if (!$proyecto_activo->omitido($proyecto_activo->id, $proceso_activo, $subproceso_activo->subproceso_id))
            @can("omitir-subproceso")
                <button wire:loading.attr="disabled" wire:click='open_moda_omitir' class="btn btn-danger mb-2"><i class="fa-solid fa-forward"></i> Omitir</button>
            @endcan
        @endif
    </div>
    <div class="card-body">
        <div class="row">
            @if($fechas_registradas)
                <div class="col-lg-12 mb-3">
                    Fecha de registro: <span class="btn btn-success">{{$fechas_registradas->fechayhora}}</span>
                </div>
            @endif
            @if (!$subproceso_activo->avance( $proyecto_id, $sub->proceso_id ))
                <div class="col-lg-12">
                    @if(!$fechas_registradas)
                        <input wire:model='fecha_a_registrar' type="datetime-local" class="form-control">
                    @endif
                    @error('fecha_a_registrar')
                        <span class="badge badge-danger mt-3">{{$message}}</span>
                    @enderror
                </div>
                <div class="col-lg-12 mb-2 mt-2">
                    @if(!$fechas_registradas)
                        <button wire:click='registrarFecha' class="btn btn-outline-success">Registrar Fecha</button>
                    @endif
                    @if($fechas_registradas)
                        <button class="btn btn-danger" wire:click='eliminarFecha({{$fechas_registradas->id}})'>Eliminar registro</button>
                    @endif
                </div>
            @endif
        </div>
    </div>
    <div class="card-footer">
        <div class="col-lg-12 mt-3">
            @if (!$subproceso_activo->avance( $proyecto_id, $sub->proceso_id ) && $fechas_registradas)
                <button wire:click='guardarAvance' class="btn btn-outline-success">
                    Guardar avance
                </button>
            @endif
        </div>
    </div>
</div>

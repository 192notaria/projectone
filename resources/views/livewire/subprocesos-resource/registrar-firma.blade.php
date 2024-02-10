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
            @if (!$subproceso_activo->avance( $proyecto_id, $sub->proceso_id ))
                <div class="col-lg-12">
                    <input wire:model='fecha_a_registrar' type="datetime-local" class="form-control">
                    @error('fecha_a_registrar')
                        <span class="badge badge-danger mt-3">{{$message}}</span>
                    @enderror
                </div>
                <div class="col-lg-12 mb-2 mt-2">
                    <button wire:click='registrarFecha' class="btn btn-outline-success">Agregar fecha</button>
                </div>
            @endif
            @if (count($fechas_registradas) > 0)
                <div class="col-lg-12 mt-2 table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Fecha y hora</th>
                                @if (!$subproceso_activo->avance( $proyecto_id, $sub->proceso_id ) && count($fechas_registradas) > 0)
                                    <th></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($fechas_registradas as $key => $fecha_data)
                                <tr>
                                    <td class="text-center">{{$key + 1}}</td>
                                    <td>{{$fecha_data->fechayhora}}</td>
                                    @if (!$subproceso_activo->avance( $proyecto_id, $sub->proceso_id ) && count($fechas_registradas) > 0)
                                        <td>
                                            <button class="btn btn-outline-dark" wire:click='eliminarFecha({{$fecha_data->id}})'>
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                        @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">Sin registros...</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    <div class="card-footer">
        <div class="col-lg-12 mt-3">
            @if (!$subproceso_activo->avance( $proyecto_id, $sub->proceso_id ) && count($fechas_registradas) > 0)
                <button wire:click='guardarAvance' class="btn btn-outline-success">
                    Guardar avance
                </button>
            @endif
        </div>
    </div>
</div>

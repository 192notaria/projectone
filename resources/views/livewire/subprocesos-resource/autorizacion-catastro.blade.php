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
            {{-- @if (!$autorizacion_catastro) --}}
            @if (!$subproceso_activo->avance($proyecto_id, $sub->proceso_id))
                <div class="col-lg-12 mb-2 mt-2">
                    <label for="">Numero de comprobante</label>
                    <input type="text" class="form-control" placeholder="2021-2-123" wire:model='numero_comprobante'>
                </div>
                <div class="col-lg-12 mb-2 mt-2">
                    <label for="">Cuenta predial</label>
                    <input type="text" class="form-control" placeholder="1-123-2-123" wire:model='cuenta_predial'>
                </div>
                <div class="col-lg-12 mb-2 mt-2">
                    <label for="">Clave catastral</label>
                    <input type="text" class="form-control" placeholder="12-123-2-3-4-23-4-123-2-2" wire:model='clave_catastral'>
                </div>
                <div class="col-lg-12 mb-2 mt-2">
                    <button wire:click='registrar_autorizacion' class="btn btn-outline-success">Agregar</button>
                </div>
            @endif
            {{-- @if ($autorizacion_catastro)
                @if (!$subproceso_activo->avance($proyecto_id, $sub->proceso_id ) && $autorizacion_catastro)
                    <div class="col-lg-12 mb-2 mt-2">
                        <button wire:click='borrar_autorizacion({{$autorizacion_catastro->id}})' class="btn btn-outline-danger">Borrar autorizacion</button>
                    </div>
                @endif
            @endif --}}
            @if (count($autorizacion_catastro) > 0)
                <div class="col-lg-12 mt-2 mb-2 table-responsive">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Número de comprobante</th>
                                <th>Cuenta predial</th>
                                <th>Clave catastral</th>
                                @if (!$subproceso_activo->avance($proyecto_id, $sub->proceso_id ) && count($autorizacion_catastro) > 0)
                                    <th></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($autorizacion_catastro as $key => $autorizacion)
                                <tr>
                                    <td class="text-center">{{$key + 1}}</td>
                                    <td>{{$autorizacion->comprobante}}</td>
                                    <td>{{$autorizacion->cuenta_predial}}</td>
                                    <td>{{$autorizacion->clave_catastral}}</td>
                                    @if (!$subproceso_activo->avance($proyecto_id, $sub->proceso_id ) && count($autorizacion_catastro) > 0)
                                        <td>
                                            <button class="btn btn-outline-dark" wire:click='borrar_autorizacion({{$autorizacion->id}})'>
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Sin registros...</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- <p>Numero de comprobante: <span class="badge badge-success">{{$autorizacion_catastro->comprobante}}</span></p>
                    <p>Cuenta predial: <span class="badge badge-success">{{$autorizacion_catastro->cuenta_predial}}</span></p>
                    <p>Clave catastral: <span class="badge badge-success">{{$autorizacion_catastro->clave_catastral}}</span></p> --}}
                </div>
            @endif
        </div>
    </div>
    <div class="card-footer">
        <div class="col-lg-12 mt-3">
            @if (!$subproceso_activo->avance($proyecto_id, $sub->proceso_id) && count($autorizacion_catastro) > 0)
                <button wire:click='guardarAvance' class="btn btn-outline-success">Guardar avance</button>
            @endif
        </div>
    </div>
</div>

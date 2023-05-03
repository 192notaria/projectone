<div class="card">
    <div class="card-header">
        <h5>
            {{$subprocesos_info->nombre}}
            {{-- {{$subprocesos_info->tipo_id}}
            - {{$subproceso_activo->id}} --}}

            @if ($subproceso_activo->avance($proyecto_id, $proceso_activo))
                <i class="fa-solid fa-circle-check text-success"></i>
            @endif
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            @if ($autorizacion_catastro)
                <div class="col-lg-12 mt-2 mb-2">
                    <p>Numero de comprobante: <span class="badge badge-success">{{$autorizacion_catastro->comprobante}}</span></p>
                    <p>Cuenta predial: <span class="badge badge-success">{{$autorizacion_catastro->cuenta_predial}}</span></p>
                    <p>Clave catastral: <span class="badge badge-success">{{$autorizacion_catastro->clave_catastral}}</span></p>
                </div>
            @endif
            @if (!$autorizacion_catastro)
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
                    <button wire:click='registrar_autorizacion' class="btn btn-outline-success">Guardar</button>
                </div>
            @endif
            @if ($autorizacion_catastro)
                @if (!$subproceso_activo->avance($proyecto_id, $sub->proceso_id ) && $autorizacion_catastro)
                    <div class="col-lg-12 mb-2 mt-2">
                        <button wire:click='borrar_autorizacion({{$autorizacion_catastro->id}})' class="btn btn-outline-danger">Borrar autorizacion</button>
                    </div>
                @endif
            @endif
        </div>
    </div>
    <div class="card-footer">
        <div class="col-lg-12 mt-3">
            @if (!$subproceso_activo->avance($proyecto_id, $sub->proceso_id ) && $autorizacion_catastro)
                <button wire:click='guardarAvance' class="btn btn-outline-success">Guardar avance</button>
            @endif
        </div>
    </div>
</div>

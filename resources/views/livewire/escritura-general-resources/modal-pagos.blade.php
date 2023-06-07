<div wire:ignore.self class="modal fade modal-pagos" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>
                    Detalles de cuenta
                </h5>
                <ul>
                    <li>Acto: <span class="fw-bold">{{$escritura_activa->servicio->nombre ?? ""}}</span></li>
                    <li>Numero de escritura: <span class="fw-bold">{{$escritura_activa->numero_escritura ?? "S/N"}}</span></li>
                    <li>Cliente: <span class="fw-bold">{{$escritura_activa->cliente->nombre ?? "S/N"}} {{$escritura_activa->cliente->apaterno ?? "S/N"}} {{$escritura_activa->cliente->amaterno ?? "S/N"}}</span></li>
                    <li>Fecha: <span class="fw-bold">{{$escritura_activa->created_at ?? "S/N"}}</span></li>
                </ul>
            </div>
            <div class="modal-body">
                <div class="row layout-top-spacing">
                    @can("ver-tarjetas-detalles-pagos")
                        @if ($escritura_activa)
                            <div class="col-xl-3 col-lg-6 col-md-6  mb-4">
                                <div class="card bg-primary">
                                    <div class="card-body pt-3">
                                        <h5 class="card-title mb-3">Costo total <a href="#" class="text-warning"><i class="fa-solid fa-pen-to-square"></i></a></h5>
                                        <h1 class="text-white">
                                            @if ($escritura_activa)
                                                ${{number_format($escritura_activa->total, 2)}}
                                            @endif
                                        </h1>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-6 col-md-6  mb-4">
                                <div class="card bg-success">
                                    <div class="card-body pt-3">
                                        <h5 class="card-title mb-3">Anticipos</h5>
                                        <h1 class="text-white">
                                            ${{number_format($escritura_activa->pagos_recibidos_total($escritura_activa->id), 2)}}
                                        </h1>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-6 col-md-6  mb-4">
                                <div class="card bg-warning">
                                    <div class="card-body pt-3">
                                        <h5 class="card-title mb-3">Egresos</h5>
                                        <h1 class="text-white">
                                            ${{number_format($escritura_activa->egresos_registrados($escritura_activa->id), 2)}}
                                        </h1>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-6 col-md-6  mb-4">
                                <div class="card
                                    @if ($escritura_activa->pagos_recibidos_total($escritura_activa->id) - $escritura_activa->egresos_registrados($escritura_activa->id) < 0)
                                        bg-danger
                                    @else
                                        bg-info
                                    @endif
                                ">
                                <div class="card-body pt-3">
                                    <h5 class="card-title mb-3">
                                        @if ($escritura_activa->pagos_recibidos_total($escritura_activa->id) - $escritura_activa->egresos_registrados($escritura_activa->id) < 0)
                                            Faltante
                                        @else
                                            Sobrante
                                        @endif
                                    </h5>
                                        <h1 class="text-white">
                                            ${{number_format($escritura_activa->pagos_recibidos_total($escritura_activa->id) - $escritura_activa->egresos_registrados($escritura_activa->id), 2)}}
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endcan

                    @can("ver-costos")
                        <div class="col-lg-12 col-md-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <div class="d-flex justify-content-between">
                                                <h4>Costos</h4>
                                                @can("crear-costo")
                                                    <button class="btn btn-primary" wire:click='abrir_registro_costos'>
                                                        <i class="fa-solid fa-plus"></i> Registrar costo
                                                    </button>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-4">
                                            <thead>
                                                <tr>
                                                    <th>Concepto</th>
                                                    <th>Costo</th>
                                                    <th>Gestoria</th>
                                                    <th>Impuestos</th>
                                                    <th>Total</th>
                                                    <th>Pagado</th>
                                                    <th>Egresos</th>
                                                    <th>Observaciones</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                                <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                                            </thead>
                                            <tbody>
                                                @if ($escritura_activa)
                                                    @forelse ($escritura_activa->costos_proyecto as $costo)
                                                        <tr>
                                                            <td>{{$costo->concepto_pago->descripcion}}</td>
                                                            <td class="text-center">${{number_format($costo->subtotal, 2)}}</td>
                                                            <td class="text-center">${{number_format($costo->gestoria, 2)}}</td>
                                                            <td class="text-center">
                                                                ${{number_format($costo->subtotal * $costo->impuestos / 100, 2)}}
                                                                <span class="text-primary">({{$costo->impuestos}}%)</span>
                                                            </td>
                                                            <td class="text-center">
                                                                ${{number_format($costo->subtotal + $costo->gestoria + $costo->subtotal * $costo->impuestos / 100, 2)}}
                                                            </td>
                                                            <td class="text-center">{!! isset($costo->egreso->monto) ? "$" . number_format($costo->egreso->monto + $costo->egreso->gestoria + $costo->egreso->impuestos , 2) : '<span class="text-danger">$0.0</span>' !!}</td>
                                                            <td class="text-center">{!! isset($costo->egreso->monto) ? "$" . number_format($costo->egreso->monto + $costo->egreso->gestoria + $costo->egreso->impuestos , 2) : '<span class="text-danger">$0.0</span>' !!}</td>
                                                            <td>{{$costo->observaciones ?? "Sin observaciones"}}</td>
                                                            <td class="text-center">
                                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                                    @can("editar-costo")
                                                                        <button wire:click='editar_costo({{$costo->id}})' type="button" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                                    @endcan
                                                                    @can("borrar-costo")
                                                                        <button wire:click='abrir_modal_borrar_costo({{$costo->id}})' type="button" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                                                    @endcan
                                                                    @if ($costo->concepto_pago->descripcion != "Honorarios")
                                                                        @if (!isset($costo->egreso->monto) && $costo->concepto_pago->categoria_gasto_id == 3)
                                                                        @can("crear-egreso")
                                                                            <button wire:click='abrir_registrar_egreso({{$costo->id}})' type="button" class="btn btn-success"><i class="fa-solid fa-money-bill-1-wave"></i></button>
                                                                        @endcan
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td>Sin registros...</td>
                                                        </tr>
                                                    @endforelse
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan

                    @can("ver-anticipos")
                        <div class="col-lg-12 col-md-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <div class="d-flex justify-content-between">
                                                <h4>Anticipos recibidos</h4>
                                                @can("registrar-anticipo")
                                                    <button wire:click='abrir_modal_pago' class="btn btn-primary"><i class="fa-solid fa-plus"></i> Registrar anticipo</button>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-4">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Recibido de:</th>
                                                    <th>Monto</th>
                                                    <th>Metodo de pago</th>
                                                    <th>Cuenta</th>
                                                    <th>Observaciones</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                                <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                                            </thead>
                                            <tbody>
                                                @if ($escritura_activa)
                                                    @forelse ($escritura_activa->pagos_recibidos as $pago)
                                                        <tr>
                                                            <td>{{$pago->fecha}}</td>
                                                            <td>{{$pago->cliente ?? $escritura_activa->cliente->nombre . " " . $escritura_activa->cliente->apaterno}}</td>
                                                            <td>${{number_format($pago->monto, 2)}}</td>
                                                            <td>{{$pago->metodo_pago->nombre}}</td>
                                                            <td>{{$pago->cuenta->numero_cuenta ?? "N/A"}}</td>
                                                            <td class="text-center">
                                                                {{$pago->observaciones}}
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                                    @can("editar-pago")
                                                                        <button wire:click='editar_pago({{$pago->id}})' type="button" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                                    @endcan
                                                                    @can("borrar-pago")
                                                                        <button wire:click='abrir_modal_borrar_pago({{$pago->id}})' type="button" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                                                    @endcan
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7" class="text-center">Sin registros...</td>
                                                        </tr>
                                                    @endforelse
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan

                    @can("ver-egresos")
                        <div class="col-lg-12 col-md-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                            <h4>Egresos</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-4">
                                            <thead>
                                                <tr>
                                                    <th>Concepto</th>
                                                    <th>Responsable de pago</th>
                                                    <th>Monto</th>
                                                    <th>Gestoria</th>
                                                    <th>Impuesto</th>
                                                    <th>Fecha de egreso</th>
                                                    <th>Observaciones</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                                <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                                            </thead>
                                            <tbody>
                                                @if ($escritura_activa)
                                                    @forelse ($escritura_activa->egresos_data as $egreso)
                                                        <tr>
                                                            <td>{{$egreso->costos->concepto_pago->descripcion}}</td>
                                                            <td>{{$egreso->responsable->name ?? "N/A"}} {{$egreso->responsable->apaterno ?? ""}}</td>
                                                            <td class="text-center">${{number_format($egreso->monto, 2)}}</td>
                                                            <td class="text-center">${{number_format($egreso->gestoria, 2)}}</td>
                                                            <td class="text-center">${{number_format($egreso->impuestos, 2)}}</td>
                                                            <td class="text-center">{{$egreso->fecha_egreso}}</td>
                                                            <td class="text-center">{{$egreso->comentarios}}</td>
                                                            <td>
                                                                @if ($egreso->status == 0 || !$egreso->status)
                                                                    <span class="badge badge-danger">En espera de pago...</span>
                                                                @endif
                                                                @if ($egreso->status == 1)
                                                                    <span class="badge badge-success">Pagado: {{$egreso->fecha_pago}}</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                                    @can("editar-egresos")
                                                                        <button wire:click='editar_egresos({{$egreso->id}})' type="button" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                                    @endcan

                                                                    @can("borrar-egreso")
                                                                        <button wire:click='abrir_modal_borrar_egreso({{$egreso->id}})' type="button" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                                                    @endcan
                                                                    @if (!$egreso->status || $egreso->status == 0)
                                                                        @can("registrar-recibo-egreso")
                                                                            <button wire:click='abrir_modal_recibo_egreso({{$egreso->id}})' class="btn btn-warning"><i class="fa-solid fa-file-arrow-up"></i></button>
                                                                        @endcan
                                                                    @else
                                                                        @can("ver-recibo-egreso")
                                                                            <a target="_blank" href="{{url($egreso->path)}}" class="btn btn-success"><i class="fa-solid fa-file"></i></a>
                                                                        @endcan
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="9" class="text-center">Sin registros...</td>
                                                        </tr>
                                                    @endforelse
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
                    @can("ver-comisiones")
                        <div class="col-lg-12 col-md-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12 d-flex justify-content-between">
                                            <h4>Comisiones</h4>
                                            @can("crear-comision")
                                                <button class="btn btn-primary" wire:click='abrirModalComision'><i class="fa-solid fa-plus"></i> Registrar comisión</button>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-4">
                                            <thead>
                                                <tr>
                                                    <th>Promotor</th>
                                                    <th>Monto</th>
                                                    <th>Observaciones</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($escritura_activa)
                                                    @forelse ($escritura_activa->comisiones_proyecto as $comision)
                                                        <tr>
                                                            <td>{{$comision->promotor->nombre}} {{$comision->promotor->apaterno}} {{$comision->promotor->amaterno}}</td>
                                                            <td>${{number_format($comision->cantidad, 2)}}</td>
                                                            <td>{{$comision->observaciones}}</td>
                                                            <td class="text-center">
                                                                <button wire:click='editarComision({{$comision->id}})' class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                                <button wire:click='borrarComision({{$comision->id}})' class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td class="text-center" colspan="4">Sin registros...</td>
                                                        </tr>
                                                    @endforelse ()
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
                    @can("ver-facturas")
                        <div class="col-lg-12 col-md-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12 d-flex justify-content-between">
                                            <h4>Facturas</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-4">
                                            <thead>
                                                <tr>
                                                    <th>Folio</th>
                                                    <th>Monto</th>
                                                    <th>RFC Receptor</th>
                                                    <th>Fecha</th>
                                                    <th>Origen</th>
                                                    <th>Concepto</th>
                                                    <th>Cliente</th>
                                                    <th>Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($escritura_activa)
                                                    @forelse ($escritura_activa->facturas as $factura)
                                                        <tr>
                                                            <td>
                                                                {{$factura->folio_factura}}
                                                                <br>
                                                                <div class="d-flex justify-content-start">
                                                                    @if ($factura->pdf)
                                                                        <a class="btn btn-outline-success me-2" href="{{url($factura->pdf)}}" target="_blank">
                                                                            <i class="fa-solid fa-file-pdf"></i>
                                                                        </a>
                                                                    @endif
                                                                    @if ($factura->xml)
                                                                        <a class="btn btn-outline-success" href="{{url($factura->xml)}}" target="_blank">
                                                                            <i class="fa-solid fa-file-invoice"></i>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td>{{$factura->monto}}</td>
                                                            <td>{{$factura->rfc_receptor}}</td>
                                                            <td>{{$factura->fecha}}</td>
                                                            <td>{{$factura->origen}}</td>
                                                            <td>{{$factura->concepto}}</td>
                                                            <td>{{$factura->cliente->nombre}} {{$factura->cliente->apaterno}} {{$factura->cliente->amaterno}}</td>
                                                            <td>{{$factura->observaciones}}</td>
                                                            <td>
                                                                <button wire:click='borrarFactura({{$factura->id}})' class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td class="text-center" colspan="8">Sin registros...</td>
                                                        </tr>
                                                    @endforelse ()
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
                    @can("ver-declaraciones")
                        <div class="col-lg-12 col-md-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12 d-flex justify-content-between">
                                            <h4>Declaraciones</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content widget-content-area">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-4">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Escritura</th>
                                                    <th>Usuario</th>
                                                    <th>Observaciones</th>
                                                    <th>Documentos</th>
                                                    <th>Acciones</th>
                                            </thead>
                                            <tbody>
                                                @if ($escritura_activa)
                                                    @forelse ($escritura_activa->declaraciones as $declaracion)
                                                        <tr>
                                                            <td>{{$declaracion->fecha}}</td>
                                                            <td>
                                                                {{$declaracion->escritura->servicio->nombre}} -
                                                                {{$declaracion->escritura->cliente->nombre}} {{$declaracion->escritura->cliente->apaterno}} {{$declaracion->escritura->cliente->amaterno}} -
                                                                #{{$declaracion->escritura->numero_escritura}}
                                                            </td>
                                                            <td>
                                                                {{$declaracion->usuario->name}}
                                                            </td>
                                                            <td>{{$declaracion->observaciones}}</td>
                                                            <td>
                                                                <div class="avatar--group avatar-group-badge">
                                                                    @foreach ($declaracion->documentos as $doc)
                                                                        <div class="avatar avatar-sm">
                                                                            <a href="{{url($doc->path)}}" target="_blank">
                                                                                <span class="avatar-title rounded-circle">
                                                                                    <i class="fa-solid fa-file-pdf"></i>
                                                                                </span>
                                                                            </a>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                                                <button class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="8" class="text-center">Sin registros...</td>
                                                        </tr>
                                                    @endforelse
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='clear_inputs' class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<style>
    .snackbar-container{
        z-index: 100000;
    }
</style>

<script>
    window.addEventListener('open-modal-pagos', event => {
        $(".modal-pagos").modal("show")
    })

    window.addEventListener('close-modal-pagos', event => {
        $(".modal-pagos").modal("hide")

        var myAudio= document.createElement('audio')
        myAudio.src = "{{ url("/v3/src/assets/audio/notification.mp3") }}"
        myAudio.play()

        Snackbar.show({
            text: event.detail,
            actionTextColor: '#fff',
            backgroundColor: '#00ab55',
            pos: 'top-center',
            duration: 5000,
            actionText: '<i class="fa-solid fa-circle-xmark"></i>'
        })
    })
</script>

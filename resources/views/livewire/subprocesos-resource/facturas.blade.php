<div class="row">
    <div class="col-lg-12 mb-2 mt-2">
        <div style="width:100%; display: flex; justify-content:space-between;">
            <div class="flex-item">
                <button wire:click='open_modal_registrar_factura' style="height: 100%;" class="btn btn-primary">
                    <i class="fa-solid fa-circle-plus"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="col-lg-12 mb-2 mt-2">
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Concepto</th>
                            <th>Folio</th>
                            <th>Receptor</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                            <th>Comentarios</th>
                            <th>Registrado por</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($proyecto_activo)
                            @forelse ($proyecto_activo->facturas as $factura)
                                <tr>
                                    <td>{{$factura->costos->concepto_pago->descripcion}}</td>
                                    <td>{{$factura->folio_factura}}</td>
                                    <td>{{$factura->rfc_receptor}}</td>
                                    <td>{{$factura->monto}}</td>
                                    <td>{{$factura->fecha}}</td>
                                    <td>{{$factura->observaciones}}</td>
                                    <td>{{$factura->usuario->name}} {{$factura->usuario->apaterno}} {{$factura->usuario->amaterno}}</td>
                                    <td>
                                        <button class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button class="btn btn-outline-primary"><i class="fa-solid fa-file-pdf"></i></button>
                                        <button class="btn btn-outline-primary"><i class="fa-solid fa-file-invoice"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Sin registros</td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

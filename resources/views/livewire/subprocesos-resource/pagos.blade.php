<div class="row gx-3 gy-3">
    <div class="col-lg-12 mb-2 mt-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Anticipos</h5>
                <button wire:loading.attr="disabled" class="btn btn-outline-primary" wire:click='abrirModalPagos'><i class="fa-solid fa-plus"></i></button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Recibo de pago</th>
                                <th>Fecha</th>
                                <th>Recibido de</th>
                                <th>Recibio</th>
                                <th>Monto</th>
                                <th>Metodo de pago</th>
                                <th>Cuenta</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($proyecto_activo)
                                @forelse ($proyecto_activo->pagos_recibidos as $pago)
                                    <tr>
                                        <td class="text-center">
                                            <button wire:click='crear_recibo({{$pago->id}})' class="btn btn-outline-primary"><i class="fa-sharp fa-solid fa-file-invoice-dollar"></i></button>
                                            @if ($pago->path)
                                                <a href="{{url($pago->path)}}" target="_blank" class="btn btn-outline-success"><i class="fa-solid fa-cloud-arrow-down"></i></a>
                                            @endif
                                            @if (!$pago->path)
                                                <button wire:click='abrir_modal_importar_recibo({{$pago->id}})' class="btn btn-outline-danger"><i class="fa-solid fa-file-import"></i></button>
                                            @endif
                                        </td>
                                        <td>{{$pago->fecha}}</td>
                                        <td>{{$pago->cliente ?? $pago->proyecto->cliente->nombre . " " . $pago->proyecto->cliente->apaterno}}</td>
                                        <td>{{$pago->usuario->name}} {{$pago->usuario->apaterno}}</td>
                                        <td>{{$pago->monto}}</td>
                                        <td>{{$pago->metodo_pago->nombre}}</td>
                                        <td>{{isset($pago->cuenta->banco->nombre) ? $pago->cuenta->banco->nombre : "N/A"}}</td>
                                        <td>{{$pago->observaciones}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="7">Sin registros...</td>
                                    </tr>
                                @endforelse
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

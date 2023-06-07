<div class="row gx-3 gy-3">
    <div class="col-lg-12 mb-2 mt-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Anticipos</h5>
                <button wire:loading.remove class="btn btn-outline-primary" wire:click='abrirModalPagos'><i class="fa-solid fa-plus"></i></button>
                <div wire:loading class="d-flex justify-content-between mx-5 mt-3 mb-5">
                    <div class="spinner-border text-success align-self-center ">Loading...</div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Recibido de</th>
                                <th>Monto</th>
                                <th>Metodo de pago</th>
                                <th>Cuenta</th>
                                <th>Usuario</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($proyecto_activo)
                                @forelse ($proyecto_activo->pagos_recibidos as $pago)
                                    <tr>
                                        <td>{{$pago->fecha}}</td>
                                        <td>{{$pago->cliente}}</td>
                                        <td>{{$pago->monto}}</td>
                                        <td>{{$pago->metodo_pago_id}}</td>
                                        <td>{{$pago->cuenta_id}}</td>
                                        <td>{{$pago->usuario_id}}</td>
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

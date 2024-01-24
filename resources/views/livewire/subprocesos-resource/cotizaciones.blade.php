<div class="row gx-3 gy-3">
    <div class="col-lg-12 mb-2 mt-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Cotización</h5>
                @if ($proyecto_activo && count($proyecto_activo->costos_cotizacion) != 0)
                    <button wire:loading.attr="disabled" class="btn btn-outline-dark" wire:click='abrirModalBorrarCotizacion'>
                        <i class="fa-solid fa-trash"></i>
                    </button>
                @else
                    <button wire:loading.attr="disabled" class="btn btn-outline-dark" wire:click='abrirModalCotizacionesRegistradas'>
                        <i class="fa-solid fa-plus"></i>
                    </button>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered border-primary">
                        <thead>
                            <tr>
                                <th>Concepto</th>
                                <th>Subtotal</th>
                                <th>Gestoria</th>
                                <th>Impuestos</th>
                                <th>Total</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($proyecto_activo)
                                @forelse ($proyecto_activo->costos_cotizacion as $costo)
                                    <tr>
                                        <td>{{$costo->concepto_pago->descripcion}}</td>
                                        <td>${{number_format($costo->subtotal, 2)}}</td>
                                        <td>${{number_format($costo->gestoria, 2)}}</td>
                                        <td>
                                            ${{number_format($costo->subtotal * $costo->impuestos / 100, 2)}}
                                            <span class="text-primary">({{$costo->impuestos}}%)</span>
                                        </td>
                                        <td>
                                            ${{number_format($costo->subtotal + $costo->gestoria + $costo->subtotal * $costo->impuestos / 100, 2)}}
                                        </td>
                                        <td>{{$costo->observaciones ?? "Sin observaciones"}}</td>
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
</div>


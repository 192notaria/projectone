<div class="row">
    <div class="col-lg-12 mb-2 mt-2">
        <button wire:click='calcularTotalPago' class="btn btn-primary"><i class="fa-solid fa-bars"></i></button>
    </div>
    <div class="col-lg-12 mb-2 mt-2">
        <div class="card">
            <div class="card-header">
                <h5>Detalle de la cuenta</h5>
            </div>
            <div class="card-body">
                @php
                    $costoTotal = 0;
                    if($proyecto_activo){
                        foreach ($proyecto_activo->costos_proyecto as $costo) {
                            $costoTotal = $costoTotal + $costo->gestoria + $costo->subtotal + $costo->subtotal * $costo->impuestos / 100;
                        }
                    }
                @endphp
                @if ($proyecto_activo)
                    <div class="d-flex justify-content-between">
                        <h4>Costo Total:</h4>
                        <h4>${{number_format($costoTotal, 2)}}</h4>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h4>Descuento:</h4>
                        <h4>${{number_format($proyecto_activo['descuento'], 2) ?? ""}}</h4>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h4>Cobrado:</h4>
                        @php
                            $cantidad_cobrada = 0;
                            if($proyecto_activo){
                                foreach ($proyecto_activo->pagos_recibidos as $recibido) {
                                    $cantidad_cobrada = $cantidad_cobrada + $recibido->monto;
                                }
                            }
                        @endphp
                        <h4>${{number_format($cantidad_cobrada, 2) ?? ""}}</h4>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h2>Total a cobrar:</h2>
                        <h3>
                            ${{number_format($costoTotal - $proyecto_activo['descuento'] - $cantidad_cobrada, 2)}}
                        </h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-12 mb-2 mt-2">
        <div class="card">
            <div class="card-header">
                <h5>Costos</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-responsive table-striped">
                    <thead>
                        <tr>
                            <th class="text-center"><i class="fa-solid fa-circle-info"></i></th>
                            <th>Concepto</th>
                            <th>Gestoria</th>
                            <th>Subtotal</th>
                            <th>Impuestos</th>
                            <th>Costo total</th>
                            <th>Egresos</th>
                            <th>Facturado</th>
                            <th>Cobrado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($proyecto_activo)
                            @foreach ($proyecto_activo->costos_proyecto as $key => $costo)
                                <tr>
                                    <td class="text-center">
                                        <div class="form-check form-check-primary form-check-inline">
                                            <input wire:change='calcularTotalPago' class="form-check-input" type="checkbox" aria-selected="false" id="form-custom-switch-default-{{$key}}" wire:model='pagos_checkbox.{{$costo->id}}' value="{{$costo->subtotal, 2}}">
                                        </div>
                                    </td>
                                    <td>
                                        {{$costo->concepto_pago->descripcion}}
                                    </td>
                                    <td>
                                        ${{number_format($costo->gestoria, 2)}}
                                    </td>
                                    <td>
                                        ${{number_format($costo->subtotal, 2)}}
                                    </td>
                                    <td>
                                        ${{number_format($costo->subtotal * $costo->impuestos / 100, 2)}}
                                    </td>
                                    <td>
                                        ${{number_format($costo->gestoria + $costo->subtotal + $costo->subtotal * $costo->impuestos / 100, 2)}}
                                    </td>
                                    <td>
                                        @if ($costo->concepto_pago->categoria_gasto_id == 3)
                                            -
                                        @else
                                            $0.0
                                        @endif
                                    </td>
                                    <td>$0.0</td>
                                    @php
                                        $suma=0;
                                    @endphp
                                    <td>
                                        @foreach ($costo->pagados as $pago)
                                            @php
                                                $suma += $pago->monto;
                                            @endphp
                                        @endforeach
                                        <span class="
                                            @if($costo->subtotal + $costo->subtotal * $costo->impuestos / 100 == $suma)
                                                text-success
                                            @endif
                                            @if ($suma == 0)
                                                text-danger
                                            @endif
                                            @if($suma < $costo->subtotal + $costo->subtotal * $costo->impuestos / 100 && $suma > 0)
                                                text-warning
                                            @endif">
                                            ${{number_format($suma, 2)}}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary" wire:click='editarCosto({{$costo->id}})'>
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-12 mb-2 mt-2">
        <div class="card">
            <div class="card-header">
                <h5>Pagos recibidos</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Recibo de pago</th>
                            <th>Fecha Recibido</th>
                            <th>Cuenta</th>
                            <th>Metodo de pago</th>
                            <th>Monto</th>
                            <th>Comentarios</th>
                            <th>Usuario creador</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($proyecto_activo)
                            @foreach ($proyecto_activo->pagos_recibidos as $pago)
                                <tr>
                                    <td>
                                        <button class="btn btn-danger" wire:click='crear_recibo({{$pago->id}})'>
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </button>
                                    </td>
                                    <td>{{$pago->fecha}}</td>
                                    <td>
                                        @if (isset($pago->cuenta->banco->nombre))
                                            {{$pago->cuenta->banco->nombre}} : {{$pago->cuenta->numero_cuenta}}
                                        @else
                                            <span>Sin cuenta</span>
                                        @endif
                                    </td>
                                    <td>{{$pago->metodo_pago->nombre}}</td>
                                    <td>${{number_format($pago->monto, 2)}}</td>
                                    <td>{{$pago->observaciones}}</td>
                                    <td>{{$pago->usuario->name}} {{$pago->usuario->apaterno}} {{$pago->usuario->amaterno}}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-12 mb-2 mt-2">
        <div class="card">
            <div class="card-header">
                <h5>Pagos ejercidos</h5>
            </div>
            <div class="card-body">
                @if ($td_egreso == "info")
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Concepto</th>
                                <th>Monto</th>
                                <th>Gastos de gestoria</th>
                                <th>Impuestos</th>
                                <th>Fecha</th>
                                <th>Comentarios</th>
                                <th>Documentos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($proyecto_activo)
                                @forelse ($proyecto_activo->egresos_data as $egreso)
                                    <tr>
                                        <td>{{$egreso->costos->concepto_pago->descripcion}}</td>
                                        <td>${{number_format($egreso->monto, 2)}}</td>
                                        <td>${{number_format($egreso->gestoria, 2)}}</td>
                                        <td>${{number_format($egreso->impuestos, 2)}}</td>
                                        <td>{{$egreso->fecha_egreso}}</td>
                                        <td>{{$egreso->comentarios}}</td>
                                        <td class="text-center">
                                            @if ($egreso->path)
                                                <a href="{{url($egreso->path)}}" target="_blank" class="btn btn-primary">
                                                    <i class="fa-solid fa-file"></i>
                                                </a>
                                            @endif
                                            @if (!$egreso->path)
                                                <button class="btn btn-danger" wire:click="open_egreso_modal_doc({{$egreso->id}})">
                                                    <i class="fa-solid fa-file-arrow-up"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">Sin registros</td>
                                    </tr>
                                @endforelse
                            @endif
                        </tbody>
                    </table>
                @endif
                @if ($td_egreso == "upload")
                    <div class="col-lg-12">
                        <x-file-pond wire:model='file_egreso' accept="application/pdf,.doc,.docx"></x-file-pond>
                        @error("file_egreso")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12 mt-4">
                        <button class="btn btn-success" wire:click='save_egreso_modal_doc'>Guardar</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

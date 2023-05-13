<div wire:ignore.self class="modal fade modal-crear-cotizacion"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-between" style="width: 100%;">
                    <h5>Nueva Cotización</h5>
                </div>
            </div>

            <style>
                   .autocomplete {
                    position: relative;
                    display: inline-block;
                    width: 100%;
                }

                .autocomplete-items {
                    position: absolute;
                    border: 1px solid #d4d4d4;
                    border-bottom: none;
                    border-top: none;
                    z-index: 99;
                    top: 100%;
                    left: 0;
                    right: 0;
                }

                .autocomplete-items div {
                    padding: 10px;
                    cursor: pointer;
                    border-bottom: 1px solid #d4d4d4;
                    background-color: #ffff;
                }

                .autocomplete-items div:hover {
                    background-color: #e9e9e9;
                }
            </style>
            <div class="modal-body">
                <div class="row gx-3 gy-4">
                    @if (!$proyecto_cliente)
                        <div class="col-lg-6">
                            <div class="form-group autocomplete">
                                <label for="">Cliente</label>
                                    <input wire:model='buscar_cliente' type="text" class="form-control" placeholder="Buscar...">
                                    <div class="autocomplete-items">
                                        @foreach ($clientes as $cliente)
                                            <a wire:click='asignar_cliente({{$cliente}})'>
                                                <div>
                                                    <strong>
                                                        {{$cliente->nombre}} {{$cliente->apaterno}} {{$cliente->amaterno}}
                                                    </strong>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @error("proyecto_cliente")
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    @endif
                    @if ($proyecto_cliente)
                        <div class="col-lg-6">
                            <label for="">Cliente</label>
                            <span class="avatar-chip avatar-dismiss bg-primary">
                                <img src="{{url('/v3/src/assets/img/avatarprofile.png')}}" alt="Person" width="96" height="96">
                                <span class="text">{{$proyecto_cliente['nombre']}} {{$proyecto_cliente['apaterno']}} {{$proyecto_cliente['amaterno']}}</span>
                                <a wire:click='remover_cliente'>
                                    <span class="closebtn ms-2">x</span>
                                </a>
                            </span>
                        </div>
                    @endif
                    <div class="col-lg-6">
                        <label for="">Acto</label>
                        <select class="form-select" wire:change='agregar_honorarios' wire:model='acto_id'>
                            <option value="" selected disabled>Seleccionar...</option>
                            @foreach ($actos as $acto)
                                <option value="{{$acto->id}}">{{$acto->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-12 table-responsive">
                        <button class="btn btn-outline-primary" wire:click='abrir_modal_costo'>
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                    <div class="col-lg-12 table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Concepto</th>
                                    <th>Monto</th>
                                    <th>Gestoria</th>
                                    <th>Impuesto</th>
                                    <th>SubTotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($costos_array as $key => $costo)
                                    <tr>
                                        <td>{{$costo['concepto']}}</td>
                                        <td>${{number_format($costo['monto'], 2)}}</td>
                                        <td>${{number_format($costo['gestoria'], 2)}}</td>
                                        <td>${{number_format($costo['monto'] * $costo['impuesto'] / 100, 2)}}</td>
                                        <td class="text-end">${{number_format($costo['monto'] + $costo['gestoria'] + $costo['monto'] * $costo['impuesto'] / 100, 2)}}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <button wire:click='editar_concepto({{$key}})' class="btn btn-primary me-2"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button wire:click='remover_concepto({{$key}})' class="btn btn-danger"><i class="fa-solid fa-circle-minus"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="4">Sin costos agregados...</td>
                                    </tr>
                                @endforelse
                                <tr>
                                    <td colspan="5" class="text-end">
                                        @if (count($costos_array) > 0)
                                            @php
                                                $total_sum = 0;
                                                foreach ($costos_array as $costo_sum) {
                                                    $total = $costo_sum['monto'] + $costo_sum['gestoria'] + $costo_sum['monto'] * $costo_sum['impuesto'] / 100;
                                                    $total_sum = $total_sum + $total;
                                                }
                                            @endphp
                                            {!! "<span class='badge badge-success'>Total: $" . number_format($total_sum, 2) . "</span>" !!}
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @error("error_cotizacion")
                        <div class="col-lg-12 text-center">
                            <span class="text-danger">{{$message}}</span>
                        </div>
                    @enderror
                    @error("costos_array")
                        <div class="col-lg-12 text-center">
                            <span class="text-danger">{{$message}}</span>
                        </div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button wire:loading:remove wire:click='registrar_cotizacion' class="btn btn-outline-success">
                    Guardar
                </button>
                <span wire:loading><div class="spinner-border text-success align-self-center "></div></span>
                <button wire:loading:remove class="btn btn-outline-danger" data-bs-dismiss="modal">
                    Cerrar
                </button>
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
    window.addEventListener('abrir-modal-crear-cotizacion', event => {
        $(".modal-crear-cotizacion").modal("show")
    })

    window.addEventListener('cerrar-modal-crear-cotizacion', event => {
        $(".modal-crear-cotizacion").modal("hide")
    })
</script>

<div wire:ignore.self class="modal fade modal-historial-cotizacion"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-between" style="width: 100%;">
                    <h5>Historial de cotización</h5>
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
                    @forelse ($historial_cotizaciones as $historial)
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between">
                                        <h3># {{$historial[0]['version']}}</h3>
                                        <button class="btn btn-outline-primary" wire:click='descargar_cotizacion({{$historial[0]['version']}}, {{$historial[0]['cotizaciones_id']}})'><i class="fa-solid fa-file-arrow-down"></i> Descargar Cotización</button>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Concepto</th>
                                                <th class="text-center">Subtotal</th>
                                                <th class="text-center">Gestoria</th>
                                                <th class="text-center">Impuesto</th>
                                                <th class="text-center">Total</th>
                                                <th class="text-center">Observaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($historial as $costo)
                                                <tr>
                                                    <td>{{$costo['concepto']['descripcion']}}</td>
                                                    <td class="text-center">${{number_format($costo['subtotal'], 2)}}</td>
                                                    <td class="text-center">${{number_format($costo['gestoria'], 2)}}</td>
                                                    <td class="text-center">${{number_format($costo['impuesto'] * $costo['subtotal'] / 100, 2)}}</td>
                                                    <td class="text-end">
                                                        @php
                                                            $total = $costo['subtotal'] + $costo['gestoria'] + $costo['impuesto'] * $costo['subtotal'] / 100;
                                                        @endphp
                                                        {!!"<span class='badge badge-primary'>$" . number_format($total, 2) . "<span>"!!}
                                                    </td>
                                                    <td class="text-center">{{$costo['observaciones'] == '' ? "Sin observaciones" : $costo['observaciones']}}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">Sin registros...</td>
                                                </tr>
                                            @endforelse
                                            <tr>
                                                <td  colspan="5" class="text-end">
                                                    @php
                                                        $total_sum = 0;
                                                        foreach ($historial as $key => $costo_sum) {
                                                            $total_sum = $total_sum + $costo_sum['subtotal'] + $costo_sum['gestoria'] + $costo_sum['impuesto'] * $costo_sum['subtotal'] / 100;
                                                        }
                                                    @endphp
                                                    {!!"<span class='badge badge-success'>$" . number_format($total_sum, 2) . "<span>"!!}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @empty
                        <h3>Sin registros...</h3>
                    @endforelse
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-danger" wire:click='cerrar_historail_cotizacion'>
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
    window.addEventListener('abrir-modal-historial-cotizacion', event => {
        $(".modal-historial-cotizacion").modal("show")
    })

    window.addEventListener('cerrar-modal-historial-cotizacion', event => {
        $(".modal-historial-cotizacion").modal("hide")
    })
</script>

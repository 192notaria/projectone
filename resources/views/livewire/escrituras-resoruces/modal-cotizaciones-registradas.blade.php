<div wire:ignore.self class="modal fade modal-cotizacionesRegistradas"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Agregar cotización</h5>
            </div>
            <div class="modal-body">
                <div class="row gx-3 gy-3">
                    <div class="col-lg-6">
                        <label for="">Cotización</label>
                        <select wire:model='cotizacion_id' wire:change='cargarCotizacion' class="form-select">
                            <option value="" disabled>Seleccionar cotización</option>
                            @foreach ($cotizaciones as $cotizacion)
                                <option value="{{$cotizacion->id}}">{{$cotizacion->id}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if ($cotizacion_data_version)
                        <div class="col-lg-6">
                            <label for="">Versión</label>
                            <select wire:model='cotizacion_version_id' wire:change='seleccionarVersion' class="form-select">
                                <option value="" disabled>Seleccionar cotización</option>
                                @foreach ($cotizacion_data_version as $version)
                                    <option value="{{$version->version}}">{{$version->version}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    @if ($cotizacion_data)
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <ul>
                                    <li>Cliente: <span class="font-bold">{{$cotizacion_data[0]->cotizacion_info->cliente->nombre}} {{$cotizacion_data[0]->cotizacion_info->cliente->apaterno}} {{$cotizacion_data[0]->cotizacion_info->cliente->amaterno}}</span></li>
                                    <li>Acto: <span class="font-bold">{{$cotizacion_data[0]->cotizacion_info->acto->nombre}}</span> </li>
                                    <li>Abogado: <span class="font-bold">{{$cotizacion_data[0]->cotizacion_info->usuario->name}} {{$cotizacion_data[0]->cotizacion_info->usuario->apaterno}} {{$cotizacion_data[0]->cotizacion_info->usuario->amaterno}}</span></li>
                                    <li>Fecha: <span class="font-bold">{{$cotizacion_data[0]->cotizacion_info->created_at}}</span></li>
                                </ul>
                                <table class="table table-bordered mb-4">
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
                                        @if ($cotizacion_data_costos)
                                            @forelse ($cotizacion_data_costos as $costo)
                                                <tr>
                                                    <td>{{$costo->concepto->descripcion}}</td>
                                                    <td class="text-center">${{number_format($costo->subtotal, 2)}}</td>
                                                    <td class="text-center">${{number_format($costo->gestoria, 2)}}</td>
                                                    <td class="text-center">
                                                        ${{number_format($costo->subtotal * $costo->impuestos / 100, 2)}}
                                                        <span class="text-primary">({{$costo->impuestos}}%)</span>
                                                    </td>
                                                    <td class="text-center">
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
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="text-danger me-3" data-bs-dismiss="modal">Cancelar</a>
                <button wire:click='vincular_cotizacion' class="btn btn-outline-success">Vincular Cotización</button>
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
    window.addEventListener('abrir-modal-cotizacionesRegistradas', event => {
        $(".modal-cotizacionesRegistradas").modal("show")
    })

    window.addEventListener('cerrar-modal-cotizacionesRegistradas', event => {
        $(".modal-cotizacionesRegistradas").modal("hide")

        // var myAudio= document.createElement('audio')
        // myAudio.src = "{{ url("/v3/src/assets/audio/notification.mp3") }}"
        // myAudio.play()

        // Snackbar.show({
        //     text: event.detail,
        //     actionTextColor: '#fff',
        //     backgroundColor: '#00ab55',
        //     pos: 'top-center',
        //     duration: 5000,
        //     actionText: '<i class="fa-solid fa-circle-xmark"></i>'
        // })
    })
</script>

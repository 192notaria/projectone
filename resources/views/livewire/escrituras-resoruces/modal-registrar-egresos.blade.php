<div wire:ignore.self class="modal fade modal-registrar-egresos"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Registrar egresos</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 mb-2 mt-2 table-responsive">
                        <label for="">Conceptos</label>
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>Concepto</th>
                                    <th>Monto</th>
                                    <th>Gestoria</th>
                                    <th>Impuestos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $monto_total = 0;
                                @endphp
                                @forelse ($costos_a_egresar as $costos)
                                    <tr wire:ignore.self>
                                        <td>{{$costos['concepto_pago']['descripcion']}}</td>
                                        <td>${{number_format($costos['subtotal'], 2)}}</td>
                                        <td>${{number_format($costos['gestoria'], 2)}}</td>
                                        <td>${{number_format($costos['subtotal'] * $costos['impuestos'] / 100, 2)}}</td>
                                    </tr>
                                    @php
                                        $monto_total = $monto_total + $costos['subtotal'] + $costos['gestoria'] + $costos['subtotal'] * $costos['impuestos'] / 100;
                                    @endphp
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Sin registros</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-12 mb-2 mt-2">
                        <label for="">Monto Total: </label>
                        <span class="badge badge-success">${{number_format($monto_total, 2)}}</span>
                    </div>
                    <div class="col-lg-6 mb-2 mt-2">
                        <label for="">Fecha de egreso</label>
                        <input type="datetime-local" class="form-control" wire:model='fecha_egreso'>
                    </div>
                    <div class="col-lg-6 mb-2 mt-2">
                        <label for="">Metodo de pago</label>
                        <select class="form-select" wire:model='metodo_pago_egreso'>
                            <option value="" selected disabled>Seleccionar...</option>
                            @foreach ($metodos_pago as $metodo)
                                <option value="{{$metodo->id}}">{{$metodo->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-12 mt-2">
                        <label for="">Comentarios</label>
                        <textarea wire:model='comentarios_egreso' placeholder="Comentarios..." cols="30" rows="3" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='registrarEgreso' class="btn btn-outline-success">Guardar</button>
                <button wire:click='clearEgresos' class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>
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
    window.addEventListener('abrir-modal-registrar-egresos', event => {
        $(".modal-registrar-egresos").modal("show")
    })

    window.addEventListener('cerrar-modal-registrar-egresos', event => {
        $(".modal-registrar-egresos").modal("hide")

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

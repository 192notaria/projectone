<div wire:ignore.self class="modal fade modal-registrar-egresos"  style="z-index: 1000000;" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
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
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($egreso_data)
                                    <tr>
                                        <td>{{$egreso_data->concepto_pago->descripcion}}</td>
                                        <td>${{number_format($egreso_data->subtotal, 2)}}</td>
                                        <td>${{number_format($egreso_data->gestoria, 2)}}</td>
                                        <td>
                                            ${{number_format($egreso_data->subtotal * $egreso_data->impuestos / 100, 2)}}
                                            <span class="text-primary">({{$egreso_data->impuestos}}%)</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-success">${{number_format($egreso_data->subtotal + $egreso_data->gestoria + $egreso_data->subtotal * $egreso_data->impuestos / 100, 2)}}</span>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @error("sin_saldo")
                        <div class="col-lg-12 mb-4 mt-2">
                            <h4 class="text-danger">{{$message}}</h4>
                        </div>
                    @enderror
                    <div class="col-lg-6 mb-2 mt-2">
                        <label for="">Fecha de egreso</label>
                        <input type="datetime-local" class="form-control" wire:model='fecha_egreso'>
                        @error("fecha_egreso")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6 mb-2 mt-2">
                        <label for="">Responsable de pagar</label>
                        <select class="form-select" wire:model='responsable_pago'>
                            <option value="" selected disabled>Seleccionar...</option>
                            @foreach ($abogados as $abogado)
                                <option value="{{$abogado->id}}">{{$abogado->name}} {{$abogado->apaterno}} {{$abogado->amaterno}}</option>
                            @endforeach
                        </select>
                        @error("responsable_pago")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12 mt-2">
                        <label for="">Comentarios</label>
                        <textarea wire:model='comentarios_egreso' placeholder="Comentarios..." cols="30" rows="3" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:loading.attr="disabled" wire:click='registrar_egreso' class="btn btn-outline-success">Guardar</button>
                <button wire:loading.attr="disabled" wire:click='clear_inputs' class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>
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

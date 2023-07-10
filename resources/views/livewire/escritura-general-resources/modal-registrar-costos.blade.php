<div wire:ignore.self class="modal fade modal-registrar-costo"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Agregar costo</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 mb-2 mt-2">
                        <label for="">Concepto</label>
                        <select class="form-select" wire:model='concepto_costo_id'>
                            <option value="" selected disabled>Seleccionar...</option>
                                @foreach ($catalogo_conceptos as $concepto)
                                    <option value="{{$concepto->id}}">{{$concepto->descripcion}}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6 mb-2 mt-2">
                        <label for="">Monto</label>
                        <input type="number" class="form-control" placeholder="0.0" wire:model='monto_costo'>
                        @error("monto_costo")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6 mb-2 mt-2">
                        <label for="">Gastos de gestoria</label>
                        <input type="number" class="form-control" placeholder="0.0" wire:model='gestoria_costo'>
                    </div>
                    <div class="col-lg-12 mb-2 mt-2">
                        <label for="">Impuestos en %</label>
                        <input type="number" class="form-control" placeholder="0%" wire:model='impuestos_costo'>
                    </div>
                    {{-- @if ($concepto_costo_id == 10) --}}
                    @if ($concepto_costo_id == 12)
                        <div class="col-lg-12 mb-2 mt-2">
                            <label for="">Pago realizado</label>
                            <select class="form-select" wire:model='pago_realizado_costo'>
                                <option value="" selected>Ninguno</option>
                                <option value="Cliente">Cliente</option>
                                <option value="Notaria">Notaria</option>
                            </select>
                        </div>
                        <div class="col-lg-12 mb-2 mt-2">
                            <label for="">Metodo de pago</label>
                            <select class="form-select" wire:model='metodo_pago_costo'>
                                <option value="" selected>Ningno</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Transferencia">Transferencia</option>
                            </select>
                        </div>
                    @endif
                    <div class="col-lg-12 mt-2">
                        <label for="">Observaciones</label>
                        <textarea class="form-control" cols="30" rows="5" wire:model='observaciones_costo'></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:loading.attr="disabled"wire:click='registrar_costo' class="btn btn-outline-success">Guardar</button>
                <button wire:loading.attr="disabled"wire:click='clear_inputs' class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>
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
    window.addEventListener('abrir-modal-registrar-costo', event => {
        $(".modal-registrar-costo").modal("show")
    })

    window.addEventListener('cerrar-modal-registrar-costo', event => {
        $(".modal-registrar-costo").modal("hide")

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

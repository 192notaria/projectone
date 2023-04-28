<div wire:ignore.self class="modal fade modal-registrar-pagos" style="z-index: 1000000;" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Registrar pago</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 mb-2 mt-2">
                        <label for="">Fecha de pago</label>
                        <input type="datetime-local" class="form-control" wire:model='fecha_cobro'>
                    </div>
                    <div class="col-lg-12 mb-2 mt-2">
                        <label for="">Nombre del cliente</label>
                        <input type="text" class="form-control" placeholder="Opcional..." wire:model='nombre_cliente_cobro'>
                    </div>
                    <div class="col-lg-6 mb-2 mt-2">
                        <label for="">Monto</label>
                        <input type="number" class="form-control" placeholder="0.0" wire:model='monto_cobro'>
                        @error('monto_mayor')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6 mb-2 mt-2">
                        <label for="">Metodo de pago</label>
                        <select class="form-select" wire:model='metodo_pago_id'>
                            <option value="" disabled selected>Seleccionar...</option>
                            @foreach ($metodos_pago as $metodo)
                                <option value="{{$metodo->id}}">{{$metodo->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-12 mb-2 mt-2">
                        <label for="">Cuenta</label>
                        <select class="form-select" wire:model='cuenta_id'>
                            <option value="" selected>Ninguna...</option>
                            @foreach ($cuentas_bancarias as $cuenta)
                                <option value="{{$cuenta->id}}">{{$cuenta->banco->nombre}} - {{$cuenta->numero_cuenta}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-12 mb-2 mt-2">
                        <label for="">Comentarios</label>
                        <textarea wire:model='observaciones_cobro' cols="30" rows="2" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='registrar_pago' class="btn btn-outline-success">Guardar</button>
                <button class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>
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
    window.addEventListener('abrir-modal-registrar-pagos', event => {
        $(".modal-registrar-pagos").modal("show")
    })

    window.addEventListener('cerrar-modal-registrar-pagos', event => {
        $(".modal-registrar-pagos").modal("hide")

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

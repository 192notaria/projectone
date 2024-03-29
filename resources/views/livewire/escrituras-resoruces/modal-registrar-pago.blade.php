<div wire:ignore.self class="modal fade modal-registrar-pagos" style="z-index: 1000000;" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Registrar anticipo</h5>
            </div>
            <div class="modal-body">
                <div class="row gx-3 gy-3">
                    <div class="col-lg-12 text-center">
                        @php
                            $costoTotal = 0;
                            if($proyecto_activo){
                                foreach ($proyecto_activo->costos_proyecto as $costo) {
                                    $costoTotal = $costoTotal + $costo->gestoria + $costo->subtotal + $costo->subtotal * $costo->impuestos / 100;
                                }
                            }
                        @endphp
                        @if (isset($proyecto_activo['descuento']))
                            <div class="d-flex justify-content-between">
                                <h4>Costo Total:</h4>
                                <h4>${{number_format($costoTotal, 2)}}</h4>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h4>Comisión:</h4>
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
                    <div class="col-lg-12 ">
                        <label for="">Fecha de pago</label>
                        <input type="datetime-local" class="form-control" wire:model='fecha_cobro'>
                    </div>
                    <div class="col-lg-12 ">
                        <label for="">Nombre del cliente</label>
                        <input type="text" class="form-control" placeholder="Opcional..." wire:model='nombre_cliente_cobro'>
                    </div>
                    <div class="col-lg-6 ">
                        <label for="">Monto</label>
                        <input type="number" class="form-control" placeholder="0.0" wire:model='monto_cobro'>
                        @error('monto-no-valido')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6 ">
                        <label for="">Metodo de pago</label>
                        <select class="form-select" wire:model='metodo_pago_id'>
                            <option value="" disabled selected>Seleccionar...</option>
                            @foreach ($metodos_pago as $metodo)
                                <option value="{{$metodo->id}}">{{$metodo->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-12 ">
                        <label for="">Cuenta</label>
                        <select class="form-select" wire:model='cuenta_id'>
                            <option value="" selected>Ninguna...</option>
                            @foreach ($cuentas_bancarias as $cuenta)
                                <option value="{{$cuenta->id}}">{{$cuenta->banco->nombre}} - {{$cuenta->numero_cuenta}}</option>
                            @endforeach
                        </select>
                    </div>
                    @can("cambiar-usuario-recibi-anticipos")
                        <div class="col-lg-12 ">
                            <label for="">Usuario que recibio anticipo</label>
                            <select class="form-select" wire:model='usuario_recibo_id'>
                                <option value="" selected>Ninguna...</option>
                                @foreach ($usuarios_anticipos as $usuario)
                                    <option value="{{$usuario->id}}">{{$usuario->name}} {{$usuario->apaterno}} {{$usuario->amaterno}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endcan
                    <div class="col-lg-12 ">
                        <label for="">Comentarios</label>
                        <textarea wire:model='observaciones_cobro' cols="30" rows="2" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:loading.attr="disabled" wire:click='registrarPago' class="btn btn-outline-success">Guardar</button>
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

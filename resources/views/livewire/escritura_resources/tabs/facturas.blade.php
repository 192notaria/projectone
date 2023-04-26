<div class="row">
    <div class="col-lg-12 mb-2 mt-2">
        <div style="width:100%; display: flex; justify-content:space-between;">
            <div class="flex-item">
                <button wire:click='open_modal_registrar_factura' style="height: 100%;" class="btn btn-primary">
                    <i class="fa-solid fa-circle-plus"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="col-lg-12 mb-2 mt-2">
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Concepto</th>
                            <th>Folio</th>
                            <th>Receptor</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                            <th>Comentarios</th>
                            <th>Registrado por</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($escritura_activa->facturas as $factura)
                            <tr>
                                <td>
                                    {{$factura->costos->concepto_pago->descripcion}}
                                </td>
                                <td>
                                    {{$factura->folio_factura}}
                                </td>
                                <td>
                                    {{$factura->rfc_receptor}}
                                </td>
                                <td>
                                    {{$factura->monto}}
                                </td>
                                <td>
                                    {{$factura->fecha}}
                                </td>
                                <td>
                                    {{$factura->observaciones}}
                                </td>
                                <td>
                                    {{$factura->usuario->name}} {{$factura->usuario->apaterno}} {{$factura->usuario->amaterno}}
                                </td>
                                <td>
                                    <div class="d-flex justify-content-bettwen">
                                        <button class="btn btn-outline-danger me-2"><i class="fa-solid fa-trash"></i></button>
                                        <button wire:click='editar_factura({{$factura->id}})' class="btn btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Sin registros...</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div wire:ignore.self class="modal fade modal-registrar-facturas"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Registrar facturas</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 mb-2 mt-2">
                        <label for="">Concepto</label>
                        <select class="form-select" wire:model='concepto_factura'>
                            <option value="" selected disabled>Seleccionar...</option>
                            @foreach ($escritura_activa->costos_proyecto as $costo)
                                <option value="{{$costo->id}}">{{$costo->concepto_pago->descripcion}}</option>
                            @endforeach
                        </select>
                        @error("concepto_factura")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6 mb-2 mt-2">
                        <label for="">Monto</label>
                        <input type="text" class="form-control" placeholder="$0.0" wire:model='monto_factura'>
                        @error("monto_factura")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6 mb-2 mt-2">
                        <label for="">Folio de factura</label>
                        <input type="text" class="form-control" placeholder="Folio..." wire:model='folio_factura'>
                        @error("folio_factura")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12 mb-2 mt-2">
                        <label for="">RFC Receptor</label>
                        <input type="text" class="form-control" placeholder="XRFA120987D90" wire:model='rfc_factura'>
                        @error("rfc_factura")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6 mb-2 mt-2">
                        <label for="">Fecha</label>
                        <input type="datetime-local" class="form-control" placeholder="$0.0" wire:model='fecha_factura'>
                        @error("fecha_factura")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6 mb-2 mt-2">
                        <label for="">Origen</label>
                        <select class="form-select" wire:model='origen_factura'>
                            <option value="" selected disabled>Seleccionar...</option>
                            <option value="Emitida">Emitidad</option>
                            <option value="Recibida">Recibida</option>
                        </select>
                        @error('origen_factura')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12 mb-2 mt-2">
                        <label for="">Comentarios</label>
                        <textarea class="form-control" cols="30" rows="2" wire:model='comentarios_factura'></textarea>
                    </div>
                    <div class="col-lg-12 mb-2 mt-2">
                        <label for="">XML (Opcional)</label>
                        <x-file-pond wire:model='xml_factura'></x-file-pond>
                        @error('xml_factura')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12 mb-2 mt-2">
                        <label for="">PDF (Opcional)</label>
                        <x-file-pond wire:model='pdf_factura'></x-file-pond>
                        @error('pdf_factura')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='registrar_factura' class="btn btn-outline-success">Guardar</button>
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
    window.addEventListener('abrir-modal-registrar-facturas', event => {
        $(".modal-registrar-facturas").modal("show")
    })

    window.addEventListener('cerrar-modal-registrar-facturas', event => {
        $(".modal-registrar-facturas").modal("hide")

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

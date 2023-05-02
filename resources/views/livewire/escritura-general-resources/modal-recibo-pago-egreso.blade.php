<div wire:ignore.self class="modal fade modal-registrar-recibo-egreso"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Agregar recibo de pago</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 mb-2 mt-2">
                        <label for="">Fecha de pago</label>
                        <input type="datetime-local" class="form-control" wire:model='fecha_pago_egreso'>
                        @error("fecha_pago_egreso")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12 mb-2 mt-2">
                        <label for="">Recibo</label>
                        <x-file-pond wire:model='recibo_egreso' accept='application/pdf'></x-file-pond>
                        @error("recibo_egreso")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='registrar_recibo_pago_egreso' class="btn btn-outline-success">Guardar</button>
                <button class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-registrar-recibo-egreso', event => {
        $(".modal-registrar-recibo-egreso").modal("show")
    })

    window.addEventListener('cerrar-modal-registrar-recibo-egreso', event => {
        $(".modal-registrar-recibo-egreso").modal("hide")
    })
</script>

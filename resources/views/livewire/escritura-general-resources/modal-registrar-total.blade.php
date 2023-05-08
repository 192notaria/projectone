<div wire:ignore.self class="modal fade modal-registrar-total"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Registrar Costo Total</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 mb-2 mt-2">
                        <label for="">Costo total</label>
                        <input type="number" class="form-control" wire:model='costo_total_escritura'>
                        @error("costo_total_escritura")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='registrar_costo_total' class="btn btn-outline-success">Guardar</button>
                <button class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-registrar-total', event => {
        $(".modal-registrar-total").modal("show")
    })

    window.addEventListener('cerrar-modal-registrar-total', event => {
        $(".modal-registrar-total").modal("hide")
    })
</script>

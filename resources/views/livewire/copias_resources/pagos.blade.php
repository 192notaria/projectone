<div wire:ignore.self class="modal fade modal-pagos"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Registrar pago</h5>
            </div>
            <div class="modal-body">
                <div class="row gx-3 gy-3">
                    <div class="col-lg-12">
                        <div class="form-check form-check-primary form-check-inline">
                            <input wire:model='factura' class="form-check-input" type="checkbox" id="form-check-default">
                            <label class="form-check-label" for="form-check-default">
                                Factura
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <label for="">Metodo de pago</label>
                        <select class="form-select" wire:model='metodo_pago'>
                            <option value="" selected disabled>Seleccionar</option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia">Transferencia</option>
                        </select>
                        @error("metodo_pago")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12">
                        <label for="">Descripción</label>
                        <textarea wire:model='descripcion' class="form-control" cols="30" rows="5"></textarea>
                        @error("descripcion")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="text-danger me-3" data-bs-dismiss="modal">Cancelar</a>
                <button wire:loading.attr='disabled' wire:click='registrar_pago' class="btn btn-outline-success">Registrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-pagos', event => {
        $(".modal-pagos").modal("show")
    })

    window.addEventListener('cerrar-modal-pagos', event => {
        $(".modal-pagos").modal("hide")
    })
</script>

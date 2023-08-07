<div wire:ignore.self class="modal fade modal-recibo-pago"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Registrar recibo de pago</h5>
            </div>
            <div class="modal-body">
                <div class="row gx-3 gy-3">
                    <div class="col-lg-12 table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Monto</th>
                                    <th class="text-center">Descripción</th>
                                    <th class="text-center">Factura</th>
                                    <th class="text-center">Metodo de pago</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($pago_data)
                                    <tr>
                                        <td class="text-center">{{$pago_data->monto}}</td>
                                        <td class="text-center">{{$pago_data->descripcion}}</td>
                                        <td class="text-center">{{$pago_data->factura ? "Si" : "No"}}</td>
                                        <td class="text-center">{{$pago_data->metodo_pago == "Efectivo" ? "Efectivo" : "Transferencia"}}</td>
                                        <td class="text-center">
                                            <button wire:click='descargar_recibo({{$pago_data->id}})' class="btn btn-outline-dark"><i class="fa-solid fa-file-arrow-down"></i></button>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-12">
                        <label for="">Recibo de pago firmado</label>
                        <x-file-pond wire:model='recibo_input'></x-file-pond>
                        @error("recibo_input")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="text-danger me-3" data-bs-dismiss="modal">Cancelar</a>
                <button wire:loading.attr='disabled' wire:click='registrar_recibo' class="btn btn-outline-success">Registrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-recibo-pago', event => {
        $(".modal-recibo-pago").modal("show")
    })

    window.addEventListener('cerrar-modal-recibo-pago', event => {
        $(".modal-recibo-pago").modal("hide")
    })
</script>

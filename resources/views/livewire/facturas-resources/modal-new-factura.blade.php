<div wire:ignore.self class="modal fade modal-new-factura"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-between" style="width: 100%;">
                    <h5>Nueva Factura</h5>
                </div>
            </div>
            <div class="modal-body">
                <div class="row gx-3 gy-3">
                    <div class="col-lg-12">
                        <div class="form-group autocomplete">
                            <label for="">Buscar escritura</label>
                            <input wire:model='buscarEscrituraInput' type="text" class="form-control" placeholder="Buscar...">
                            <div class="autocomplete-items">
                                @foreach ($buscar_escrituras as $escritura)
                                    <a wire:click='asignar_escritura({{$escritura->id}})'>
                                        <div>
                                            <strong>
                                                {{$escritura->servicio->nombre}} - {{$escritura->numero_escritura}}
                                            </strong>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <style>
                        .red-border{
                            border: 1px solid rgb(154, 0, 0) !important;
                        }

                        .green-border {
                            border: 1px solid rgb(0, 126, 0) !important;
                        }
                    </style>
                    <div class="col-lg-12">
                        <div class="form-group autocomplete">
                            <label for="">Cliente </label>
                            <input wire:keydown='limpiarCliente' wire:model='clienteInput' type="text" class="form-control @if($cliente_data) green-border @endif @if(!$cliente_data) red-border @endif">
                            <div class="autocomplete-items">
                                @foreach ($buscar_clientes as $cliente)
                                    <a wire:click='cambiar_cliente({{$cliente->id}})'>
                                        <div>
                                            <strong>
                                                {{$cliente->nombre}} {{$cliente->apaterno}} {{$cliente->amaterno}}
                                            </strong>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label for="">RFC</label>
                        <input wire:model='rfcInput' type="text" class="form-control @if($rfcInput) green-border @endif @if(!$rfcInput) red-border @endif">
                    </div>
                    <div class="col-lg-6">
                        <label for="">Escritura</label>
                        <input wire:model='escrituraInput' type="text" class="form-control @if($escritura_data) green-border @endif @if(!$escritura_data) red-border @endif">
                    </div>
                    <div class="col-lg-12 mt-5 text-center">
                        <h4>Detalles de la factura</h4>
                    </div>
                    <div class="col-lg-4">
                        <label for="">Folio</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-lg-4">
                        <label for="">Monto</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-lg-4">
                        <label for="">Fecha</label>
                        <input type="datetime-local" class="form-control">
                    </div>
                    <div class="col-lg-6">
                        <label for="">Concepto</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="col-lg-6">
                        <label for="">Origen</label>
                        <select class="form-select">
                            <option value="" selected disabled>Seleccionar...</option>
                            <option value="Emitida">Emitida</option>
                            <option value="Recibida">Recibida</option>
                        </select>
                    </div>
                    <div class="col-lg-12">
                        <label for="">Observaciones</label>
                        <textarea class="form-control" cols="30" rows="5"></textarea>
                    </div>
                    <div class="col-lg-6">
                        <label for="">PDF</label>
                        <x-file-pond></x-file-pond>
                    </div>
                    <div class="col-lg-6">
                        <label for="">XML</label>
                        <x-file-pond></x-file-pond>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='crear_proyecto' class="btn btn-outline-success">
                    Guardar
                </button>
                <button class="btn btn-outline-danger" data-bs-dismiss="modal">
                    Cerrar
                </button>
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
    window.addEventListener('abrir-modal-new-factura', event => {
        $(".modal-new-factura").modal("show")
    })

    window.addEventListener('cerrar-modal-new-factura', event => {
        $(".modal-new-factura").modal("hide")
    })
</script>

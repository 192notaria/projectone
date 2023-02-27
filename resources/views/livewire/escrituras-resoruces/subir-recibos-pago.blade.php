<div style="z-index: 10000;" wire:ignore.self class="modal fade modal-subir-recibos-pago"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <label for="">Tipo de documento</label>
                        <select class="form-select" wire:model='tipo_documento'>
                            <option value="" disabled selected>Seleccionar...</option>
                            @foreach ($catalogo_documentos as $doc)
                                <option value="{{$doc->id}}">{{$doc->nombre}}</option>
                            @endforeach
                        </select>
                        @error('tipo_documento')
                            <span class="badge badge-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="form-group">
                            <label for="">Pago del recibo</label>
                            <input wire:model='gasto_recibo' wire:keyup='calcularTotal' type="text" class="form-control" placeholder="0.0">
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="form-group">
                            <label for="">Gastos de gestoria</label>
                            <input wire:model='gasto_gestoria' wire:keyup='calcularTotal' type="text" class="form-control" placeholder="0.0">
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <span class="badge badge-success">Total: {{$gasto_total}}</span>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Recibo de pago</label>
                            <x-file-pond wire:model='recibo_de_pago' name='recibo_de_pago' accept='application/pdf'
                                :options="['labelIdle' => 'Cargar un archivo... o arrastra y suelta']">
                            </x-file-pond>
                            @error('recibo_de_pago')
                                <span class="badge badge-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                <button wire:click='guardarRecbio' class="btn btn-outline-success">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-subir-recibos-pago', event => {
        $(".modal-subir-recibos-pago").modal("show")
    })

    window.addEventListener('cerrar-modal-subir-recibos-pago', event => {
        $(".modal-subir-recibos-pago").modal("hide")
    })
</script>

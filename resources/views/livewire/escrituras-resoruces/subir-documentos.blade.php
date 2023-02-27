<div style="z-index: 10000;" wire:ignore.self class="modal fade modal-subir-documentos"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
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
                    </div>
                    <div class="col-lg-12 mb-3">
                        <label for="">Importar documento</label>
                        <x-file-pond wire:model='documento_pdf' name='documento_pdf' accept='application/pdf, application/msword'
                            :options="['labelIdle' => 'Cargar un archivo... o arrastra y suelta']">
                        </x-file-pond>
                        @error('documentError')
                            <span style="width: 100%;" class="badge badge-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                <button @if (!$documento_pdf || !$tipo_documento) disabled @endif wire:click='importarDocumentoGeneral' class="btn btn-outline-success">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-subir-documentos', event => {
        $(".modal-subir-documentos").modal("show")
    })

    window.addEventListener('cerrar-modal-subir-documentos', event => {
        $(".modal-subir-documentos").modal("hide")
    })
</script>

<div wire:ignore.self class="modal fade modal-agregar-documentos"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-between" style="width: 100%;">
                    <h5>Registrar Documentos</h5>
                </div>
            </div>
            <div class="modal-body">
                <div class="row gx-3 gy-3">
                    <div class="col-lg-12">
                        <label for="">Tipo de documento</label>
                        <select class="form-select" wire:model='tipo_doc_upload'>
                            <option value="" selected disabled>Seleccionar...</option>
                            @foreach ($tipo_docs as $tipo)
                                <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-12">
                        <label for="">Documento</label>
                        <x-file-pond wire:model='document_upload'></x-file-pond>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a wire:click='limpiarVariables' href="#" data-bs-dismiss="modal" class="me-4">
                    Cancelar
                </a>
                <button wire:click='uploadDocument' class="btn btn-danger" wire:click='registrar_declaracion'>
                    Guardar
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
    window.addEventListener('abrir-modal-agregar-documentos', event => {
        $(".modal-agregar-documentos").modal("show")
    })

    window.addEventListener('cerrar-modal-agregar-documentos', event => {
        $(".modal-agregar-documentos").modal("hide")
    })
</script>

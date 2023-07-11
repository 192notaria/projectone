<div wire:ignore.self class="modal fade upload-general-docs"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Documentos</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <button wire:click='upload_doc_view("filepond")' class="btn btn-primary"><i class="fa-solid fa-plus"></i></button>
                            </div>
                            <div class="card-body">
                                @if ($vista == 'filepond')
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label for="">Tipo de documento</label>
                                            <select class="form-select" wire:model='tipo_doc'>
                                                <option value="" selected disabled>Seleccionar...</option>
                                                @foreach ($catalogo_documentos_generales as $cat_docs)
                                                    <option value="{{$cat_docs->nombre}}">{{$cat_docs->nombre}}</option>
                                                @endforeach
                                            </select>
                                            @error('tipo_doc')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-12 mt-4">
                                            <input type="file" class="form-control" wire:model='cliente_doc'>
                                            @error('cliente_doc')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-12 mt-4">
                                            <div class="d-flex justify-content-end">
                                                <button wire:click='upload_doc' class="btn btn-success me-1">Importar</button>
                                                <button wire:click='upload_doc_view("table")' class="btn btn-danger">Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($vista == 'table')
                                    <table class="table table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Tipo</th>
                                                <th>Fecha</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <style>
                                                .text-overflow{
                                                    white-space: nowrap;
                                                    overflow: hidden;
                                                    text-overflow: ellipsis;
                                                }
                                            </style>
                                            @if ($cliente_activo)
                                                @forelse ($cliente_activo->documentos as $docs)
                                                    <tr>
                                                        <td style="max-width: 100px;" class="text-overflow">
                                                            <a href="{{url($docs->path)}}" target="_blank">
                                                                {{$docs->nombre}}
                                                            </a>
                                                        </td>
                                                        <td>{{$docs->tipo}}</td>
                                                        <td>{{$docs->created_at}}</td>
                                                        <td>
                                                            <button class="btn btn-danger" wire:click='remove_doc({{$docs->id}})'>
                                                                <i class="fa-solid fa-circle-minus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="3" class="text-center">Sin registros...</td>
                                                    </tr>
                                                @endforelse
                                            @endif
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('open-upload-general-docs', event => {
        $(".upload-general-docs").modal("show")
    })

    window.addEventListener('close-upload-general-docs', event => {
        $(".upload-general-docs").modal("hide")
    })
</script>

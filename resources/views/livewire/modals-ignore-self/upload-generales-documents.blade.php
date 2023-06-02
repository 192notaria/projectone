<div wire:ignore.self class="modal fade upload-general-docs"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Importar documentos</h5>
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($cliente_activo)
                                                @forelse ($cliente_activo->documentos as $docs)
                                                    <tr>
                                                        <td>
                                                            <a href="{{url($docs->path)}}" target="_blank">
                                                                {{$docs->nombre}}
                                                            </a>
                                                        </td>
                                                        <td>{{$docs->tipo}}</td>
                                                        <td>{{$docs->created_at}}</td>
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
        var myAudio= document.createElement('audio');
        myAudio.src = "{{ url("/v3/src/assets/audio/notification.mp3") }}";
        myAudio.play();

        Snackbar.show({
            text: event.detail,
            actionTextColor: '#fff',
            backgroundColor: '#00ab55',
            pos: 'top-center',
            duration: 5000,
            actionText: '<i class="fa-solid fa-circle-xmark"></i>'
        });
    })
</script>

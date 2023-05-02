<div class="card">
    <div class="card-header">
        <h5>
            {{$subprocesos_info->nombre}}
            {{$subprocesos_info->tipo_id}}
            - {{$subproceso_activo->id}}

            @if ($subproceso_activo->avance($proyecto_id, $proceso_activo))
                <i class="fa-solid fa-circle-check text-success"></i>
            @endif

        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            @if (!$subproceso_activo->avance($proyecto_id, $proceso_activo))
                <div class="col-lg-12 mt-2">
                    <x-file-pond wire:loading.attr="disabled" multiple wire:model='documents_to_upload' name='documents_to_upload' accept='application/pdf, application/docx, application/doc'
                        :options="['labelIdle' => 'Cargar archivos... o arrastra y suelta']">
                    </x-file-pond>
                </div>
                @error('documents_to_upload') <span class="badge badge-danger">{{ $message }}</span> @enderror
                <div class="col-lg-12">
                    <button wire:loading.attr="disabled" @if ($documents_to_upload == []) disabled @endif class="btn btn-outline-info" wire:click='uploadDocuments'>
                        <span wire:loading.remove>Importar documentos <i class="fa-solid fa-cloud-arrow-up"></i></span>
                        <span wire:loading><div class="spinner-border text-primary align-self-center "></div></span>
                    </button>
                </div>
            @endif

            <style>
                .td-max-size{
                    max-width: 200px !important;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }
            </style>
            <div class="col-lg-12 table-responsive mb-2 mt-2">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo de documento</th>
                            @if (!$subproceso_activo->avance($proyecto_id, $proceso_activo))
                                <th></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documentos as $doc)
                            <tr>
                                <td class="td-max-size">
                                    <a target="_blank" href="{{url($doc->storage)}}">
                                        {{$doc->nombre}}
                                    </a>
                                </td>
                                <td class="td-max-size">{{$doc->tipoDoc->nombre}}</td>
                                @if (!$subproceso_activo->avance($proyecto_id, $proceso_activo))
                                    <td>
                                        <button wire:click='removerDocumento({{$doc->id}})' class="btn btn-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if (!$subproceso_activo->avance($proyecto_id, $proceso_activo) && count($documentos) > 0)
        <div class="card-footer">
            <button wire:click='guardarAvance' class="btn btn-success">Guardar avance</button>
        </div>
    @endif
</div>

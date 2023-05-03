<div class="card">
    <div class="card-header">
        <h5>
            {{$subprocesos_info->nombre}}
            {{-- {{$subprocesos_info->tipo_id}}
            - {{$subproceso_activo->id}} --}}

            @if ($subproceso_activo->avance($proyecto_id, $proceso_activo))
                <i class="fa-solid fa-circle-check text-success"></i>
            @endif

        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            @if (!$subproceso_activo->avance($proyecto_id, $proceso_activo))
                <div class="col-lg-12">
                    <div class="form-group autocomplete">
                        <input wire:model='buscar_cliente' type="text" class="form-control" placeholder="Buscar en lista de clientes...">
                        @error('cliente-ya-asignado')
                            <span class="badge badge-danger mb-1 mt-1">{{$message}}</span>
                        @enderror
                        <div class="autocomplete-items">
                            @foreach ($clientes as $cliente)
                                <a wire:click='registrarGeneral({{$cliente->id}})'>
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
            @endif
            <div class="col-lg-12 table-responsive mt-2 mb-2">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fehca de registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($generales) > 0)
                            @foreach ($generales as $general)
                                <tr>
                                    <td>
                                        {{$general->cliente->nombre}}
                                        {{$general->cliente->apaterno}}
                                        {{$general->cliente->amaterno}}
                                    </td>
                                    <td>{{$general->created_at}}</td>
                                    <td class="text-center">
                                        <div class="btn-group mb-2 me-4">
                                            @if (!$subproceso_activo->avance($proyecto_id, $proceso_activo))
                                                <button title="Remover cliente" wire:click='removerGenerales({{$general->id}})' type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                            @endif
                                                <button title="Importar documento" wire:click='subirDocumentoModalGeneral({{$general->cliente->id}})' type="button" class="btn btn-outline-success"><i class="fa-solid fa-plus"></i></button>
                                            @if (count($general->cliente->documentosGenerales) > 0)
                                                <button title="Documentos registrados" type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa-solid fa-angle-down"></i>
                                                    <span class="visually-hidden ">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @foreach ($general->cliente->documentosGenerales as $doc)
                                                        <a target="_blank" class="dropdown-item" href="{{url($doc->storage)}}">{{$doc->tipoDoc->nombre}}</a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="text-center">
                                    <div class="badge badge-warning" style="width: 100%;">Sin registros</div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer">
        @if (!$subproceso_activo->avance($proyecto_id, $proceso_activo) && count($generales) > 0)
            <button wire:click='guardarAvance' class="btn btn-success">Guardar avance</button>
        @endif
    </div>
</div>

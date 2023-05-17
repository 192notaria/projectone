<div class="card">
    <div class="card-header">
        <div style="display:flex; justify-content: space-between;">
            <div class="flex-item">
                @can("crear-declaracion")
                    <button wire:click='abrir_modal_declaracion' style="height: 100%;" type="button" class="btn btn-outline-primary me-2">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                @endcan
            </div>
            <div class="flex-item" style="width: 100%;">
                <div style="display:flex; justify-content:end;">
                    <select style="width: 10%;" wire:model='cantidadDeclaraciones' class="form-select">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <style>
                .modal{
                    backdrop-filter: blur(5px);
                    background-color: #01223770;
                    -webkit-animation: fadeIn 0.3s;
                }

                @keyframes fadeIn {
                    0% { opacity: 0; }
                    100% { opacity: 1; }
                }

                @keyframes fadeOut {
                    0% { opacity: 1; }
                    100% { opacity: 0; }
                }

                .autocomplete {
                    position: relative;
                    display: inline-block;
                    width: 100%;
                }

                .autocomplete-items {
                    position: absolute;
                    border: 1px solid #d4d4d4;
                    border-bottom: none;
                    border-top: none;
                    z-index: 99;
                    top: 100%;
                    left: 0;
                    right: 0;
                }

                .autocomplete-items div {
                    padding: 10px;
                    cursor: pointer;
                    border-bottom: 1px solid #d4d4d4;
                    background-color: #ffff;
                }

                .autocomplete-items div:hover {
                    background-color: #e9e9e9;
                }

                .active_drag{
                    cursor: grabbing;
                }
            </style>
            <div class="col-lg-12 table-responsive drag" style="cursor: grab;">
                <table class="table table-striped" id="my_table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Escritura</th>
                            <th>Usuario</th>
                            <th>Observaciones</th>
                            <th>Documentos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($declaraciones as $declaracion)
                            <tr>
                                <td>{{$declaracion->fecha}}</td>
                                <td>
                                    {{$declaracion->escritura->servicio->nombre}} -
                                    {{$declaracion->escritura->cliente->nombre}} {{$declaracion->escritura->cliente->apaterno}} {{$declaracion->escritura->cliente->amaterno}} -
                                    #{{$declaracion->escritura->numero_escritura}}
                                </td>
                                <td>
                                    {{$declaracion->usuario->name}}
                                </td>
                                <td>{{$declaracion->observaciones}}</td>
                                <td>
                                    <div class="avatar--group avatar-group-badge">
                                        @foreach ($declaracion->documentos as $doc)
                                            <div class="avatar avatar-sm">
                                                <a href="{{url($doc->path)}}" target="_blank">
                                                    <span class="avatar-title rounded-circle">
                                                        <i class="fa-solid fa-file-pdf"></i>
                                                    </span>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Sin registros...</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{$declaraciones->links('pagination-links')}}
            </div>
        </div>
    </div>
    @include("livewire.declaraciones-resources.modal-new-declaracion")
</div>

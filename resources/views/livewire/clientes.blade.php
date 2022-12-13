<div class="card">
    <div class="card-header">
        <div style="display:flex; align-items:right;">
            @can('crear-clientes')
                {{-- <button type="button" wire:click='openModal' class="btn btn-outline-success">
                    <i class="fa-solid fa-user-plus"></i>
                </button> --}}
                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">
                    <i class="fa-solid fa-user-plus"></i>
                </button>
            @endcan
            <select class="form-select" style="width: 5%; margin-left: 5px; margin-right: 5px;">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
            <input style="width: 30%" wire:model="search" type="text" class="form-control" placeholder="Buscar...">
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

                .autocomplete-items-2 {
                    position: absolute;
                    border: 1px solid #d4d4d4;
                    border-bottom: none;
                    border-top: none;
                    z-index: 99;
                    top: 100%;
                    left: 0;
                    right: 0;
                }

                .autocomplete-items-2 .abogadolist {
                    padding: 10px;
                    cursor: pointer;
                    border-bottom: 1px solid #d4d4d4;
                    background-color: #ffff;
                }

                .autocomplete-items-2 .abogadolist:hover {
                    background-color: #e9e9e9;
                }

                .autocomplete-active {
                    background-color: DodgerBlue !important;
                    color: #ffffff;
                }

                .btn-outline-danger:hover{
                    background-color: #e7515a !important;
                    color: #ffffff !important;
                }

                .btn-outline-primary:hover{
                    background-color: #4361ee !important;
                    color: #ffffff !important;
                }
            </style>


            <div class="col-lg-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Genero / Estado Civil</th>
                            <th scope="col">Nacimiento</th>
                            <th scope="col">Datos personales</th>
                            @can('ver-domiciliosClientes')
                                <th scope="col">Domicilio</th>
                            @endcan
                            <th scope="col"></th>
                        </tr>
                        <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                    </thead>
                    <tbody>
                        @if (count($clientes) > 0)
                            @foreach ($clientes as $cliente)
                                <tr>
                                    <td>
                                        <div class="media">
                                            <div class="avatar me-2">
                                                <img alt="avatar" src="{{$cliente->genero == "Masculino" ? url('v3/src/assets/img/male-avatar.svg') : url('v3/src/assets/img/female-avatar.svg')}}" class="rounded-circle" />
                                            </div>
                                            <div class="media-body align-self-center">
                                                <h6 class="mb-0">{{$cliente->nombre}} {{$cliente->apaterno}} {{$cliente->amaterno}}</h6>
                                                @can("crear-proyectos")
                                                    @if (isset($cliente->domicilio->id))
                                                        <button wire:click='openModalNuevoProyecto({{$cliente->id}})' class="btn btn-outline-success mb-2 me-4"><i class="fa-solid fa-circle-plus"></i></button>
                                                    @endif
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0">
                                            <h5>
                                                @if ($cliente->genero == "Masculino")
                                                    <span class="badge badge-info">{{$cliente->genero}}</span>
                                                @else
                                                    <span class="badge badge-secondary">{{$cliente->genero}}</span>
                                                @endif
                                            </h5>
                                        </p>
                                        <p class="mb-0">
                                            <h5>
                                                @if ($cliente->estado_civil == "Casado")
                                                    <span class="badge badge-danger">{{$cliente->estado_civil}}</span>
                                                @else
                                                    <span class="badge badge-success">{{$cliente->estado_civil}}</span>
                                                @endif
                                            </h5>
                                        </p>
                                    </td>
                                    <td>
                                        <p class="mb-0">
                                            @if (isset($cliente->getMunicipio->getEstado->nombre))
                                                <span class="fw-bold">Lugar de nacimiento: </span><br>{{$cliente->getMunicipio->nombre}}, {{$cliente->getMunicipio->getEstado->nombre}}, {{$cliente->getMunicipio->getEstado->getPais->nombre}}
                                            @else
                                                <span class="fw-bold">Lugar de nacimiento: </span><br> <span class="text-danger">Sin registro</span>
                                            @endif
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bold">Fecha de nacimiento: </span><br>{{$cliente->fecha_nacimiento}}
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bold">Edad: </span><br>{{\Carbon\Carbon::parse($cliente->fecha_nacimiento)->diff(\Carbon\Carbon::now())->format('%y')}}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="mb-0">
                                            <span class="fw-bold">CURP:</span><br>{{$cliente->curp}}
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bold">RFC:</span><br>{{$cliente->rfc}}
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bold">Correo:</span><br>{{$cliente->email}}
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bold">Télefono:</span><br>{{$cliente->telefono}}
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bold">Ocupacion:</span><br>{{$cliente->getOcupacion->nombre}}
                                        </p>
                                    </td>

                                    @can('ver-domiciliosClientes')
                                        <td>
                                            @if (isset($cliente->domicilio->calle))
                                                <span class="fw-bold">Calle: </span>{{$cliente->domicilio->calle}}<br>
                                                <span class="fw-bold">Numero Exterior: </span>{{$cliente->domicilio->numero_ext}}, <span class="fw-bold">Numero Interior: </span>{{$cliente->domicilio->numero_int}}<br>
                                                <span class="fw-bold">Colonia y Municipio:</span>{{$cliente->domicilio->getColonia->nombre}}, {{$cliente->domicilio->getColonia->getMunicipio->nombre}}<br>
                                                <span class="fw-bold">Estado y pais: </span>
                                                @if (isset($cliente->domicilio->getColonia->getMunicipio->getEstado->nombre))
                                                    {{$cliente->domicilio->getColonia->getMunicipio->getEstado->nombre}},
                                                @else
                                                    <span class="text-danger">No hay estado registrado</span>
                                                @endif
                                                @if (isset($cliente->domicilio->getColonia->getMunicipio->getEstado->getPais->nombre))
                                                    <span>{{$cliente->domicilio->getColonia->getMunicipio->getEstado->getPais->nombre}}</span>
                                                @else
                                                    <span class="text-danger">No hay pais registrado</span>
                                                @endif
                                                <br>
                                                <span class="fw-bold">Codigo postal: </span>{{$cliente->domicilio->getColonia->codigo_postal}}
                                                <br>
                                                @can('editar-domiciliosClientes')
                                                    <button wire:click='editarDomicilio({{$cliente->domicilio->id}}, {{$cliente->id}})' class="btn btn-outline-info">Editar domicilio <i class="fa-solid fa-pen-to-square"></i></button>
                                                @endcan
                                            @else
                                                @can('crear-domiciliosClientes')
                                                    <button wire:click='openModalDomicilios({{$cliente->id}})' class="btn btn-outline-success">Agregar domicilio <i class="fa-solid fa-circle-plus"></i></button>
                                                @endcan
                                            @endif
                                            {{-- @if (count($cliente->getDomicilio) > 0)

                                            @else
                                                <span class="fw-bold">Calle: </span>{{$cliente->getDomicilio}}<br>
                                                <button wire:click='openModalDomicilios({{$cliente->id}})' class="btn btn-outline-success">Agregar domicilio <i class="fa-solid fa-circle-plus"></i></button>
                                            @endif --}}
                                        </td>
                                    @endcan

                                    <td class="text-center">
                                        <div class="action-btns">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                @can('editar-clientes')
                                                    <button wire:click='editarCliente({{$cliente->id}})' type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                @endcan
                                                @can('borrar-clientes')
                                                    <button wire:click='SelectBorrarCliente({{$cliente->id}})' data-bs-toggle="modal" data-bs-target="#deleteCliente" type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <td colspan="6" class="text-center">
                                Sin registros...
                            </td>
                        @endif
                    </tbody>
                </table>
                {{$clientes->links('pagination-links')}}
            </div>

            @include('livewire.modals.nuevoCliente')
            @include('livewire.modals.nuevo-cliente')
            @include('livewire.modals.domicilioCliente')
            @include('livewire.modals.nuevProyectoCliente')
            @include('livewire.modals.borrarCliente')
        </div>
    </div>
</div>

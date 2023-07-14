<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h3>Clientes</h3>
            @can('crear-clientes')
                <button wire:loading.attr='disabled' type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">
                    Nuevo registro <i class="fa-solid fa-user-plus"></i>
                </button>
            @endcan
        </div>
    </div>
    <div class="card-body">
        <div class="row gx-3">
            <div class="col-lg-12 d-flex justify-content-between">
                <div>
                    <select wire:model='cantidadClientes' class="form-select" style="width: 80px;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div style="width: 30%">
                    {{-- <input wire:model="search" type="text" class="form-control" placeholder="Buscar..."> --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </span>
                        <input wire:model="search" type="text" class="form-control" placeholder="Busqueda rapida" aria-label="notification" aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>
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
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Télefono</th>
                            <th scope="col">Correo</th>
                            @can('ver-domiciliosClientes')
                                <th scope="col">Domicilio</th>
                            @endcan
                            <th scope="col">Acciones</th>
                        </tr>
                        <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                    </thead>
                    <tbody>
                        @if (count($clientes) > 0)
                            @foreach ($clientes as $cliente)
                                <tr>
                                    <td>
                                        <div class="media">
                                            {{-- <div class="avatar avatar-sm me-2">
                                                @if ($cliente->tipo_cliente == "Persona Moral")
                                                    <span class="avatar-title badge bg-success rounded-circle">{{substr(strtoupper($cliente->razon_social), 0, 2)}}</span>
                                                @else
                                                    <span class="avatar-title badge bg-primary rounded-circle">{{substr(strtoupper($cliente->nombre), 0, 2)}}</span>
                                                @endif
                                            </div> --}}
                                            <div class="media-body align-self-center">
                                                @if ($cliente->tipo_cliente == "Persona Moral")
                                                    <span class="mb-0">{{$cliente->razon_social}}</span>
                                                    {{-- <span class="badge badge-primary">
                                                        {{$cliente->admin_unico}}
                                                    </span> --}}
                                                @else
                                                    @if ($cliente->validarData($cliente->id))
                                                        <a href="#" wire:click='open_warning_modal'>
                                                            <span class="badge badge-danger" style="width: 25px; height: 25px; border-radius: 100%;">
                                                                <i class="fa-solid fa-exclamation"></i>
                                                            </span>
                                                        </a>
                                                    @endif
                                                    <span class="mb-0 me-1">
                                                        {{$cliente->nombre}} {{$cliente->apaterno}} {{$cliente->amaterno}}
                                                    </span>
                                                @endif
                                                    {{-- <p class="mb-0">
                                                    <h5>
                                                        @if ($cliente->genero == "Masculino")
                                                            <span class="badge badge-info">{{$cliente->genero}}</span>
                                                        @else
                                                            <span class="badge badge-secondary">{{$cliente->genero}}</span>
                                                        @endif
                                                    </h5>
                                                </p> --}}
                                                {{-- <p class="mb-0">
                                                    <h5>
                                                        @if ($cliente->estado_civil == "Casado")
                                                            <span class="badge badge-danger">{{$cliente->estado_civil}}</span>
                                                        @else
                                                            <span class="badge badge-success">{{$cliente->estado_civil}}</span>
                                                        @endif
                                                    </h5>
                                                </p> --}}
                                            </div>
                                        </div>
                                    </td>
                                    {{-- <td>
                                        @if ($cliente->representante_inst)
                                            <span class="text-danger">Sin informacion</span>
                                        @else
                                            <p class="mb-0">
                                                @if (isset($cliente->getMunicipio->getEstado->nombre))
                                                    <span class="fw-bold">Lugar de nacimiento: </span><br>{{$cliente->getMunicipio->nombre}}, {{$cliente->getMunicipio->getEstado->nombre}}, {{$cliente->getMunicipio->getEstado->getPais->nombre}}
                                                @else
                                                    <span class="fw-bold">Lugar de nacimiento: </span><br> <span>Sin registro</span>
                                                @endif
                                            </p>
                                            <p class="mb-0">
                                                <span class="fw-bold">Fecha de nacimiento: </span><br>{{$cliente->fecha_nacimiento}}
                                            </p>
                                            <p class="mb-0">
                                                <span class="fw-bold">Edad: </span><br>{{\Carbon\Carbon::parse($cliente->fecha_nacimiento)->diff(\Carbon\Carbon::now())->format('%y')}}
                                            </p>
                                        @endif

                                    </td> --}}
                                    <td class="text-center">
                                        <span>{!! $cliente->telefono == '' ? "<span class='text-danger'>S/R</span>" : $cliente->telefono !!}</span>
                                        {{-- @if ($cliente->representante_inst)
                                        @else
                                            <p class="mb-0">
                                                <span class="fw-bold">CURP:</span><br>{{$cliente->curp ?? "Sin registro"}}
                                            </p>
                                            <p class="mb-0">
                                                <span class="fw-bold">RFC:</span><br>{{$cliente->rfc ?? "Sin registro"}}
                                            </p>
                                            <p class="mb-0">
                                                <span class="fw-bold">Correo:</span><br>{{$cliente->email ?? "Sin registro"}}
                                            </p>
                                            <p class="mb-0">
                                                <span class="fw-bold">Télefono:</span><br>{{$cliente->telefono ?? "Sin registro"}}
                                            </p>
                                            <p class="mb-0">
                                                <span class="fw-bold">Ocupacion:</span><br>{{$cliente->getOcupacion->nombre ?? "Sin registro"}}
                                            </p>
                                        @endif --}}
                                    </td>
                                    <td>
                                        <span>{!! $cliente->email == '' ? "<span class='text-danger'>S/R</span>" : $cliente->email !!}</span>
                                    </td>

                                    @can('ver-domiciliosClientes')
                                        <td>
                                        @if ($cliente->representante_inst)
                                            <span class="text-danger">Sin domicilio</span>
                                        @else
                                            @if (isset($cliente->domicilio->calle))
                                            <a href="#" wire:click='editarDomicilio({{$cliente->domicilio->id}}, {{$cliente->id}})'>
                                                <span>
                                                    {{$cliente->domicilio->calle}},
                                                    {{$cliente->domicilio->numero_ext}},
                                                    {{$cliente->domicilio->getColonia->codigo_postal}},
                                                    {{$cliente->domicilio->getColonia->nombre}},
                                                    {{$cliente->domicilio->getColonia->getMunicipio->nombre ?? "Sin municipio"}},
                                                    {{$cliente->domicilio->getColonia->getMunicipio->getEstado->nombre ?? "Sin Estado"}}
                                                </span>
                                            </a>
                                                {{-- <span class="fw-bold">Calle: </span>{{$cliente->domicilio->calle}}<br>
                                                <span class="fw-bold">Numero Exterior: </span>{{$cliente->domicilio->numero_ext}}, <span class="fw-bold">Numero Interior: </span>{{$cliente->domicilio->numero_int}}<br>
                                                <span class="fw-bold">Colonia y Municipio:</span>
                                                @if (isset($cliente->domicilio->getColonia->nombre))
                                                    {{$cliente->domicilio->getColonia->nombre}},
                                                @else
                                                    <span class="text-danger">Sin colonia registrada, </span>
                                                @endif
                                                @if (isset($cliente->domicilio->getColonia->getMunicipio->nombre))
                                                    {{$cliente->domicilio->getColonia->getMunicipio->nombre}}
                                                @else
                                                    <span class="text-danger">Sin Municipio registrado</span>
                                                @endif
                                                <br>
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
                                                <span class="fw-bold">Codigo postal: </span>
                                                @if (isset($cliente->domicilio->getColonia->codigo_postal))
                                                    {{$cliente->domicilio->getColonia->codigo_postal}}
                                                @else
                                                    <span class="text-danger">Sin codigo postal</span>
                                                @endif
                                                <br> --}}
                                                {{-- @can('editar-domiciliosClientes')
                                                    <button wire:click='editarDomicilio({{$cliente->domicilio->id}}, {{$cliente->id}})' class="btn btn-outline-info">Editar domicilio <i class="fa-solid fa-pen-to-square"></i></button>
                                                @endcan --}}
                                            @else
                                                @can('crear-domiciliosClientes')
                                                    <button wire:loading.attr='disabled' wire:click='openModalDomicilios({{$cliente->id}})' class="btn btn-outline-success">Agregar domicilio <i class="fa-solid fa-circle-plus"></i></button>
                                                @endcan
                                            @endif
                                        @endif
                                        </td>
                                    @endcan

                                    <td class="text-center">
                                        <div class="action-btns">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                @can('editar-clientes')
                                                    <button wire:loading.attr='disabled'
                                                        @if ($cliente->representante_inst)
                                                            wire:click='editClienteInst({{$cliente->id}})'
                                                        @else
                                                            wire:click='editarCliente({{$cliente->id}})'
                                                        @endif
                                                        type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                @endcan
                                                @can('borrar-clientes')
                                                    <button wire:loading.attr='disabled' wire:click='SelectBorrarCliente({{$cliente->id}})' data-bs-toggle="modal" data-bs-target="#deleteCliente" type="button" class="btn btn-outline-dark"><i class="fa-solid fa-trash"></i></button>
                                                @endcan
                                                @can('subir-documentos-clientes')
                                                    <button wire:loading.attr='disabled' type="button" class="btn btn-outline-dark" wire:click='open_upload_docs({{$cliente->id}})'>
                                                        <i class="fa-solid fa-file"></i>
                                                    </button>
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
            </div>
            {{$clientes->links('pagination-links')}}
            {{-- @include('livewire.modals.nuevoCliente') --}}
            @include('livewire.clientes-resources.modal-warning')
            @include('livewire.modals-ignore-self.upload-generales-documents')
            @include('livewire.modals.nuevo-cliente')
            @include('livewire.modals.domicilioCliente')
            @include('livewire.modals.borrarCliente')
            @include('livewire.modals-ignore-self.nuevo-proyecto-clientes')
        </div>
    </div>
</div>

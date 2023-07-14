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
                <div class="d-flex justify-content-start">
                    <select wire:model='cantidadClientes' class="form-select mb-3 me-1">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                    <button class="btn btn-outline-dark mb-3"><i class="fa-solid fa-trash"></i></button>
                </div>
                <div>
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
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th scope="col"></th>
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
                                    <td class="text-center">
                                        <div class="form-check form-check-primary form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="form-check-default">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="media">
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
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span>{!! $cliente->telefono == '' ? "<span class='text-danger'>S/R</span>" : $cliente->telefono !!}</span>
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
                                                            {{$cliente->domicilio->getColonia->nombre}}
                                                        </span>
                                                    </a>
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

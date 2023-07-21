<div class="card">
    <div class="card-header">
        <div style="display:flex; align-items:right;">
            @can('crear-servicios')
                <button type="button" wire:click='openModalNew("","Nuevo Servicio")' class="btn btn-outline-success">
                    <i class="fa-solid fa-user-plus"></i>
                </button>
            @endcan
            <select wire:model='cantidadServicios' class="form-select" style="width: 5%; margin-left: 5px; margin-right: 5px;">
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
                    background-color: #fff;
                    border-bottom: 1px solid #d4d4d4;
                }

                .autocomplete-items div:hover {
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
                            <th scope="col">Servicio</th>
                            <th scope="col">Fecha de creacion</th>
                            <th scope="col">Procesos</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($servicios) > 0)
                            @foreach ($servicios as $servicio)
                                <tr>
                                    <td>
                                        <p><span class="text-primary fw-bold">Nombre: </span>{{$servicio->nombre}}</p>
                                        <p><span class="text-primary fw-bold">Firma del proyecto: </span>{{$servicio->tiempo_firma}} minutos</p>
                                    </td>
                                    <td>
                                        <p><i class="fa-solid fa-calendar"></i> {{$servicio->created_at}}</p>
                                    </td>
                                    <td>
                                        @if (count($servicio->procesos) > 0)
                                            <ul class="list-group">
                                                @foreach ($servicio->procesos as $key => $proceso)
                                                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                        {{$key + 1}}.- {{$proceso->nombre}}
                                                        @can('remover-proceso')
                                                            <a style="cursor: pointer;" wire:click='removerProceso({{$proceso->id}}, {{$servicio->id}})'>
                                                                <span class="badge badge-danger badge-pill">
                                                                    <i class="fa-sharp fa-solid fa-circle-xmark text-white"></i>
                                                                </span>
                                                            </a>
                                                        @endcan
                                                    </li>
                                                @endforeach
                                            </ul>
                                            @can('agregar-proceso')
                                                <button class="btn btn-primary mt-1" wire:click="openModalProcesos({{$servicio->id}})"><i class="fa-solid fa-circle-plus"></i></button>
                                            @endcan
                                        @else
                                            @can('agregar-proceso')
                                                <button class="btn btn-primary" wire:click="openModalProcesos({{$servicio->id}})">Agregar Proceso</button>
                                            @endcan
                                            @cannot('agregar-proceso')
                                                <button class="btn btn-primary" disabled>Agregar Proceso</button>
                                            @endcannot
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="action-btns">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                @can('editar-servicios')
                                                    <button wire:click='openModalNew({{$servicio->id}}, "Editar Servicio")' type="button" class="btn btn-outline-info"><i class="fa-solid fa-pen-to-square"></i></button>
                                                @endcan
                                                @cannot('editar-servicios')
                                                    <button type="button" class="btn btn-outline-info" disabled><i class="fa-solid fa-pen-to-square"></i></button>
                                                @endcannot
                                                @can('borrar-servicios')
                                                    <button wire:click='openModalBorrar({{$servicio->id}})' type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                                @endcan
                                                @cannot('borrar-servicios')
                                                    <button type="button" class="btn btn-outline-danger" disabled><i class="fa-solid fa-trash"></i></button>
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <td colspan="4" class="text-center">
                                Sin registros...
                            </td>
                        @endif
                    </tbody>
                </table>
                {{$servicios->links('pagination-links')}}
            </div>
        </div>
    </div>
    @include('livewire.modals.agregarProceso')
    @include('livewire.modals.nuevoServicio')
    @include('livewire.modals.borrarServicio')
</div>

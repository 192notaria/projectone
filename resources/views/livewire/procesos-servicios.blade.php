<div class="card">
    <div class="card-header">
        <div style="display:flex; align-items:right;">
            <button type="button" wire:click='openModal("","Nuevo Proceso")' class="btn btn-outline-success">
                <i class="fa-solid fa-user-plus"></i>
            </button>
            <select wire:model='cantidadProcesos' class="form-select" style="width: 5%; margin-left: 5px; margin-right: 5px;">
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
                            <th scope="col">Nombre</th>
                            <th scope="col">Fecha de creacion</th>
                            <th scope="col">Subprocesos</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($proceos_servicios) > 0)
                            @foreach ($proceos_servicios as $proceso)
                                <tr>
                                    <td>
                                        <p>{{$proceso->nombre}}</p>
                                    </td>
                                    <td>
                                        <p>{{$proceso->created_at}}</p>
                                    </td>
                                    <td>
                                        @if (count($proceso->subprocesos) > 0)
                                            <ul class="list-group">
                                                @foreach ($proceso->subprocesos as $key => $sub)
                                                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                        {{$key + 1}}: {{$sub->catalogosSubprocesos->nombre}}
                                                        <span class="badge badge-danger badge-pill">
                                                            <a wire:click='removeSubprocess({{$sub->id}})'>
                                                                <i class="fa-sharp fa-solid fa-circle-xmark text-white"></i>
                                                            </a>
                                                        </span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <button wire:click='openModalSubprocesos({{$proceso->id}})' class="btn btn-primary mt-1"><i class="fa-solid fa-circle-plus"></i></button>
                                        @else
                                            <button wire:click='openModalSubprocesos({{$proceso->id}})' class="btn btn-primary mt-1">Agregar Subproceso <i class="fa-solid fa-circle-plus"></i></button>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="action-btns">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button wire:click='openModal({{$proceso->id}}, "Editar Proceso")' type="button" class="btn btn-outline-info"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button wire:click='openModalBorrar({{$proceso->id}})' type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <td colspan="3" class="text-center">
                                Sin registros...
                            </td>
                        @endif
                    </tbody>
                </table>
                {{$proceos_servicios->links('pagination-links')}}
            </div>

            @include("livewire.modals.nuevoproceso")
            @include("livewire.modals.agregarSubproceso")
            @include("livewire.modals.borrarProceso")
        </div>
    </div>
</div>

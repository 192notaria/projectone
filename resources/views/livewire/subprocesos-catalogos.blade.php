<div class="card">
    <div class="card-header">
        <div style="display:flex; align-items:right;">
            <button type="button" wire:click='openModal' class="btn btn-outline-success">
                <i class="fa-solid fa-user-plus"></i>
            </button>
            <select wire:model='cantidadSubprocesos' class="form-select" style="width: 5%; margin-left: 5px; margin-right: 5px;">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
            <input style="width: 30%" wire:model="buscarSubproceso" type="text" class="form-control" placeholder="Buscar...">
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
                            <th scope="col">Tipo de informacion</th>
                            <th scope="col">Fecha de creación</th>
                            <th scope="col"></th>
                        </tr>
                        <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                    </thead>
                    <tbody>
                        @if (count($subprocesosList) > 0)
                            @foreach ($subprocesosList as $subproceso)
                                <tr>
                                    <td>
                                        <h6 class="mb-0">{{$subproceso->nombre}}</h6>
                                    </td>
                                    <td>
                                        @if (isset($subproceso->tiposub->nombre))
                                            <h6 class="mb-0">{{$subproceso->tiposub->nombre}}</h6>
                                        @else
                                            <span class="badge badge-danger">Sin ningun tipo de informacion asignado</span>
                                        @endif
                                    </td>
                                    <td>
                                       <p>{{$subproceso->created_at}}</p>
                                    </td>
                                    <td class="text-center">
                                        <div class="action-btns">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" class="btn btn-outline-info"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <button data-bs-toggle="modal" data-bs-target="#deleteCliente" type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
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
                {{$subprocesosList->links('pagination-links')}}
            </div>
        </div>
    </div>
    @include("livewire.modals.nuevoSubproceso")
</div>

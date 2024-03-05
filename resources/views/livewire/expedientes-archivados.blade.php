<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between" wire:ignore>
            <h3>Escrituras públicas archivadas</h3>
        </div>
    </div>
    <div class="card-body">
        <div class="row gx-3">
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

            <div class="col-lg-12 d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <select wire:model='cantidad_escrituras' class="form-select mb-3 me-1">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </span>
                        <input wire:model="search" type="text" class="form-control" placeholder="Busqueda rapida" aria-label="notification" aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>

            <div class="col-lg-12 table-responsive drag" style="cursor: grab;">
                <table class="table table-hover table-bordered" id="my_table">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">Número</th>
                            <th scope="col">Acto</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Abogado</th>
                            <th scope="col">Observaciones</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($archivados as $archivado)
                            <tr>
                                <td class="text-center">{{$archivado->escritura->numero_escritura}}</td>
                                <td>{{$archivado->escritura->servicio->nombre}}</td>
                                <td>{{$archivado->escritura->cliente->nombre}} {{$archivado->escritura->cliente->apaterno}} {{$archivado->escritura->cliente->amaterno}}</td>
                                <td>{{$archivado->escritura->abogado->name}} {{$archivado->escritura->abogado->apaterno}} {{$archivado->escritura->abogado->amaterno}}</td>
                                <td>
                                    Sin observaciones...
                                    {{-- {{$archivado->observaciones}} --}}
                                </td>
                                <td class="text-center">
                                    <form action="/expediente/{{$archivado->proyecto_id}}">
                                        <button class="btn btn-outline-dark" type="submit">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Sin registros...</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- {{$escrituras->links('pagination-links')}} --}}
        </div>
    </div>
</div>


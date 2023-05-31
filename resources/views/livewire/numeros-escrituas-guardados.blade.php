<div class="card">
    <div class="card-header">
        <div style="display:flex; justify-content: space-between;">
            <div class="flex-item" style="width: 100%;">
                <div style="display:flex; justify-content:end;">
                    <button wire:click='openModal' class="btn btn-outline-primary me-2"><i class="fa-solid fa-plus"></i></button>
                    <select style="width: 10%;" wire:model='cantidad_escrituras' class="form-select">
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
            </style>

            <div class="col-lg-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Número de escritura</th>
                            <th scope="col">Volumen</th>
                            <th scope="col">Abogado</th>
                            <th scope="col">Folios</th>
                            <th scope="col">Fecha</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($escrituras as $escritura)
                            <tr>
                                <td>{{$escritura->numero_escritura}}</td>
                                <td>{!! $escritura->volumen ?? "<span class='text-danger'>S/V</span>" !!}</td>
                                <td>
                                    {!! $escritura->abogado->name ?? "<span class='text-danger'>Sin abogado asignado</span>" !!}
                                    {{$escritura->abogado->apaterno ?? ""}}
                                    {{$escritura->abogado->amaterno ?? ""}}
                                </td>
                                <td>{!! $escritura->folio_inicio ?? "<span class='text-danger'>S/F</span>" !!} - {!!$escritura->folio_fin ?? "<span class='text-danger'>S/F</span>"!!}</td>
                                <td>{!! $escritura->created_at ?? "<span class='text-danger'>S/F</span>" !!}</td>
                                <td>
                                    <button class="btn btn-outline-primary" wire:click='editarNumero({{$escritura->id}})'>
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Sin registros</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{$escrituras->links('pagination-links')}}
            </div>
        </div>
    </div>
    @include("livewire.escrituas-gardadas-resources.modal-nuevo-registro")
    @include("livewire.escrituas-gardadas-resources.modal-autorizar-escritura")
</div>

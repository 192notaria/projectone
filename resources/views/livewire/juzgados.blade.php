<div class="card">
    <div class="card-header">
        <div style="display:flex; justify-content: space-between;">
            <div class="flex-item" style="width: 100%;">
                <div style="display:flex; justify-content:end;">
                    <button class="btn btn-outline-primary me-2" wire:click='abrirModalRegistrarJuzgado'><i class="fa-solid fa-plus"></i></button>
                    <input style="width: 90%;" wire:model="search" type="text" class="form-control me-2" placeholder="Buscar: Cliente, Acto...">
                    <select style="width: 10%;" wire:model='cantidadJuzgados' class="form-select">
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
            <div class="col-lg-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Juzgado</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Domicilio</th>
                            <th scope="col"></th>
                        </tr>
                        <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                    </thead>
                    <tbody>
                        @forelse ($juzgados as $juzgado)
                            <tr>
                                <td>
                                    <p class="align-self-center mb-0 user-name fw-bold">
                                        {{$juzgado->adscripcion}}
                                    </p>
                                    <p class="align-self-center mb-0 user-name">
                                        {{$juzgado->distrito}}
                                    </p>
                                </td>
                                <td>{{$juzgado->cliente->nombre ?? "SIN NOMBRE"}}</td>
                                <td style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{$juzgado->domicilio}}
                                </td>
                                <td>
                                    <button wire:click='editarJuzgado({{$juzgado->id}})' class="btn btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                </td>
                            </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
                {{$juzgados->links('pagination-links')}}
            </div>
        </div>
    </div>
    @include("livewire.juzgados-resources.modal-register-juzgado")
    @include("livewire.juzgados-resources.modal-registrar-cliente")
</div>

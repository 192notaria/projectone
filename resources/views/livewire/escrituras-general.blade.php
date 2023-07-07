<div class="card">
    <div class="card-header">
        <div style="display:flex; justify-content: space-between;">
            <div class="flex-item" style="width: 100%;">
                <div style="display:flex; justify-content:end;">
                    <input style="width: 90%;" wire:model="search" type="text" class="form-control me-2" placeholder="Buscar: Cliente, Acto...">
                    <select style="width: 30%;" wire:model='tipo_acto_id' class="form-select me-2">
                        <option value="">Todos...</option>
                        @foreach ($catalogo_tipos_actos as $tipo_actos)
                            <option value="{{$tipo_actos->id}}">{{$tipo_actos->nombre}}</option>
                        @endforeach
                    </select>
                    <select style="width: 10%;" wire:model='cantidadEscrituras' class="form-select">
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
                            <th scope="col">Acto</th>
                            <th scope="col">Cliente/Abogado</th>
                            @can('ver-costo-total')
                                <th scope="col">Costo total</th>
                            @endcan
                            @can('ver-pagos-recibidos')
                                <th scope="col">Anticipos</th>
                            @endcan
                            @can('ver-egresos-registrados')
                                <th scope="col">Egresos</th>
                            @endcan
                            @can('ver-pendiente-pago')
                                <th scope="col">Sobrante</th>
                            @endcan
                            <th scope="col"></th>
                        </tr>
                        <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                    </thead>
                    <tbody>
                        @forelse ($escrituras as $escritura)
                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="avatar avatar-sm me-2">
                                            <span class="avatar-title badge bg-{{$escritura->servicio->tipo_acto->color}} rounded-circle">{{$escritura->numero_escritura ?? "S/N"}}</span>
                                        </div>
                                        <div class="media-body align-self-center">
                                            <h6 class="mb-0 fw-bold">
                                                <a href="#"
                                                @can('ver-detalles-pago-escritura')
                                                    wire:click='open_modal({{$escritura->id}})'
                                                @endcan
                                                >
                                                    {{$escritura->servicio->nombre}}
                                                    @if ($escritura->servicio_id == 25)
                                                        ({{$escritura->tipo_servicio}})
                                                    @endif
                                                    @if ($escritura->servicio_id == 22)
                                                        ({{$escritura->tipo_servicio}})
                                                    @endif
                                                    @if ($escritura->servicio_id == 2)
                                                        ({{$escritura->tipo_servicio}})
                                                    @endif
                                                </a>
                                                <p>
                                                    <span class="badge badge-{{$escritura->servicio->tipo_acto->color}}">{{$escritura->servicio->tipo_acto->nombre ?? "S/D"}}</span>
                                                </p>
                                            </h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold">Cliente: </span> {{$escritura->cliente->nombre}} {{$escritura->cliente->apaterno}} {{$escritura->cliente->amaterno}}
                                    <br>
                                    <span class="fw-bold">Abogado: </span> {{$escritura->abogado->name}} {{$escritura->abogado->apaterno}} {{$escritura->abogado->amaterno}}
                                </td>
                                {{-- <td>{{$escritura->created_at}}</td> --}}
                                @can('ver-costo-total')
                                    <td>
                                        <span class="badge badge-primary">
                                            ${{number_format($escritura->total ?? 0, 2)}}
                                        </span>
                                    </td>
                                @endcan
                                @can('ver-pagos-recibidos')
                                    <td>
                                        <span class="badge badge-success">
                                            ${{number_format($escritura->pagos_recibidos_total($escritura->id), 2)}}
                                        </span>
                                    </td>
                                @endcan
                                @can('ver-egresos-registrados')
                                    <td>
                                        <span class="badge badge-warning">
                                            ${{number_format($escritura->egresos_registrados($escritura->id), 2)}}
                                        </span>
                                    </td>
                                @endcan
                                @can('ver-pendiente-pago')
                                    <td>
                                        <span class="badge
                                        @if ($escritura->pagos_recibidos_total($escritura->id) - $escritura->egresos_registrados($escritura->id) < 0)
                                            badge-danger
                                        @else
                                            badge-info
                                        @endif
                                        ">
                                            ${{number_format($escritura->pagos_recibidos_total($escritura->id) - $escritura->egresos_registrados($escritura->id), 2)}}
                                        </span>
                                    </td>
                                @endcan

                                <td>
                                    {{-- @can("editar-costo-total")
                                        <button class="btn btn-primary" wire:click='abrir_modal_registrar_total({{$escritura->id}})'>
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                    @endcan --}}
                                    @can("ver-detalles-pagos")
                                        <button wire:loading.attr="disabled" class="btn btn-success" wire:click='open_modal({{$escritura->id}})'>
                                            <i class="fa-solid fa-magnifying-glass-dollar"></i>
                                        </button>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    Sin registros...
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{$escrituras->links('pagination-links')}}
            </div>
        </div>
    </div>
    @include("livewire.escritura-general-resources.modal-pagos")
    @include("livewire.escritura-general-resources.modal-registrar-egreso")
    @include("livewire.escritura-general-resources.modal-registrar-costos")
    @include("livewire.escritura-general-resources.modal-borrar-costo")
    @include("livewire.escritura-general-resources.modal-borrar-egreso")
    @include("livewire.escritura-general-resources.modal-borrar-pago")
    @include("livewire.escritura-general-resources.modal-registrar-pago")
    @include("livewire.escritura-general-resources.modal-recibo-pago-egreso")
    @include("livewire.escritura-general-resources.modal-registrar-total")
    @include("livewire.escritura-general-resources.modal-registrar-comision")
</div>

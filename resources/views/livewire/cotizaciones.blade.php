<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div>
                <h3>Cotizaciones</h3>
            </div>
            <div>
                @can("crear-cotizacion")
                    <button wire:click='abrir_modal_crear_cotizacion' class="btn btn-outline-success me-2">
                        <i class="fa-solid fa-plus"></i> Crear cotización
                    </button>
                @endcan
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row gy-3">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between">
                    <div class="d-flex justify-content-start">
                        <select wire:model='cantidadCotizaciones' class="form-select">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                    <div>
                        <input wire:model="search" type="text" class="form-control" placeholder="Buscar: Cliente, Acto...">
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

                @keyframes fadeOut {
                    0% { opacity: 1; }
                    100% { opacity: 0; }
                }
            </style>

            <div class="col-lg-12 table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Acto</th>
                            <th>Total</th>
                            <th>Usuario</th>
                            <th>Fecha</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cotizaciones as $cotizacion)
                            <tr>
                                <td>
                                    {{$cotizacion->id}} - {{$cotizacion->version}}
                                </td>
                                <td>
                                    {{$cotizacion->cliente->nombre}}
                                    {{$cotizacion->cliente->apaterno}}
                                    {{$cotizacion->cliente->amaterno}}
                                </td>
                                <td>
                                    {{$cotizacion->acto->nombre}}
                                    @if ($cotizacion->acto_id == 25)
                                        ({{$cotizacion->tipo_servicio}})
                                    @endif
                                </td>
                                <td><span class="badge badge-primary">${{number_format($cotizacion->total, 2)}}</span></td>
                                <td>{{$cotizacion->usuario->name ?? ""}} {{$cotizacion->usuario->apaterno ?? ""}} {{$cotizacion->usuario->amaterno ?? ""}}</td>
                                <td>{{$cotizacion->created_at}}</td>
                                <td>
                                    @can("ver-historial-cotizaciones")
                                        <button wire:loading.attr='disabled' wire:click='ver_cotizaciones({{$cotizacion->id}})' class="btn btn-success">
                                            <i class="fa-solid fa-bars"></i>
                                        </button>
                                    @endcan
                                    @can("editar-cotizacion")
                                        <button wire:loading.attr='disabled' wire:click='editar_cotizacion({{$cotizacion->id}})' class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                    @endcan
                                    @can("borrar-cotizacion")
                                        <button wire:loading.attr='disabled' class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Sin registros</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{$cotizaciones->links('pagination-links')}}
        </div>
    </div>
    @include("livewire.resources-cotizaciones.modal-crear-cotizacion")
    @include("livewire.resources-cotizaciones.modal-costo")
    @include("livewire.resources-cotizaciones.modal-historail-cotizaciones")
    @include("livewire.resources-cotizaciones.moda-crear-proyecto")
</div>

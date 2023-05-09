<div class="card">
    <div class="card-header">
        <div style="display:flex; justify-content: space-between;">
            <div class="flex-item" style="width: 100%;">
                <div style="display:flex; justify-content:end;">
                    <button wire:click='abrir_modal_crear_cotizacion' class="btn btn-outline-success me-2">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <input style="width: 90%;" wire:model="search" type="text" class="form-control me-2" placeholder="Buscar: Cliente, Acto...">
                    <select style="width: 10%;" wire:model='cantidadCotizaciones' class="form-select">
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
            </style>

            <div class="col-lg-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Acto</th>
                            <th>Total</th>
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
                                <td>{{$cotizacion->acto->nombre}}</td>
                                <td><span class="badge badge-primary">${{number_format($cotizacion->total, 2)}}</span></td>
                                <td>{{$cotizacion->created_at}}</td>
                                <td>
                                    <button wire:click='ver_cotizaciones({{$cotizacion->id}})' class="btn btn-success">
                                        <i class="fa-solid fa-bars"></i>
                                    </button>
                                    <button wire:click='editar_cotizacion({{$cotizacion->id}})' class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Sin registros</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{$cotizaciones->links('pagination-links')}}
            </div>
        </div>
    </div>
    @include("livewire.resources-cotizaciones.modal-crear-cotizacion")
    @include("livewire.resources-cotizaciones.modal-costo")
    @include("livewire.resources-cotizaciones.modal-historail-cotizaciones")
    @include("livewire.resources-cotizaciones.moda-crear-proyecto")
</div>

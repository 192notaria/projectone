<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between" wire:ignore>

            <h3>Copias Certificadas</h3>

            @can("crear-proyectos")
                <button wire:click='nueva_copia_modal' wire:loading.attr='disabled' type="button" class="btn btn-outline-dark">
                    Nueva Copia <i class="fa-solid fa-plus"></i>
                </button>
            @endcan

        </div>
    </div>
    <div class="card-body">
        <div class="row gx-3 gy-3">
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
                <table class="table table-bordered table-hover" id="my_table">
                    <thead>
                        <tr>
                            <th scope="col"># Copias</th>
                            <th scope="col">Costo por copia</th>
                            <th scope="col">Cantidad de Juegos</th>
                            <th scope="col">Costo Total</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Status</th>
                            <th scope="col">Acciones</th>
                        </tr>
                        <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                    </thead>
                    <tbody>
                        @forelse ($copias_certificadas as $copia)
                            <tr>
                                <td>{{$copia->cantidad_copias}}</td>
                                <td>{{$copia->costo_copia}}</td>
                                <td>{{$copia->juegos}}</td>
                                <td>{{$copia->cantidad_copias * $copia->costo_copia * $copia->juegos}}</td>
                                <td>{{$copia->cliente_data->nombre}} {{$copia->cliente_data->apaterno}} {{$copia->cliente_data->amaterno}}</td>
                                <td>
                                    @if ($copia->pago && !$copia->pago->recibo)
                                        <span class="badge badge-warning">Pagado y en espera de recibo</span>
                                    @endif
                                    @if (!$copia->pago)
                                        <span class="badge badge-danger">En espera de pago</span>
                                    @endif
                                    @if ($copia->pago && $copia->pago->recibo)
                                        <span class="badge badge-success">Pagado</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button wire:click='pagos_modal({{$copia->id}})' class="btn btn-outline-dark"><i class="fa-solid fa-file-invoice-dollar"></i></button>
                                    <button class="btn btn-outline-dark"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button class="btn btn-outline-dark"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Sin registros</td>
                            </tr>
                        @endforelse
                    </tbody aá>
                </table>
            </div>
            {{-- {{$escrituras->links('pagination-links')}} --}}
        </div>
    </div>
    <script src="{{url("v3/src/plugins/src/tomSelect/tom-select.base.js")}}"></script>

    @include("livewire.copias_resources.nueva-copia")
    @include("livewire.copias_resources.pagos")
    @include("livewire.copias_resources.recibo-pago-modal")

</div>

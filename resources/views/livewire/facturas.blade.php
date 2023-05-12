<div class="card">
    <div class="card-header">
        <div style="display:flex; justify-content: space-between;">
            <div class="flex-item">
                @can("crear-factura")
                    <button wire:click='abrirModalFactura' style="height: 100%;" type="button" class="btn btn-outline-primary me-2">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                @endcan
            </div>
            <div class="flex-item" style="width: 100%;">
                <div style="display:flex; justify-content:end;">
                    <input style="width: 90%;" wire:model="search" type="text" class="form-control me-2" placeholder="Buscar: Nombre, Apellido, Servicio...">
                    <select style="width: 10%;" wire:model='cantidadFacturas' class="form-select">
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

                .active_drag{
                    cursor: grabbing;
                }
            </style>
            <div class="col-lg-12 table-responsive drag" style="cursor: grab;">
                <table class="table table-striped" id="my_table">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Monto</th>
                            <th>Cliente</th>
                            <th>Escritura</th>
                            <th>Fecha</th>
                            <th>Origen</th>
                            <th>Concepto</th>
                            <th>Observaciones</th>
                        </tr>
                        <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                    </thead>
                    <tbody>
                        @forelse ($facturas as $factura)
                            <tr>
                                <td>{{$factura->folio_factura}}</td>
                                <td>{{$factura->monto}}</td>
                                <td>{{$factura->proyecto_id}}</td>
                                <td>{{$factura->proyecto_id}}</td>
                                <td>{{$factura->fecha}}</td>
                                <td>{{$factura->origen}}</td>
                                <td>{{$factura->concepto_pago_id}}</td>
                                <td>{{$factura->observaciones}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Sin registros...</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{$facturas->links('pagination-links')}}
            </div>
        </div>
    </div>
    @include("livewire.facturas-resources.modal-new-factura")
</div>

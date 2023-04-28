<div class="card">
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
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <select class="form-select" style="width: 8%;">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
            <input type="text" class="form-control me-2" placeholder="Buscar..." style="width: 30%;">
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Fecha de pago</th>
                            <th scope="col">No. Acta</th>
                            <th scope="col">Forma de pago</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">IVA</th>
                            <th scope="col">IVA RET</th>
                            <th scope="col">ISR RET</th>
                            <th scope="col">Monto</th>
                            <th scope="col">Comprobación</th>
                            <th scope="col">Folio Factura</th>
                            <th scope="col">Acto</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Monto de transferencia</th>
                            <th scope="col">RFC</th>
                        </tr>
                        <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                    </thead>
                    <tbody>
                        @forelse ($pagos_registrados as $pago)
                            <tr>
                                <td>{{$pago->fecha}}</td>
                                <td>1</td>
                                <td>1</td>
                                <td>1</td>
                                <td>1</td>
                                <td>1</td>
                                <td>1</td>
                                <td>1</td>
                                <td>1</td>
                                <td>1</td>
                                <td>1</td>
                                <td>1</td>
                                <td>1</td>
                                <td>1</td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="14">Sin registros...</td>
                            </tr>
                            @endforelse
                    </tbody>
                </table>
                {{$pagos_registrados->links('pagination-links')}}
            </div>
        </div>
    </div>
</div>

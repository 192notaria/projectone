<div class="card">
    <div class="card-header">
        <h3>Conceptos contables</h3>
        <div style="display:flex; align-items:right;">
            <button type="button" class="btn btn-outline-success me-2">
                <i class="fa-solid fa-plus"></i>
            </button>
            <input wire:model="search" type="text" class="form-control" placeholder="Buscar...">
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Uso</th>
                            <th>Tipo de cuenta</th>
                            <th>Banco</th>
                            <th>Titular</th>
                            <th>Numero de cuenta</th>
                            <th>Clabe interbancaria</th>
                            <th>Descripcion</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cuentas_contables as $c_contable)
                            <tr>
                                <td>{{$c_contable->uso->nombre}}</td>
                                <td>{{$c_contable->tipo->nombre}}</td>
                                <td>{{$c_contable->banco->nombre}}</td>
                                <td>{{$c_contable->titular}}</td>
                                <td>{{$c_contable->numero_cuenta}}</td>
                                <td>{{$c_contable->clabe_interbancaria}}</td>
                                <td>{{$c_contable->observaciones}}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">Sin registros...</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

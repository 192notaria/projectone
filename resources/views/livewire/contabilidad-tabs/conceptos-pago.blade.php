<div class="card">
    <div class="card-header">
        <h3>Conceptos de pago</h3>
        <div style="display:flex; align-items:right;">
            <button type="button" class="btn btn-outline-success me-2" wire:click='cambiar_vista("concepto-pago-form")'>
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
                            <th>Descripcion</th>
                            <th>Categoria</th>
                            <th>Precio sugerido</th>
                            <th>% Impuestos</th>
                            <th>Tipo de impuesto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($conceptos_pago as $concepto)
                            <tr>
                                <td>{{$concepto->descripcion}}</td>
                                <td>{{$concepto->categoria->nombre}}</td>
                                <td>{{number_format($concepto->precio_sugerido, 2)}}</td>
                                <td>{{$concepto->impuestos}}</td>
                                <td>{{$concepto->impuesto->nombre}}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button wire:click='editarConceptoPago({{$concepto->id}})' type="button" class="btn btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">Sin registros...</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

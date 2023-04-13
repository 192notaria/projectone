<div class="card">
    <div class="card-header">
        <h3>Categoria de gastos</h3>
        <div style="display:flex; align-items:right;">
            <button wire:click='cambiar_vista("categoria-gastos-form")' type="button" class="btn btn-outline-success me-2">
                <i class="fa-solid fa-plus"></i>
            </button>
            <input style="width: 30%" wire:model="search" type="text" class="form-control" placeholder="Buscar...">
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categoria_gastos as $cg)
                            <tr>
                                <td>{{$cg->nombre}}</td>
                                <td>{{$cg->descripcion ?? "Sin descripcion"}}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button wire:click='editarCategoriaGasto({{$cg->id}})' type="button" class="btn btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Sin registros...</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

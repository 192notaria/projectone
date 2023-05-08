<div class="card">
    <div class="card-header">
        <h3>Metodos de pago</h3>
        <div style="display:flex; align-items:right;">
            <button type="button" class="btn btn-outline-success me-2" wire:click='cambiar_vista("metodos-pago-form")'>
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
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($metodos_pago as $metodo)
                            <tr>
                                <td>{{$metodo->nombre}}</td>
                                <td>{{$metodo->observaciones ?? "Sin descripcion"}}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button wire:click='editar_metodo_pago({{$metodo->id}})' type="button" class="btn btn-outline-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button wire:click='borrar_metodo_pago({{$metodo->id}})' type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
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

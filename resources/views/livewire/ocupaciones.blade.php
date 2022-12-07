<div class="row">
    <div class="col-lg-12 mb-3">
        <div class="card">
            <div class="card-header" style="display:flex; align-items:right;">
                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target=".modal-new-ocupacion">
                    <i class="fa-solid fa-circle-plus"></i>
                </button>
                <select wire:model='cantidadOcupaciones' class="form-select" style="width: 5%; margin-left: 5px; margin-right: 5px;">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
                <input wire:model='buscarOcupacion' style="width: 30%" wire:model="search" type="text" class="form-control" placeholder="Buscar...">
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Ocupacion</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ocupaciones as $ocupacion)
                            <tr>
                                <td>{{mb_strtoupper($ocupacion->nombre)}}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Actions Buttons">
                                        <button wire:click='editar({{$ocupacion->id}})' type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target=".modal-new-ocupacion"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button type="button" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$ocupaciones->links('pagination-links')}}
            </div>
        </div>
    </div>
    @include('livewire.modals.nueva-ocupacion')
</div>

<div class="row">
    {{-- Estados --}}
    <div class="col-lg-12">
        <h2>Estados</h2>
    </div>
    <div class="col-lg-12 mb-3">
        <div class="card">
            <div class="card-header" style="display:flex; align-items:right;">
                <button type="button" wire:click='openModal("")' class="btn btn-outline-success">
                    <i class="fa-solid fa-user-plus"></i>
                </button>
                <select wire:model='cantidadEstados' class="form-select" style="width: 5%; margin-left: 5px; margin-right: 5px;">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
                <input wire:model='buscarEstado' style="width: 30%" wire:model="search" type="text" class="form-control" placeholder="Buscar: Estado, Pais">
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Estado</th>
                            <th>Pais</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($estadosData as $key => $estado)
                            <tr>
                                <td>{{$estado->nombre}}</td>
                                <td>{{$estado->getPais->nombre}}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button wire:click='openModal({{$estado->id}})' type="button" class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button wire:click='borrarEstadoModal({{$estado->id}})' type="button" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$estadosData->links('pagination-links')}}
            </div>
        </div>
    </div>
    @include('livewire.modals.nuevoestado')
    @include('livewire.modals.borrarEstado')
</div>

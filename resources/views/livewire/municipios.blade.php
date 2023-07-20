<div class="row">
    <div class="col-lg-12 mb-3">
        <div class="card">
            <div class="card-header">
                <div class="card-header" style="display:flex; align-items:right;">
                    @can("crear-municipios")
                        <button type="button" wire:click='openModal("")' class="btn btn-outline-success">
                            <i class="fa-solid fa-user-plus"></i>
                        </button>
                    @endcan
                    <select wire:model='cantidadMunicipios' class="form-select" style="width: 5%; margin-left: 5px; margin-right: 5px;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                    <input wire:model='buscarMunicipio' style="width: 30%" wire:model="search" type="text" class="form-control" placeholder="Buscar: Estado, Pais">
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Municipio</th>
                            <th>Estado</th>
                            <th>Pais</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($municipiosData as $municipio)
                            <tr>
                                <td>{{$municipio->nombre}}</td>
                                @if (isset($municipio->getEstado->nombre))
                                    <td>{{$municipio->getEstado->nombre}}</td>
                                @else
                                    <td> <span class="text-danger">Sin estado</span> </td>
                                @endif
                                @if (isset($municipio->getEstado->getPais->nombre))
                                    <td>{{$municipio->getEstado->getPais->nombre}}</td>
                                @else
                                    <td><span class="text-danger">Sin pais</span></td>
                                @endif
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        @can("editar-municipios")
                                            <button wire:click='openModal({{$municipio->id}})' type="button" class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></button>
                                        @endcan
                                        @can("borrar-municipios")
                                            <button wire:click='openModalBorrar({{$municipio->id}})' type="button" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$municipiosData->links('pagination-links')}}
            </div>
        </div>
    </div>
    @include('livewire.modals.nuevoMunicipio')
    @include('livewire.modals.borrarMunicipio')
</div>

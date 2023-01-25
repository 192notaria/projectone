    <div class="row">
        {{-- Colonias --}}
        <div class="col-lg-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="row ">
                        <div class="col-lg-12 mb-2">
                            <h2>
                                Colonias
                                <button wire:click='openModal("")' class="btn btn-outline-success mb-2 me-4"><i class="fa-solid fa-circle-plus"></i></button>
                            </h2>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-1 mb-2">
                            <select wire:model='cantidadColonias' class="form-control">
                                <option value="5">5</option>
                                <option value="10" selected>10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <div class="col-lg-11 mb-0 col-md-11 col-sm-11 filtered-list-search">
                            <form class="form-inline ">
                                <div class="w-100">
                                    <input wire:model="buscarColonia" type="text" class="w-100 form-control product-search br-30" id="input-search" placeholder="Estado...">
                                    <button class="btn btn-primary" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Colonia</th>
                                <th>Ciudad / Localidad</th>
                                <th>Municipio</th>
                                <th>Estado</th>
                                <th>Pais</th>
                                <th>Asentamiento</th>
                                <th>Codigo Postal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coloniasData as $key => $colonia)
                                <tr>
                                    <td>{{$colonia->nombre}}</td>
                                    <td>{{$colonia->ciudad}}</td>
                                    <td>{{$colonia->getMunicipio->nombre ?? "Sin municipio"}}</td>
                                    <td>{{$colonia->getMunicipio->getEstado->nombre ?? "Sin estado"}}</td>
                                    <td>{{$colonia->getMunicipio->getEstado->getPais->nombre ?? "Sin Pais"}}</td>
                                    <td>{{$colonia->asentamiento}}</td>
                                    <td>{{$colonia->codigo_postal}}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button wire:click='openModal({{$colonia->id}})' type="button" class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></button>
                                            <button wire:click='openBorrarColonia({{$colonia->id}})' type="button" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$coloniasData->links('pagination-links')}}
                </div>
            </div>
        </div>
        @include('livewire.modals.nuevaColonia')
        @include('livewire.modals.borrarColonia')
    </div>


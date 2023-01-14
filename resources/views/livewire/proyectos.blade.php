<div class="card">
    <div class="card-header">
        <div style="display:flex; align-items:right;">
            @can("crear-proyectos")
                {{-- <button type="button" wire:click='openModalNuevoProyecto' class="btn btn-outline-success">
                    <i class="fa-solid fa-user-plus"></i>
                </button>
                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target=".modal-generales-docs">
                    <i class="fa-solid fa-user-plus"></i>
                </button> --}}
            @endcan
            <select wire:model='cantidadProyectos' class="form-select" style="width: 5%; margin-left: 5px; margin-right: 5px;">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
            <input style="width: 30%" wire:model="search" type="text" class="form-control" placeholder="Buscar: Nombre, Apellido, Servicio...">
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

                .autocomplete-items-2 {
                    position: absolute;
                    border: 1px solid #d4d4d4;
                    border-bottom: none;
                    border-top: none;
                    z-index: 99;
                    top: 100%;
                    left: 0;
                    right: 0;
                }

                .autocomplete-items-2 .abogadolist {
                    padding: 10px;
                    cursor: pointer;
                    border-bottom: 1px solid #d4d4d4;
                    background-color: #ffff;
                }

                .autocomplete-items-2 .abogadolist:hover {
                    background-color: #e9e9e9;
                }

                .autocomplete-active {
                    background-color: DodgerBlue !important;
                    color: #ffffff;
                }

                .btn-outline-danger:hover{
                    background-color: #e7515a !important;
                    color: #ffffff !important;
                }

                .btn-outline-primary:hover{
                    background-color: #4361ee !important;
                    color: #ffffff !important;
                }
            </style>
            <div class="col-lg-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Cliente</th>
                            {{-- <th scope="col">Apoyo</th> --}}
                            <th scope="col">Proyecto</th>
                            @can('ver-estado-proyecto')
                                <th scope="col">Estado</th>
                            @endcan
                            <th scope="col"></th>
                        </tr>
                        <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                    </thead>
                    <tbody>
                        @if (count($proyectos) > 0)
                            @foreach ($proyectos as $proyecto)
                                @if ($proyecto->status == 0)
                                    @if (Auth::user()->hasRole('ABOGADO DE APOYO'))
                                        @foreach ($proyecto->apoyo as $apoyo)
                                            @if ($apoyo->abogado_apoyo_id == auth()->user()->id)
                                                @include('livewire.resource.tr_proyectos')
                                            @endif
                                        @endforeach
                                    @else
                                        @if ($proyecto->usuario_id == auth()->user()->id || Auth::user()->hasRole('ADMINISTRADOR') || Auth::user()->hasRole('RECEPCIONISTA'))
                                            @include('livewire.resource.tr_proyectos')
                                        @endif
                                    @endif
                                @endif
                            @endforeach

                            {{-- @if (Auth::user()->hasRole('RECEPCIONISTA'))
                                @foreach ($proyectos as $proyecto)
                                    @include('livewire.resource.tr_proyectos')
                                @endforeach
                            @endif --}}

                        @else
                            <td colspan="6" class="text-center">
                                Sin registros...
                            </td>
                        @endif
                    </tbody>
                </table>
                {{$proyectos->links('pagination-links')}}
            </div>
        </div>
    </div>


    @if (isset($procesoActual->nombre))
        {{-- <p>{{$procesoActual->nombre}}</p> --}}

        {{-- <p>{{$procesoActual}}</p>
        <p>{{$subprocesoActual}}</p> --}}

        {{-- <p>{{$subprocesoActual->tiposub}}</p> --}}
        @if (isset($subprocesoActual->tiposub->id))
            @if ($subprocesoActual->tiposub->id == 1)
                @include("livewire.modals.testigos")
            @endif

            {{-- @if ($subprocesoActual->tiposub->id == 4)
                @include("livewire.modals.generalescondocumentos")
            @endif --}}

            {{-- @if ($subprocesoActual->tiposub->id == 6)
                @include("livewire.modals.subirdocumentos")
            @endif --}}

            {{-- @if ($subprocesoActual->tiposub->id == 5)
                @include("livewire.modals.firmas")
            @endif --}}

            @if ($subprocesoActual->tiposub->id == 8)
                @include("livewire.modals.registrar_firma")
            @endif

            @if ($subprocesoActual->tiposub->id == 3)
                @include("livewire.modals.autorizacion_catastro")
            @endif

            @if ($subprocesoActual->tiposub->id == 9)
                @include("livewire.modals.generales_sin_docs")
            @endif
        @else
            @include("livewire.modals.errormodal")
        @endif
    @endif

    @include("livewire.modals.modaltimeline")
    @include("livewire.modals.nuevoProyecto")
    @include("livewire.modals.observaciones")
    @include("livewire.modals.verObservacion")
    @include("livewire.modals.apoyoProyectos")

    {{-- Edtar subprocesos --}}
    @include("livewire.modal-subprocesos-edicion.generales_docs")
    @include("livewire.modals.cancelar-proyecto")
    @include("livewire.modals-ignore-self.editar-proyecto-clientes")
    @include("livewire.modal-subprocesos-edicion.editar-documentos")

    {{-- modal wire:ignore.self --}}
    @include("livewire.modals-ignore-self.generales-con-documentos")
    @include("livewire.modals-ignore-self.subir-documentos")
    @include("livewire.modals-ignore-self.recibos-pagos")
    @include("livewire.modals-ignore-self.no-autorizado")
    @include("livewire.modals-ignore-self.generales-testigos")
    @include("livewire.modals-ignore-self.agendar-firma")
    @include("livewire.modals-ignore-self.registrar-firma")
    @include("livewire.modals-ignore-self.generales-herederos")
    @include("livewire.modals-ignore-self.registrar-nombre-acta")
    @include("livewire.modals-ignore-self.importar-muchos-docs")
    @include("livewire.modals-ignore-self.registrar-autorizacion-catastro")
    @include("livewire.modals-ignore-self.registrar-nombres-apoderados")
    @include("livewire.modals-ignore-self.generales-menores")
    @include("livewire.modals-ignore-self.registrar-informacion-viaje-menores")
    @include("livewire.modals-ignore-self.registrar-informacion-mutuos")
    @include("livewire.modals-ignore-self.generales-socios")
    @include("livewire.modals-ignore-self.generales-apoderados")
    @include("livewire.modals-ignore-self.generales-varios")

    {{-- Vista previa --}}
    @include("livewire.modal-subprocesos-edicion.vista-generales-con-documentos")
    @include("livewire.modal-subprocesos-edicion.vista-nombre-acta")
    @include("livewire.modal-subprocesos-edicion.vista-varios-generales")
    @include("livewire.modal-subprocesos-edicion.vista-proyecto")

</div>

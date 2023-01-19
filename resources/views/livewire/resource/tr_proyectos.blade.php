<tr>
    <td @if (isset($proyecto->activiadVulnerable->id) && $proyecto->activiadVulnerable->activo == 1) class='bg-danger' @endif>
        <div class="media">
            <div class="avatar me-2">
                {{-- <img alt="avatar" src="{{url('v3/src/assets/img/male-avatar.svg')}}" class="rounded-circle" /> --}}
                <img alt="avatar" src="{{$proyecto->cliente->genero == "Masculino" ? url('v3/src/assets/img/male-avatar.svg') : url('v3/src/assets/img/female-avatar.svg')}}" class="rounded-circle" />
            </div>
            <div class="media-body align-self-center">
                <h6 class="mb-0 fw-bold @if (isset($proyecto->activiadVulnerable->id) && $proyecto->activiadVulnerable->activo == 1) text-white @endif">{{$proyecto->cliente->nombre}} {{$proyecto->cliente->apaterno}} {{$proyecto->cliente->amaterno}}</h6>
                <p class="mt-2">
                    <span class="fw-bold @if (isset($proyecto->activiadVulnerable->id) && $proyecto->activiadVulnerable->activo == 1) text-white @endif">Acto:</span>
                    <span class="badge badge-primary">{{$proyecto->servicio->nombre}}</span>
                </p>
                <p>
                    <span class="fw-bold @if (isset($proyecto->activiadVulnerable->id) && $proyecto->activiadVulnerable->activo == 1) text-white @endif">Escritura:</span>
                    <span class="badge badge-primary">{{$proyecto->numero_escritura}}</span>
                </p>
                <p>
                    <span class="fw-bold @if (isset($proyecto->activiadVulnerable->id) && $proyecto->activiadVulnerable->activo == 1) text-white @endif">Volumen:</span>
                    <span class="badge badge-primary">{{$proyecto->volumen}}</span>
                </p>
                {{-- <p>
                    <button wire:click='generarQr({{$proyecto->id}})' class="btn btn-info"><i class="fa-solid fa-qrcode"></i></button>
                </p> --}}
                <p class="text-danger">
                    <div class="action-btns">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button wire:click='generarQr({{$proyecto->id}})' type="button" class="btn btn-info">
                                <i class="fa-solid fa-qrcode"></i>
                            </button>
                            <button wire:click='actividadvulnerable({{$proyecto->id}})' type="button" class="btn btn-danger">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </button>
                            <button type="button" class="btn btn-primary">
                                <i class="fa-solid fa-file-pen"></i>
                            </button>
                        </div>
                    </div>
                    {{-- <button class="btn btn-danger">Actividad vulnerable <i class="fa-solid fa-triangle-exclamation"></i></button> --}}
                    {{-- @if (isset($proyecto->activiadVulnerable->id))
                        @if ($proyecto->activiadVulnerable->activo == 0)
                            <button wire:click='actividadvulnerable({{$proyecto->id}})' class="btn btn-primary">Actividad vulnerable</button>
                        @else
                            <button wire:click='actividadvulnerable({{$proyecto->id}})' class="btn btn-danger"><i class="fa-solid fa-circle-exclamation"></i> Actividad vulnerable</button>
                        @endif
                    @else
                        <button wire:click='actividadvulnerable({{$proyecto->id}})' class="btn btn-primary">Actividad vulnerable</button>
                    @endif --}}

                </p>
            </div>
        </div>
    </td>
    <td>
        <p class="mb-0 text-left">
            <span class="fw-bold">Abogado asignado:</span>
            <p>
                {{$proyecto->abogado->name}} {{$proyecto->abogado->apaterno}} {{$proyecto->abogado->amaterno}}
            </p>
        </p>
        @can('ver_apoyo_proyecto')
            <p class="mt-0 mb-0">
                @if (count($proyecto->apoyo) > 0)
                    <div class="btn-group mt-2" role="group">
                        <button id="btndefault" type="button" class="btn btn-outline-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Apoyo
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></button>
                        <div class="dropdown-menu" aria-labelledby="btndefault">
                            <ul class="list-group">
                                @foreach ($proyecto->apoyo as $apoyo)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="media me-5">
                                            <div class="avatar me-2">
                                                <img alt="avatar" src="{{url($apoyo->abogado_apoyo->user_image)}}" class="rounded-circle" />
                                            </div>
                                            <div class="media-body align-self-center">
                                                <h6 class="mb-0 fw-bold">{{$apoyo->abogado_apoyo->name}} {{$apoyo->abogado_apoyo->amaterno}} {{$apoyo->abogado_apoyo->apaterno}}</h6>
                                                <p>
                                                    <span class="badge badge-primary">{{$apoyo->abogado_apoyo->getOcupacion->nombre}}</span>
                                                </p>
                                            </div>
                                        </div>
                                        @can('remover_apoyo_proyecto')
                                            <a wire:click='removerApoyo({{$apoyo->id}})'><span class="badge bg-danger"><i class="fa-solid fa-xmark"></i></span></a>
                                        @endcan
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                @can('agregar_apoyo_proyecto')
                    <button wire:click='openModalAgregarApoyo({{$proyecto->id}}, {{$proyecto->abogado->id}})' title="Agregar abogado de apoyo" type="button" class="btn btn-outline-info mt-2"><i class="fa-solid fa-plus"></i></button>
                @endcan
            </p>
        @endcan
        <p class="mt-3 mb-0 text-left">
            <span class="fw-bold">Fecha de registro:</span>
            <p>{{$proyecto->created_at}} </p>
        </p>
        {{-- @can('ver-plantillas-proyecto')
            @if (isset($proyecto->getstatus->proceso->nombre))
                @if ($proyecto->servicio->procesos[0]->id != $proyecto->getstatus->proceso_id)
                    <div class="btn-group" style="width: 100%;" role="group">
                        <span style="width: 100%;" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa-solid fa-file-word"></i> Proyecto <i class="fa-solid fa-chevron-down"></i>
                        </span>
                        <div class="dropdown-menu" aria-labelledby="btndefault">
                            <a href="javascript:void(0);" class="dropdown-item"><i class="flaticon-home-fill-1 mr-1"></i>Formato 1</a>
                            <a href="javascript:void(0);" class="dropdown-item"><i class="flaticon-gear-fill mr-1"></i>Formato 2</a>
                            <a href="javascript:void(0);" class="dropdown-item"><i class="flaticon-bell-fill-2 mr-1"></i>Formato 3</a>
                            <a href="javascript:void(0);" class="dropdown-item"><i class="flaticon-dots mr-1"></i>Formato 4</a>
                        </div>
                    </div>
                @endif
            @endif
        @endcan --}}
    </td>

    @can('ver-estado-proyecto')
        <td>
            @if (isset($proyecto->getstatus->proceso->nombre))
                <span class="mb-0">Ultimo registro</span>
            @endif
            <p>
                @if (isset($proyecto->getstatus->proceso->nombre))
                    <span class="badge badge-info">
                        <i class="fa-solid fa-pen"></i> {{$proyecto->getstatus->proceso->nombre}} - {{$proyecto->getstatus->subproceso->nombre}}
                    </span>

                    <span class="badge badge-info"><i class="fa-solid fa-calendar"></i>
                        {{$proyecto->getstatus->created_at}}
                    </span>
                @endif
            </p>
            <p class="mt-2 mb-0">
                @if (count($proyecto->porcentaje) > 0)
                    @php
                        $procesosCount = count($proyecto->porcentaje);
                        $newArray = [];
                        foreach ($proyecto->avanceCount as $data){
                            array_push($newArray, $data->proceso_id);
                        }
                        $data = array_unique($newArray);
                        $porcentaje = round(count($data) * 100 / $procesosCount);
                        // $porcentaje = round($porcentaje, 0);
                    @endphp
                    @if ($porcentaje <= 20)<span class="badge badge-danger mb-1">Avance: {{$porcentaje}}%</span>@endif
                    @if ($porcentaje > 20 && $porcentaje <= 50)<span class="badge badge-warning mb-1">Avance: {{$porcentaje}}%</span>@endif
                    @if ($porcentaje > 50 && $porcentaje <= 99)<span class="badge badge-info mb-1">Avance: {{$porcentaje}}%</span>@endif
                    @if ($porcentaje == 100)<span class="badge badge-success mb-1">Avance: {{$porcentaje}}%</span>@endif
                    <div class="progress progress-bar-stack br-30" style="width: 100%;">
                        <div class="progress-bar
                            @if ($porcentaje <= 20) bg-danger @endif
                            @if ($porcentaje > 20 && $porcentaje <= 50) bg-warning @endif
                            @if ($porcentaje > 50 && $porcentaje <= 99) bg-info @endif
                            @if ($porcentaje == 100) bg-success @endif
                            progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{$porcentaje}}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    @can('ver_observaciones-proyecto')
                        @if (count($proyecto->observaciones) > 0)
                            <div class="btn-group mt-2" role="group">
                                <button id="btndefault" type="button" class="btn btn-outline-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Observaciones
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></button>
                                <div class="dropdown-menu" aria-labelledby="btndefault">
                                    <ul class="list-group">
                                        @foreach ($proyecto->observaciones as $observacion)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <a class="me-5" wire:click='verObservacion({{$observacion->id}})'>{{$observacion->titulo}}</a>
                                            @can('remover_observaciones-proyecto')
                                                <a href="#"><span class="badge bg-danger rounded-pill"><i class="fa-solid fa-xmark"></i></span></a>
                                            @endcan
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    @endcan
                    @can('agregar_observaciones-proyecto')
                        <button wire:click='openModalObservaciones({{$proyecto->id}})' title="Agregar observacion" type="button" class="btn btn-outline-info mt-2"><i class="fa-solid fa-file-pen"></i> Agregar Observaciones</button>
                    @endcan
                @else
                    <span class="badge badge-warning"><i class="fa-solid fa-triangle-exclamation"></i> No hay procesos asignados para este servicio</span>
                @endif
            </p>
        </td>
    @endcan
    <td class="text-center">
        <div class="action-btns">
            <div class="btn-group" role="group" aria-label="Basic example">
                @if (count($proyecto->porcentaje) > 0)
                    @can('ver-avanzarProyecto')
                        <button wire:click='avanzar({{$proyecto->id}},{{$proyecto->servicio->id}})' type="button" class="btn btn-outline-success"><i class="fa-solid fa-file-import"></i></button>
                    @endcan
                    @can('ver-lineatiempoProyecto')
                        <button wire:click='openModalTimeLine({{$proyecto->servicio->id}}, {{$proyecto->id}})' type="button" class="btn btn-outline-warning"><i class="fa-solid fa-timeline"></i></button>
                    @endcan
                @endif
                @can('editar-proyectos')
                    <button wire:click='editarProyecto("{{$proyecto->id}}")' type="button" class="btn btn-outline-info"><i class="fa-solid fa-pen-to-square"></i></button>
                @endcan
                @can('borrar-proyectos')
                    <button wire:click='cancelar_id({{$proyecto->id}})' data-bs-toggle="modal" data-bs-target=".modal-cancelar-proyecto" type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                @endcan
            </div>
        </div>
    </td>
</tr>

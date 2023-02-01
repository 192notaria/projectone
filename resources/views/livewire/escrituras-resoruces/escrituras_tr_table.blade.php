<tr>
    <td @if (isset($escritura->activiadVulnerable->id) && $escritura->activiadVulnerable->activo == 1) class='bg-danger' @endif>
        <div class="media">
            <div class="avatar me-2">
                <img alt="avatar" src="{{$escritura->cliente->genero == "Masculino" ? url('v3/src/assets/img/male-avatar.svg') : url('v3/src/assets/img/female-avatar.svg')}}" class="rounded-circle" />
            </div>
            <div class="media-body align-self-center">
                <h6 class="mb-0 fw-bold @if (isset($escritura->activiadVulnerable->id) && $escritura->activiadVulnerable->activo == 1) text-white @endif">{{$escritura->cliente->nombre}} {{$escritura->cliente->apaterno}} {{$escritura->cliente->amaterno}}</h6>
                <p class="mt-2">
                    <span class="fw-bold @if (isset($escritura->activiadVulnerable->id) && $escritura->activiadVulnerable->activo == 1) text-white @endif">Acto:</span>
                    <span class="badge badge-primary">{{$escritura->servicio->nombre}}</span>
                </p>
                <p>
                    <span class="fw-bold @if (isset($escritura->activiadVulnerable->id) && $escritura->activiadVulnerable->activo == 1) text-white @endif">Escritura:</span>
                    <span class="badge badge-primary">{{$escritura->numero_escritura}}</span>
                </p>
                <p>
                    <span class="fw-bold @if (isset($escritura->activiadVulnerable->id) && $escritura->activiadVulnerable->activo == 1) text-white @endif">Volumen:</span>
                    <span class="badge badge-primary">{{$escritura->volumen}}</span>
                </p>
                {{-- <p>
                    <button wire:click='generarQr({{$escritura->id}})' class="btn btn-info"><i class="fa-solid fa-qrcode"></i></button>
                </p> --}}
                <p class="text-danger">
                    <div class="action-btns">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            {{-- <button wire:click='generarQr({{$escritura->id}})' type="button" class="btn btn-info">
                                <i class="fa-solid fa-qrcode"></i>
                            </button>
                            <button wire:click='actividadvulnerable({{$escritura->id}})' type="button" class="btn btn-danger">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </button>
                            <button type="button" class="btn btn-primary">
                                <i class="fa-solid fa-file-pen"></i>
                            </button> --}}
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".modal-ajustes">
                                <i class="fa-solid fa-gear"></i>
                            </button>
                            <button wire:click='openProcesos({{$escritura->id}})' type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target=".modal-procesos-escritura">
                                <i class="fa-solid fa-file-import"></i>
                            </button>
                        </div>
                    </div>
                </p>
            </div>
        </div>
    </td>
    <td>
        <p class="mb-0 text-left">
            <span class="fw-bold">Abogado asignado:</span>
            <p>
                {{$escritura->abogado->name}} {{$escritura->abogado->apaterno}} {{$escritura->abogado->amaterno}}
            </p>
        </p>
        @can('ver_apoyo_proyecto')
            <p class="mt-0 mb-0">
                @if (count($escritura->apoyo) > 0)
                    <div class="btn-group mt-2" role="group">
                        <button id="btndefault" type="button" class="btn btn-outline-info dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Apoyo
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></button>
                        <div class="dropdown-menu" aria-labelledby="btndefault">
                            <ul class="list-group">
                                @foreach ($escritura->apoyo as $apoyo)
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
                {{-- @can('agregar_apoyo_proyecto')
                    <button wire:click='openModalAgregarApoyo({{$escritura->id}}, {{$escritura->abogado->id}})' title="Agregar abogado de apoyo" type="button" class="btn btn-outline-info mt-2">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                @endcan --}}
            </p>
        @endcan
        <p class="mt-3 mb-0 text-left">
            <span class="fw-bold">Fecha de creación:</span>
            <p>{{$escritura->created_at}} </p>
        </p>
        @can('ver-estado-proyecto')
        @if (isset($escritura->getstatus->proceso->nombre))
            <span class="mb-0 fw-bold">Ultimo avance:</span>
        @endif
        @if (isset($escritura->getstatus->proceso->nombre))
            <p>
                <span class="badge badge-info">
                    <i class="fa-solid fa-pen"></i> {{$escritura->getstatus->proceso->nombre}} - {{$escritura->getstatus->subproceso->nombre}}
                </span>
            </p>

            <p>
                <span class="badge badge-info"><i class="fa-solid fa-calendar"></i>
                    {{$escritura->getstatus->created_at}}
                </span>
            </p>
        @endif
        <p class="mt-2 mb-0">
            @if (count($escritura->porcentaje) > 0)
                @php
                    $procesosCount = count($escritura->porcentaje);
                    $newArray = [];
                    foreach ($escritura->avanceCount as $data){
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
            @else
                <span class="badge badge-warning"><i class="fa-solid fa-triangle-exclamation"></i> No hay procesos asignados para este servicio</span>
            @endif
        </p>
@endcan
    </td>



    <td class="text-center">
        <div class="action-btns">
            <div class="btn-group" role="group" aria-label="Basic example">
                {{-- @if (count($escritura->porcentaje) > 0)
                    @can('ver-avanzarProyecto')
                        <button wire:click='avanzar({{$escritura->id}},{{$escritura->servicio->id}})' type="button" class="btn btn-outline-success"><i class="fa-solid fa-file-import"></i></button>
                    @endcan
                    @can('ver-lineatiempoProyecto')
                        <button wire:click='openModalTimeLine({{$escritura->servicio->id}}, {{$escritura->id}})' type="button" class="btn btn-outline-warning"><i class="fa-solid fa-timeline"></i></button>
                    @endcan
                @endif --}}

                @can('editar-proyectos')
                    <button wire:click='editarProyecto("{{$escritura->id}}")' type="button" class="btn btn-outline-info"><i class="fa-solid fa-pen-to-square"></i></button>
                @endcan
                @can('borrar-proyectos')
                    <button wire:click='cancelar_id({{$escritura->id}})' data-bs-toggle="modal" data-bs-target=".modal-cancelar-proyecto" type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                @endcan

            </div>
        </div>
    </td>
</tr>

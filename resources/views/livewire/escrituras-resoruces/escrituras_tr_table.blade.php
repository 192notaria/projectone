<tr>
    <td class="text-center">
        {{$escritura->numero_escritura ?? "S/N"}}
    </td>
    <td @if (isset($escritura->activiadVulnerable->id) && $escritura->activiadVulnerable->activo == 1) class='bg-danger' @endif>
        <div>
            {{-- <div class="avatar me-2">
                <img alt="avatar" src="{{$escritura->cliente->genero == "Masculino" ? url('v3/src/assets/img/male-avatar.svg') : url('v3/src/assets/img/female-avatar.svg')}}" class="rounded-circle" />
            </div> --}}
            <div class="media-body align-self-center">
                <p class="mb-0">
                    @if (isset($escritura->cliente->tipo_cliente) && $escritura->cliente->tipo_cliente == "Persona Moral")
                        {{$escritura->cliente->razon_social ?? ""}}
                        {{-- <span class="badge badge-primary">
                            {{$escritura->cliente->admin_unico ?? ""}}
                        </span> --}}
                    @else
                        {{$escritura->cliente->nombre ?? ""}} {{$escritura->cliente->apaterno ?? ""}} {{$escritura->cliente->amaterno ?? ""}}
                    @endif
                </p>
            </div>
        </div>
    </td>
    <td>
        <span class="text">{{$escritura->abogado->name}} {{$escritura->abogado->apaterno}} {{$escritura->abogado->amaterno}}</span>
        {{-- @can('ver-estado-proyecto')
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

        @endcan --}}
    </td>

    <td>
        <p>
            {{$escritura->servicio->nombre ?? ""}}
            @if ($escritura->servicio_id == 25)
                ({{$escritura->tipo_servicio}})
            @endif
            @if ($escritura->servicio_id == 22)
                ({{$escritura->tipo_servicio}})
            @endif
            @if ($escritura->servicio_id == 2)
                ({{$escritura->tipo_servicio}})
            @endif
        </p>
        <p class="mb-0 text-left">
            {{-- <span class="fw-bold">Abogado:</span>
            <p>
                <span class="mt-2 avatar-chip avatar-dismiss bg-dark me-4 position-relative">
                    <img src="{{url($escritura->abogado->user_image)}}" alt="Person" width="96" height="96">
                    <span class="text">{{$escritura->abogado->name}} {{$escritura->abogado->apaterno}} {{$escritura->abogado->amaterno}}</span>
                </span>
            </p> --}}
        </p>
    </td>

    <td class="text-center">
            @if (count($escritura->porcentaje) > 0)
                @php
                    $subprocesoscount = 0;
                    foreach ($escritura->porcentaje as $key => $value) {
                        foreach ($value->subprocesosCount as $key => $subproceos) {
                            $subprocesoscount = $subprocesoscount + 1;
                        }
                    }

                    $procesos = $escritura->avanceCount->count()  * 100;
                    $porcentaje = round($procesos / $subprocesoscount);
                    if($porcentaje > 100) $porcentaje = 100;
                @endphp
                @if ($porcentaje <= 20)<span class="badge badge-danger mb-1">{{$porcentaje}}%</span>@endif
                @if ($porcentaje > 20 && $porcentaje <= 50)<span class="badge badge-warning mb-1">{{$porcentaje}}%</span>@endif
                @if ($porcentaje > 50 && $porcentaje <= 99)<span class="badge badge-info mb-1">{{$porcentaje}}%</span>@endif
                @if ($porcentaje == 100)<span class="badge badge-success mb-1">{{$porcentaje}}%</span>@endif
                {{-- <div class="progress progress-bar-stack br-30" style="width: 100%;">
                    <div class="progress-bar
                        @if ($porcentaje <= 20) bg-danger @endif
                        @if ($porcentaje > 20 && $porcentaje <= 50) bg-warning @endif
                        @if ($porcentaje > 50 && $porcentaje <= 99) bg-info @endif
                        @if ($porcentaje >= 100) bg-success @endif
                        progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{$porcentaje}}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div> --}}
            @else
                <span class="badge badge-warning"><i class="fa-solid fa-triangle-exclamation"></i> No hay procesos asignados para este servicio</span>
            @endif
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
                    <button wire:loading.attr="disabled" wire:click='openProcesos({{$escritura->id}})' type="button" class="btn btn-outline-dark">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                @endcan
                @can('borrar-proyectos')
                    <button wire:loading.attr="disabled" wire:click='open_modal_borrar({{$escritura->id}})' data-bs-toggle="modal" data-bs-target=".modal-cancelar-proyecto" type="button" class="btn btn-outline-dark"><i class="fa-solid fa-trash"></i></button>
                @endcan
            </div>
        </div>
    </td>
</tr>

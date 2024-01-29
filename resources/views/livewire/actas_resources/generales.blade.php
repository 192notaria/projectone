<div id="timelineBasic" class="col-lg-12 layout-spacing">
    {{-- <div class="statbox widget box box-shadow">
       <div class="widget-content widget-content-area pb-1"> --}}
        @if ($vista_general == "general")
            <ol class="timeline">
                <li class="timeline-item extra-space">
                    <span class="timeline-item-icon filled-icon">
                        <i class="fa-solid fa-list-ol"></i>
                    </span>
                    <div class="timeline-item-wrapper">
                        <div class="timeline-item-description">
                            <span class="align-self-center">
                                Numero de acta: <span class="badge bg-light-primary">{{$proyecto_activo->numero_escritura}}</span>
                            </span>
                        </div>
                        <div class="timeline-item-wrapper">
                            <span class="align-self-center">
                                <a wire:click='cambiar_info_proyecto({{$proyecto_activo["id"]}})' style="font-size: 11px;" class="text-warning" href="#">Asignar o  cambiar el numero de poder</a>
                            </span>
                        </div>
                    </div>
                </li>
                <li class="timeline-item">
                    <span class="timeline-item-icon filled-icon">
                        <i class="fa-solid fa-file-contract"></i>
                    </span>
                    <div class="timeline-item-description">
                        <span class="align-self-center">
                            Acto: <span class="badge bg-light-primary">{{$proyecto_activo->servicio->nombre}}</span>
                        </span>
                    </div>
                </li>
                <li class="timeline-item">
                    <span class="timeline-item-icon filled-icon">
                        <i class="fa-solid fa-users"></i>
                    </span>
                    <div class="timeline-item-description">
                        <span class="align-self-center">
                            Cliente:
                            <span class="badge bg-light-primary">
                                {{$proyecto_activo->cliente->nombre}}
                                {{$proyecto_activo->cliente->apaterno}}
                                {{$proyecto_activo->cliente->amaterno}}
                            </span>
                        </span>
                    </div>
                </li>
                <li class="timeline-item extra-space">
                    <span class="timeline-item-icon filled-icon">
                        <i class="fa-solid fa-user-tie"></i>
                    </span>
                    <div class="timeline-item-wrapper">
                        <div class="timeline-item-description">
                            <span class="align-self-center">
                                Abogado:
                                <span class="badge bg-light-primary">
                                    @if (isset($proyecto_activo->abogado->name))
                                        {{$proyecto_activo->abogado->name}}
                                        {{$proyecto_activo->abogado->apaterno}}
                                        {{$proyecto_activo->abogado->amaterno}}
                                    @else
                                        Sin abogado asignado
                                    @endif
                                </span>
                            </span>
                        </div>
                        <div class="comment">
                            <h5>Comentarios u observaciones</h5>
                            <p class="text-warning">
                                {{$proyecto_activo->observaciones ?? "Sin comentarios u observaciones"}}
                            </p>
                        </div>
                        @if (count($proyecto_activo->asistentes) > 0)
                            <div class="show-replies">
                                <i class="fa-solid fa-handshake-angle"></i>
                                Asistentes
                                <div class="avatar--group ms-3">
                                    @foreach ($proyecto_activo->asistentes as $asistente)
                                        <div class="avatar avatar-sm">
                                        </div>
                                    @endforeach

                                    {{-- <div class="avatar avatar-sm">
                                        <img alt="avatar" src="{{url('v3/src/assets/img/delete-user-4.jpeg')}}" class="rounded-circle">
                                    </div>
                                    <div class="avatar avatar-sm">
                                        <img alt="avatar" src="{{url('v3/src/assets/img/profile-5.jpeg')}}" class="rounded-circle">
                                    </div>
                                    <div class="avatar avatar-sm">
                                        <span class="avatar-title rounded-circle">AG</span>
                                    </div> --}}
                                </div>
                            </div>
                        @endif
                    </div>
                </li>
            </ol>
        @endif
        @if ($vista_general == "editar_escritura_volumen")
            <div class="row gx-3 gy-3">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-start">
                        <button wire:loading.attr='disabled' wire:click='vista_general_modal("general")' class="btn btn-danger me-2">Cancelar</button>
                        <button wire:loading.attr='disabled' wire:click='guardar_escritura_volumen' class="btn btn-success">Guardar</button>
                    </div>
                </div>
                <div class="col-lg-6">
                    <label for="">Numero de acta</label>
                    <input type="text" class="form-control" wire:model='numero_escritura_general'>
                    @error('numero_escritura_general')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="col-lg-6">
                    <label for="">Abogado</label>
                    <select class="form-select" wire:model='abogado_proyecto'>
                        <option value="" disabled>Seleccionar...</option>
                        @foreach ($abogados_proyectos as $abogado)
                            <option value="{{$abogado->id}}">{{$abogado->name}} {{$abogado->apaterno}} {{$abogado->amaterno}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif

       </div>
   {{-- </div>
</div> --}}

<div id="timelineBasic" class="col-lg-12 layout-spacing">
    {{-- <div class="statbox widget box box-shadow">
       <div class="widget-content widget-content-area pb-1"> --}}
        <ol class="timeline">
            <li class="timeline-item extra-space">
                <span class="timeline-item-icon filled-icon">
                    <i class="fa-solid fa-list-ol"></i>
                </span>
                <div class="timeline-item-wrapper">
                    <div class="timeline-item-description">
                        <span class="align-self-center">
                            Numero de escritura: <span class="badge bg-light-primary">{{$escritura_activa->numero_escritura}}</span>
                        </span>
                    </div>
                    <div class="timeline-item-wrapper">
                        <span class="align-self-center">
                            Volumen: <span class="badge bg-light-primary">{{$escritura_activa->volumen}}</span>
                        </span>
                    </div>
                    <div class="timeline-item-wrapper mt-1">
                        <span class="align-self-center">
                            Folios: <span class="badge bg-light-primary">{{$escritura_activa->folio_inicio}} - {{$escritura_activa->folio_fin}}</span>
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
                        Acto: <span class="badge bg-light-primary">{{$escritura_activa->servicio->nombre}}</span>
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
                            {{$escritura_activa->cliente->nombre}}
                            {{$escritura_activa->cliente->apaterno}}
                            {{$escritura_activa->cliente->amaterno}}
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
                                {{$escritura_activa->abogado->name}}
                                {{$escritura_activa->abogado->apaterno}}
                                {{$escritura_activa->abogado->amaterno}}
                            </span>
                        </span>
                    </div>
                    @if (count($escritura_activa->asistentes) > 0)
                        <div class="show-replies">
                            <i class="fa-solid fa-handshake-angle"></i>
                            Asistentes
                            <div class="avatar--group ms-3">
                                @foreach ($escritura_activa->asistentes as $asistente)
                                    <div class="avatar avatar-sm">
                                        <div class="avatar avatar-sm">
                                            <img alt="avatar" src="{{$asistente->abogado_apoyo->user_image}}" class="rounded-circle">
                                        </div>
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

</div>
   {{-- </div>
</div> --}}

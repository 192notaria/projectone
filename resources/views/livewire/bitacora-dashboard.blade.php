<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
    <div class="widget widget-activity-four">
        <div class="widget-heading">
            <h5 class="">Actividad reciente</h5>
        </div>
        <div class="widget-content">
            <div class="mt-container-ra mx-auto">
                @if (count($registros_actividad) == 0)
                    <p>Sin registros de actividad</p>
                @else
                    <div class="timeline-line">
                        @foreach ($registros_actividad as $registro)
                            <div class="item-timeline
                                @if ($registro->actividad == 'Nuevo registro')
                                    timeline-success
                                @endif
                                @if ($registro->actividad == 'Registro editado')
                                    timeline-primary
                                @endif
                                @if ($registro->actividad == 'Registro borrado')
                                    timeline-danger
                                @endif">
                                <div class="t-dot" data-original-title="" title="">
                                </div>
                                <div class="t-text">
                                    <p>
                                        <span>{{$registro->actividad}}</span> - {{$registro->detalle}}
                                    </p>
                                    <span class="badge bs-popover rounded" data-bs-container="body" data-bs-trigger="hover" data-bs-content="{{$registro->descripcion}}">{{$registro->created_at}}</span>
                                    <p class="t-time">{{$registro->created_at->diffForHumans(now())}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="tm-action-btn">
                <button class="btn"><span>Ver Todo</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></button>
            </div>
        </div>
    </div>
</div>

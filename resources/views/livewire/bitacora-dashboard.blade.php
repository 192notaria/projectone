<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
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
                                @endif
                            ">
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
{{--
                    <div class="item-timeline timeline-success">
                        <div class="t-dot" data-original-title="" title="">
                        </div>
                        <div class="t-text">
                            <p>Send Mail to <a href="javascript:void(0);">HR</a> and <a href="javascript:void(0);">Admin</a></p>
                            <span class="badge">Completed</span>
                            <p class="t-time">2 min ago</p>
                        </div>
                    </div>

                    <div class="item-timeline  timeline-danger">
                        <div class="t-dot" data-original-title="" title="">
                        </div>
                        <div class="t-text">
                            <p>Backup <span>Files EOD</span></p>
                            <span class="badge">Pending</span>
                            <p class="t-time">14:00</p>
                        </div>
                    </div>

                    <div class="item-timeline  timeline-dark">
                        <div class="t-dot" data-original-title="" title="">
                        </div>
                        <div class="t-text">
                            <p>Collect documents from <a href="javascript:void(0);">Sara</a></p>
                            <span class="badge">Completed</span>
                            <p class="t-time">16:00</p>
                        </div>
                    </div>

                    <div class="item-timeline  timeline-warning">
                        <div class="t-dot" data-original-title="" title="">
                        </div>
                        <div class="t-text">
                            <p>Conference call with <a href="javascript:void(0);">Marketing Manager</a>.</p>
                            <span class="badge">In progress</span>
                            <p class="t-time">17:00</p>
                        </div>
                    </div>

                    <div class="item-timeline  timeline-secondary">
                        <div class="t-dot" data-original-title="" title="">
                        </div>
                        <div class="t-text">
                            <p>Rebooted Server</p>
                            <span class="badge">Completed</span>
                            <p class="t-time">17:00</p>
                        </div>
                    </div>

                    <div class="item-timeline  timeline-warning">
                        <div class="t-dot" data-original-title="" title="">
                        </div>
                        <div class="t-text">
                            <p>Send contract details to Freelancer</p>
                            <span class="badge">Pending</span>
                            <p class="t-time">18:00</p>
                        </div>
                    </div>

                    <div class="item-timeline  timeline-dark">
                        <div class="t-dot" data-original-title="" title="">
                        </div>
                        <div class="t-text">
                            <p>Kelly want to increase the time of the project.</p>
                            <span class="badge">In Progress</span>
                            <p class="t-time">19:00</p>
                        </div>
                    </div>

                    <div class="item-timeline  timeline-success">
                        <div class="t-dot" data-original-title="" title="">
                        </div>
                        <div class="t-text">
                            <p>Server down for maintanence</p>
                            <span class="badge">Completed</span>
                            <p class="t-time">19:00</p>
                        </div>
                    </div>

                    <div class="item-timeline  timeline-secondary">
                        <div class="t-dot" data-original-title="" title="">
                        </div>
                        <div class="t-text">
                            <p>Malicious link detected</p>
                            <span class="badge">Block</span>
                            <p class="t-time">20:00</p>
                        </div>
                    </div>

                    <div class="item-timeline  timeline-warning">
                        <div class="t-dot" data-original-title="" title="">
                        </div>
                        <div class="t-text">
                            <p>Rebooted Server</p>
                            <span class="badge">Completed</span>
                            <p class="t-time">23:00</p>
                        </div>
                    </div>

                    <div class="item-timeline timeline-primary">
                        <div class="t-dot" data-original-title="" title="">
                        </div>
                        <div class="t-text">
                            <p><span>Updated</span> Server Logs</p>
                            <span class="badge">Pending</span>
                            <p class="t-time">Just Now</p>
                        </div>
                    </div>

                    <div class="item-timeline timeline-success">
                        <div class="t-dot" data-original-title="" title="">
                        </div>
                        <div class="t-text">
                            <p>Send Mail to <a href="javascript:void(0);">HR</a> and <a href="javascript:void(0);">Admin</a></p>
                            <span class="badge">Completed</span>
                            <p class="t-time">2 min ago</p>
                        </div>
                    </div>

                    <div class="item-timeline  timeline-danger">
                        <div class="t-dot" data-original-title="" title="">
                        </div>
                        <div class="t-text">
                            <p>Backup <span>Files EOD</span></p>
                            <span class="badge">Pending</span>
                            <p class="t-time">14:00</p>
                        </div>
                    </div>

                    <div class="item-timeline  timeline-dark">
                        <div class="t-dot" data-original-title="" title="">
                        </div>
                        <div class="t-text">
                            <p>Collect documents from <a href="javascript:void(0);">Sara</a></p>
                            <span class="badge">Completed</span>
                            <p class="t-time">16:00</p>
                        </div>
                    </div>

                    <div class="item-timeline  timeline-warning">
                        <div class="t-dot" data-original-title="" title="">
                        </div>
                        <div class="t-text">
                            <p>Conference call with <a href="javascript:void(0);">Marketing Manager</a>.</p>
                            <span class="badge">In progress</span>
                            <p class="t-time">17:00</p>
                        </div>
                    </div> --}}

                </div>
                @endif
            </div>

            <div class="tm-action-btn">
                <button class="btn"><span>Ver Todo</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></button>
            </div>
        </div>
    </div>
</div>

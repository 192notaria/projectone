<!-- Modal Timeline-->
<div class="modal @if($modalTimeLine) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modalTimeLine) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modalTimeLine) aria-modal="true" @endif  @if(!$modalTimeLine) aria-hidden="true" @endif>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Avance del proyecto</h5>
                <button wire:click='closeModalTimeLine' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                    <i class="fa-solid fa-circle-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="container mt-container">
                    <ul class="modern-timeline pl-0">
                        @if (count($serviciosTimeline) > 0)
                            @foreach ($serviciosTimeline as $procesos)
                                <li>
                                    <div class="modern-timeline-badge"></div>
                                    <div class="modern-timeline-panel">
                                        <div class="modern-timeline-body border border-danger">
                                            <h4 class="mb-4">{{$procesos->nombre}}</h4>
                                            <div class="mt-container mx-auto">
                                                <div class="timeline-line">
                                                    @foreach ($avanceTimeline as $avancetime)
                                                        @if ($avancetime->proceso_id == $procesos->id)
                                                            <div class="item-timeline">
                                                                <p class="t-time">{{\Carbon\Carbon::parse($avancetime->created_at)->format('H:i')}}</p>
                                                                <div class="t-dot t-dot-success"></div>
                                                                <div class="t-text">
                                                                    <p class="fw-bold">{{$avancetime->subproceso->nombre}}</p>
                                                                    <p>{{\Carbon\Carbon::parse($avancetime->created_at)->format('Y-m-d')}}</p>
                                                                    <p>{{ $avancetime->created_at->diffForHumans(now()) }}</p>
                                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                                        <button type="button" class="btn btn-outline-info"><i class="fa-solid fa-file-pdf"></i></button>
                                                                        <button wire:click='editarSubproceso({{$avancetime->id}})' type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif

                        {{-- <li>
                            <div class="modern-timeline-badge"></div>
                            <div class="modern-timeline-panel">
                                <div class="modern-timeline-preview"><img src="{{url("v3/src/assets/img/tl-2.jpeg")}}" alt="timeline"></div>
                                <div class="modern-timeline-body">
                                    <h4 class="mb-4">Web Development</h4>
                                    <p class="mb-4">Map where your photos were taken and discover local points of interest. Map where your photos. Map where your photos were taken and discover.</p>
                                    <p><a href="javascript:void(0);" class="btn btn-outline-primary mt-2">Read more</a></p>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="modern-timeline-badge"></div>
                            <div class="modern-timeline-panel">
                                <div class="modern-timeline-preview"><img src="{{url("v3/src/assets/img/tl-3.jpeg")}}" alt="timeline"></div>
                                <div class="modern-timeline-body">
                                    <h4 class="mb-4">Theme Development</h4>
                                    <p class="mb-4">Map where your photos were taken and discover local points of interest. Map where your photos. Map where your photos were taken and discover.</p>
                                    <p><a href="javascript:void(0);" class="btn btn-outline-primary mt-2">Read more</a></p>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="modern-timeline-badge"></div>
                            <div class="modern-timeline-panel">
                                <div class="modern-timeline-preview"><img src="{{url("v3/src/assets/img/tl-4.jpeg")}}" alt="timeline"></div>
                                <div class="modern-timeline-body">
                                    <h4 class="mb-4">Plugin Development</h4>
                                    <p class="mb-4">Map where your photos were taken and discover local points of interest. Map where your photos. Map where your photos were taken and discover.</p>
                                    <p><a href="javascript:void(0);" class="btn btn-outline-primary mt-2">Read more</a></p>
                                </div>
                            </div>
                        </li>

                        <li class="position-static">
                            <div class="modern-timeline-top"></div>
                        </li>

                        <li class="position-static">
                            <div class="modern-timeline-bottom"></div>
                        </li> --}}

                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='closeModalTimeLine' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button type="button" class="btn btn-outline-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

Agregar ocupaciones

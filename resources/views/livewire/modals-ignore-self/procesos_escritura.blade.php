<div wire:ignore.self class="modal fade modal-procesos-escritura"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="vertical-pill">
                    <div class="d-flex align-items-start">
                        <div class="nav flex-column nav-pills me-3" style="width: 50%;" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            @foreach ($procesos_data as $key => $proceso)
                                <button class="nav-link @if($key == 0) active @endif" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#proceso-{{$proceso->id}}" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                    {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg> --}}
                                    {{$proceso->nombre}}
                                </button>
                            @endforeach
                        </div>
                        <div class="tab-content" id="v-pills-tabContent">
                            @foreach ($procesos_data as $key => $proceso)
                                <div class="tab-pane fade @if($key == 0) show active @endif" id="proceso-{{$proceso->id}}" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                                    {{-- @if (isset($proceso->subprocesos->catalogosSubprocesos))
                                    @endif --}}
                                    <p>{{$proceso->subprocesos}}</p>
                                    @if (isset($proceso->subprocesos->catalogosSubprocesos))
                                        <p>{{$proceso->subprocesos->catalogosSubprocesos}}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('cerrar-modal-procesos-escritura', event => {
        $(".modal-procesos-escritura").modal("hide")
    })
</script>

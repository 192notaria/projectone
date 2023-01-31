<div wire:ignore.self class="modal fade modal-procesos-escritura"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="vertical-pill">
                    <div class="d-flex align-items-start">
                        <div style="max-width: 20%;" class="nav flex-column align-items-start nav-pills me-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            @foreach ($procesos_data as $key => $proceso)
                                <button style="width: 100%;"  class="nav-link" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#proceso-{{$proceso->id}}" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                    <i style="font-size: 20px;" class="{{$proceso->icon}}"></i>: {{$proceso->nombre}}
                                </button>
                            @endforeach
                        </div>
                        <div class="tab-content" id="v-pills-tabContent">
                            @foreach ($procesos_data as $key_data => $proceso)
                                <div class="tab-pane fade" id="proceso-{{$proceso->id}}" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                                    @foreach ($proceso->subprocesos as $sub)
                                        <p>{{$sub->catalogosSubprocesos->nombre}}</p>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='limpiarProcesos' class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('cerrar-modal-procesos-escritura', event => {
        $(".modal-procesos-escritura").modal("hide")
    })
</script>

<div wire:ignore.self class="modal fade modal-procesos-escritura"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="vertical-pill">
                    <div class="d-flex align-items-start">
                        <div style="max-width: 20%;" class="nav flex-column align-items-start nav-pills me-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            @foreach ($procesos_data as $proceso)
                                <button wire:click='subprocesosData({{$proceso->id}})' style="width: 100%;"  class="nav-link @if($proceso->id == $proceso_activo) active @endif">
                                    <i style="font-size: 20px;" class="{{$proceso->icon}}"></i>: {{$proceso->nombre}}
                                </button>
                            @endforeach
                        </div>
                        <div style="width: 100%;" class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active">
                                @if (count($subprocesos_data) > 0)
                                    <div class="row">
                                        @foreach ($subprocesos_data as $sub)
                                            @if ($sub->catalogosSubprocesos->tipo_id == 19)
                                                <div class="col-lg-12 mb-3">
                                                    @include('livewire.subprocesos-resource.varios-generales')
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='closeProcesos' class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-procesos-escritura', event => {
        $(".modal-procesos-escritura").modal("show")
    })

    window.addEventListener('cerrar-modal-procesos-escritura', event => {
        $(".modal-procesos-escritura").modal("hide")
    })
</script>

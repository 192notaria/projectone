<div wire:ignore.self class="modal fade modal-proyecto"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">{{$tituloModal}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach ($proyectos_escritura as $proyecto_data)
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <span class="badge badge-primary">
                                        {{$proyecto_data->created_at}}
                                    </span>
                                </div>
                                <div class="card-body">
                                    <a target="_blank" href="{{url($proyecto_data->storage)}}" class="btn btn-info" style="width: 100%;"><i class="fa-solid fa-file-word"></i> Descargar documento</a>
                                </div>
                                <div class="card-footer">
                                    <button wire:click='cambiar_documento_escritura({{$proyecto_data->id}})' class="btn btn-primary mt-2">Editar</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click='editarGeneralesDocs' type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-proyecto', event => {
        $(".modal-proyecto").modal("show")
    })
    window.addEventListener('cerrar-modal-proyecto', event => {
        $(".modal-proyecto").modal("hide")
        var myAudio= document.createElement('audio')
        myAudio.src = "{{ url("/v3/src/assets/audio/notification.mp3") }}"
        myAudio.play()

        Snackbar.show({
            text: event.detail,
            actionTextColor: '#fff',
            backgroundColor: '#00ab55',
            pos: 'top-center',
            duration: 5000,
            actionText: '<i class="fa-solid fa-circle-xmark"></i>'
        })
    })
    window.addEventListener('cerrar-modal-proyecto-temp', event => {
        $(".modal-proyecto").modal("hide")
    })
</script>

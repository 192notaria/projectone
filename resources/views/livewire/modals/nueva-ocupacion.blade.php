<div wire:ignore.self class="modal fade modal-new-ocupacion"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Nueva Ocupacion</h5>
                <button wire:click='clearInputs' type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <label for="">Nombre</label>
                            <input wire:model="nombre" type="text" class="form-control was-validated" placeholder="Ocupacion...">
                            @error('nombre') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-lg-12 mt-3">
                        <div class="form-group mb-3">
                            <label for="">Tipo</label>
                            <select wire:model='tipo' class="form-select">
                                <option value="" selected disabled>Seleccioanr...</option>
                                <option value="Oficio">Oficio</option>
                                <option value="Profesión">Profesión</option>
                            </select>
                            @error('tipo') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='clearInputs' class="btn" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click='saveOrEdit' type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('ocupacion_registrada', event => {
        $(".modal-new-ocupacion").modal("hide")
        var myAudio= document.createElement('audio');
        myAudio.src = "{{ url("/v3/src/assets/audio/notification.mp3") }}";
        myAudio.play();

        Snackbar.show({
            text: event.detail,
            actionTextColor: '#fff',
            backgroundColor: '#00ab55',
            pos: 'top-center',
            duration: 5000,
            actionText: '<i class="fa-solid fa-circle-xmark"></i>'
        });
    })

    window.addEventListener('ocupacion_editada', event => {
        $(".modal-new-ocupacion").modal("hide")
        var myAudio= document.createElement('audio');
        myAudio.src = "{{ url("/v3/src/assets/audio/notification.mp3") }}";
        myAudio.play();

        Snackbar.show({
            text: event.detail,
            actionTextColor: '#fff',
            backgroundColor: '#00ab55',
            pos: 'top-center',
            duration: 5000,
            actionText: '<i class="fa-solid fa-circle-xmark"></i>'
        });
    })
</script>

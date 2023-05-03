<div wire:ignore.self class="modal fade modal-new-guardia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Registrar guardia</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <label for="">Fecha</label>
                        <input type="date" class="form-control" wire:model='date_guardia'>
                        @error("date_guardia")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12 mt-2 mb-2">
                        <label for="">Usuario</label>
                        <select class="form-select" wire:model='usuario_id'>
                            <option value="" selected disabled>Seleccionar...</option>
                            @foreach ($usuarios as $user)
                                <option value="{{$user->id}}">{{$user->name}} {{$user->apaterno}} {{$user->amaterno}}</option>
                            @endforeach
                        </select>
                        @error("usuario_id")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                @if ($guardia_id)
                    <button wire:click='borrar_guardia' class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                @endif
                <button wire:click='registrar_guardia' class="btn btn-outline-success">Guardar</button>
                <button wire:click='clear_inputs' class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-new-guardia', event => {
        $(".modal-new-guardia").modal("show")
    })

    window.addEventListener('cerrar-modal-new-guardia', event => {
        $(".modal-new-guardia").modal("hide")
    })
</script>

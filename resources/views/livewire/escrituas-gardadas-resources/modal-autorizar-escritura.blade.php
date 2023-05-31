<div wire:ignore.self class="modal fade modal-autorizar-escritura" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Autorizar número de escritura</h3>
            </div>
            <div class="modal-body">
                <div class="row gy-3 gx-3">
                    <div class="col-lg-12" wire:ignore>
                        <label for="">Acto juridico</label>
                        <select id="acto-select-id" wire:model='acto_juridico_id' wire:change='cambiar_acto'>
                            <option value="" selected disabled>Seleccionar</option>
                            @foreach ($actos as $acto)
                                <option value="{{$acto->id}}">{{$acto->nombre}}</option>
                            @endforeach
                        </select>
                        @error("acto_juridico_id")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    @if (isset($acto_juridico->tipo_servicio) && count($acto_juridico->tipo_servicio) > 0)
                        <div class="col-lg-12 mt-4">
                            <label for="">Tipo de {{$acto_juridico->nombre}}</label>
                            <select class="form-select" wire:model='tipo_servicio'>
                                <option value="" disabled>Seleccionar...</option>
                                @foreach ($acto_juridico->tipo_servicio as $tipo)
                                    <option value="{{$tipo->nombre}}">{{$tipo->nombre}}</option>
                                @endforeach
                            </select>
                            @error("tipo_servicio")
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <a wire:click='clearInputs' href="#" data-bs-dismiss="modal" class="me-3">Cancelar</a>
                <button wire:click='autorizar' class="btn btn-outline-success">Guardar</button>
            </div>
        </div>
    </div>
</div>
<style>
    .snackbar-container{
        z-index: 100000;
    }
</style>

<script>
    window.addEventListener('open-modal-autorizar-escritura', event => {
        $(".modal-autorizar-escritura").modal("show")
        new TomSelect('#acto-select-id',{
            persist: false,
            createOnBlur: true,
        })
    })

    window.addEventListener('close-modal-autorizar-escritura', event => {
        $(".modal-autorizar-escritura").modal("hide")
    })
</script>

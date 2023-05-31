<div wire:ignore.self class="modal fade modal-escrituras-guardadas" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row gy-3 gx-3">
                    <div class="col-lg-12">
                        <label for="">Número de escritura</label>
                        <input type="number" class="form-control" wire:model='numero_escritura'>
                        @error("numero_escritura")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12">
                        <label for="">Volumen</label>
                        <input type="number" class="form-control" wire:model='volumen'>
                        @error("volumen")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12">
                        <label for="">Abogado</label>
                        <div wire:ignore>
                            <select wire:model='abogado_id' id="abogado-select-id">
                                <option value="">Ninguno...</option>
                                @foreach ($abogados as $abogado)
                                    <option value="{{$abogado->id}}">{{$abogado->name}} {{$abogado->apaterno}} {{$abogado->amaterno}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error("abogado_id")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <label for="">Folio inicio</label>
                        <input type="number" class="form-control" wire:model='f_inicio'>
                        @error("f_inicio")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <label for="">Folio final</label>
                        <input type="number" class="form-control" wire:model='f_final'>
                        @error("f_final")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12">
                        <label for="">Fecha escritura</label>
                        <input type="datetime-local" class="form-control" wire:model='fecha'>
                        @error("fecha")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                @can('autorizar-escritura-pendiente')
                    <a href="#" class="text-warning" wire:click='autorizar_escritura_modal'>Autorizar</a>
                @endcan
                <div>
                    <a wire:click='clearInputs' href="#" data-bs-dismiss="modal" class="me-3">Cerrar</a>
                    <button wire:click='registrar' class="btn btn-outline-success">Guardar</button>
                </div>
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
    window.addEventListener('open-modal-escrituras-guardadas', event => {
        $(".modal-escrituras-guardadas").modal("show")
        new TomSelect('#abogado-select-id',{
            persist: false,
            createOnBlur: true,
        })
    })

    window.addEventListener('close-modal-escrituras-guardadas', event => {
        $(".modal-escrituras-guardadas").modal("hide")
    })
</script>

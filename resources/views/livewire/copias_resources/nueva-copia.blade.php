<div wire:ignore.self class="modal fade modal-nueva-copia"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Nueva Copia</h5>
            </div>
            <div class="modal-body">
                <div class="row gx-3 gy-3">
                    <div class="col-lg-12">
                        <label for="">Costo por copia</label>
                        <input type="number" class="form-control" wire:model='costo_copias'>
                        @error("costo_copias")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12">
                        <label for="">Cantidad de copias</label>
                        <input type="number" class="form-control" wire:model='cantidad_copias'>
                        @error("costo_copias")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12">
                        <label for="">Cantidad de juegos</label>
                        <input type="number" class="form-control" wire:model='juegos'>
                        @error("costo_copias")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12" wire:ignore>
                        <label for="">Cliente</label>
                        <select id="clientes-select" placeholder="Seleccionar..." autocomplete="off" wire:model='cliente_id'>
                            <option value="">Seleccionar...</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{$cliente->id}}">{{$cliente->nombre}} {{$cliente->apaterno}} {{$cliente->amaterno}}</option>
                            @endforeach
                        </select>
                        <script>
                            new TomSelect("#clientes-select", {
                                create: false,
                            });
                        </script>
                    </div>
                    @if ($path_copias == "")
                        <div class="col-lg-12">
                            <label for="">Copias Escaneadas</label>
                            <x-file-pond wire:model='path_copias'></x-file-pond>
                        </div>
                    @endif
                    @if ($path_copias != "")
                        <div class="col-lg-12">
                            <a href="/{{$path_copias}}" target="_blank" class="btn btn-outline-dark">Descargar Copia</a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="text-danger me-3" data-bs-dismiss="modal">Cancelar</a>
                <button wire:loading.attr='disabled' wire:click='registrar_copia' class="btn btn-outline-success">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-nueva-copia', event => {
        $(".modal-nueva-copia").modal("show")
    })

    window.addEventListener('cerrar-modal-nueva-copia', event => {
        $(".modal-nueva-copia").modal("hide")
    })
</script>

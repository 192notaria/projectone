<div wire:ignore.self class="modal fade modal-registrar-juzgado"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Registrar juzgado</h5>
            </div>
            <div class="modal-body">
                <div class="row gx-3 gy-3">
                    <div class="col-lg-12">
                        <label for="">Distrito</label>
                        <input type="text" class="form-control" wire:model='distrito'>
                        @error("distrito")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12">
                        <label for="">Adscripción</label>
                        <input type="text" class="form-control" wire:model='adscripcion'>
                        @error("adscripcion")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12" wire:ignore.self>
                        <label for="">Nombre (Buscar en Clientes)</label>
                        <select id="tom-select-id" wire:model='cliente_id'>
                            <option value="" disabled selected>Seleccionar...</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{$cliente->id}}">
                                    {{$cliente->nombre}}
                                    {{$cliente->apaterno}}
                                    {{$cliente->amaterno}}
                                </option>
                            @endforeach
                        </select>
                        @error("cliente_id")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        <p class="mt-2">
                            <a href="#" class="text-warning" wire:click='abrirModalRegistrarCliente'><small>Registrar nuevo cliente</small></a>
                        </p>
                    </div>
                    <div class="col-lg-12">
                        <label for="">Domicilio</label>
                        <textarea class="form-control" cols="30" rows="5" wire:model='domicilio'></textarea>
                        @error("domicilio")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="text-danger me-3" href="#" data-bs-dismiss="modal">Cerrar</a>
                <button wire:click='registrarJuzgado' class="btn btn-outline-success">Guardar</button>
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
    window.addEventListener('abrir-modal-registrar-juzgado', event => {
        $(".modal-registrar-juzgado").modal("show")
        new TomSelect('#tom-select-id');
    })

    window.addEventListener('cerrar-modal-registrar-juzgado', event => {
        $(".modal-registrar-juzgado").modal("hide")
    })
</script>

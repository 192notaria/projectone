<div wire:ignore.self class="modal fade modal-registrar-declaracion"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-between" style="width: 100%;">
                    <h5>Registrar Declaracion</h5>
                </div>
            </div>
            <div class="modal-body">
                <div class="row gx-3 gy-3">
                    @if (!$escritura_data)
                        <div class="col-lg-12">
                            <div class="form-group autocomplete">
                                <label for="">Buscar escritura</label>
                                <input wire:model='buscarEscrituraInput' type="text" class="form-control" placeholder="Buscar...">
                                <div class="autocomplete-items">
                                    @foreach ($escrituras as $escritura)
                                    <a wire:click='asignar_escritura({{$escritura->id}})'>
                                        <div>
                                            <strong>
                                                {{$escritura->servicio->nombre}} - {{$escritura->cliente->nombre}} {{$escritura->cliente->apaterno}} {{$escritura->cliente->amaterno}} - {{$escritura->numero_escritura}}
                                            </strong>
                                        </div>
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($escritura_data)
                        <div class="col-lg-12">
                            <span class="avatar-chip avatar-dismiss bg-success mb-2 me-4">
                                <span class="text">
                                    {{$escritura_data['cliente']['nombre']}} {{$escritura_data['cliente']['apaterno']}} {{$escritura_data['cliente']['amaterno']}} -
                                    {{$escritura_data['servicio']['nombre']}} -
                                    {{$escritura_data['numero_escritura']}}
                                </span>
                                <a href="#" wire:click='remover_escritura'>
                                    <span class="closebtn ms-2">x</span>
                                </a>
                            </span>
                        </div>
                    @endif
                    <div class="col-lg-12">
                        <label for="">Fecha</label>
                        <input type="date" class="form-control" wire:model='fecha'>
                        @error("fecha")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12">
                        <label for="">Observaciones</label>
                        <textarea class="form-control" cols="30" rows="5" wire:model='observaciones'></textarea>
                    </div>
                    <div class="col-lg-12">
                        <label for="">Documentos</label>
                        <x-file-pond wire:model='documentos' multiple accept="application/pdf"></x-file-pond>
                        @error('documentos.*') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <style>
                        .red-border{
                            border: 1px solid rgb(154, 0, 0) !important;
                        }

                        .green-border {
                            border: 1px solid rgb(0, 126, 0) !important;
                        }
                    </style>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-success" wire:click='registrar_declaracion'>
                    Guardar
                </button>
                <button class="btn btn-outline-danger" data-bs-dismiss="modal">
                    Cerrar
                </button>
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
    window.addEventListener('abrir-modal-registrar-declaracion', event => {
        $(".modal-registrar-declaracion").modal("show")
    })

    window.addEventListener('cerrar-modal-registrar-declaracion', event => {
        $(".modal-registrar-declaracion").modal("hide")
    })
</script>

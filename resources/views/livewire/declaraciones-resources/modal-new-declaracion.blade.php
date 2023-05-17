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
                    @if (count($documentos_data) > 0)
                        <label for="">Documentos importados</label>
                        <div wire:loading.remove class="d-flex justify-content-start">
                            @foreach ($documentos_data as $docs)
                                <button class="btn btn-primary position-relative btn-icon mb-2 me-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                                    <a href="#" wire:click='abrir_modal_eliminar_documento({{$docs->id}})'>
                                        <span class="badge badge-danger counter"><i class="fa-solid fa-trash"></i></span>
                                    </a>
                                </button>
                            @endforeach
                        </div>
                    @endif
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

<div wire:ignore.self class="modal fade modal-crear-proyecto"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-between" style="width: 100%;">
                    <h5>Crear proyecto</h5>
                </div>
            </div>

            <style>
                   .autocomplete {
                    position: relative;
                    display: inline-block;
                    width: 100%;
                }

                .autocomplete-items {
                    position: absolute;
                    border: 1px solid #d4d4d4;
                    border-bottom: none;
                    border-top: none;
                    z-index: 99;
                    top: 100%;
                    left: 0;
                    right: 0;
                }

                .autocomplete-items div {
                    padding: 10px;
                    cursor: pointer;
                    border-bottom: 1px solid #d4d4d4;
                    background-color: #ffff;
                }

                .autocomplete-items div:hover {
                    background-color: #e9e9e9;
                }
            </style>

            <div class="modal-body">
                <div class="row gx-3 gy-4">
                    <div class="col-lg-12">
                        <ul>
                            @error("servicio_id")
                                <li>{{$message}}</li>
                            @enderror
                            @error("cliente_id")
                                <li>{{$message}}</li>
                            @enderror
                            @error("usuario_id")
                                <li>{{$message}}</li>
                            @enderror
                            @error("numero_escritura")
                                <li>{{$message}}</li>
                            @enderror
                            @error("volumen_escritura")
                                <li>{{$message}}</li>
                            @enderror
                            @error("total_escritura")
                                <li>{{$message}}</li>
                            @enderror
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <label for="">Número de escritura</label>
                        <input type="text" class="form-control" wire:model='numero_escritura'>
                        @error("numero_escritura")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <label for="">Volumen</label>
                        <input type="text" class="form-control" wire:model='volumen_escritura'>
                        @error("volumen_escritura")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-12">
                        <label for="">Abogado</label>
                        <select class="form-select" wire:model='usuario_id'>
                            <option value="" selected disabled>Seleccionar...</option>
                            @foreach ($abogados as $abogado)
                                <option value="{{$abogado->id}}">{{$abogado->name}} {{$abogado->apaterno}} {{$abogado->amaterno}}</option>
                            @endforeach
                        </select>
                        @error("usuario_id")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:loading.remove wire:click='crear_proyecto' class="btn btn-outline-success">
                    Guardar
                </button>
                <span wire:loading><div class="spinner-border text-success align-self-center "></div></span>
                <button wire:loading.remove class="btn btn-outline-danger" data-bs-dismiss="modal">
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
    window.addEventListener('abrir-modal-crear-proyecto', event => {
        $(".modal-crear-proyecto").modal("show")
    })

    window.addEventListener('cerrar-modal-crear-proyecto', event => {
        $(".modal-crear-proyecto").modal("hide")
    })
</script>

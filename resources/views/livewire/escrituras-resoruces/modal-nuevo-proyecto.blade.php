<div wire:ignore.self class="modal fade modal-nuevo-proyecto"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Nuevo proyecto</h5>
            </div>
            <div class="modal-body">
                <p>
                    <ul>
                        @error('acto_honorarios')
                            <li class="text-danger">Es necesario colocar la cantidad de honorarios</li>
                        @enderror
                        @error('acto_juridico_id')
                            <li class="text-danger">Es necesario seleccionar un acto juridico</li>
                        @enderror
                        @error('proyecto_cliente')
                            <li class="text-danger">Es necesario asignar un cliente al proyecto</li>
                        @enderror
                        @error('proyecto_abogado')
                            <li class="text-danger">Es necesario asignar un abogado al proyecto</li>
                        @enderror
                    </ul>
                </p>
                <div class="simple-tab">
                    <ul class="nav nav-tabs" id="myTab" role="tablist" wire:ignore>
                        <li wire:ignore class="nav-item" role="presentation">
                            <button class="nav-link active" id="generales-tab" data-bs-toggle="tab" data-bs-target="#generales-tab-pane" type="button" role="tab" aria-controls="generales-tab-pane" aria-selected="true">General</button>
                        </li>
                        <li wire:ignore class="nav-item" role="presentation">
                            <button class="nav-link" id="costos_descuentos-tab" data-bs-toggle="tab" data-bs-target="#costos_descuentos-tab-pane" type="button" role="tab" aria-controls="costos_descuentos-tab-pane" aria-selected="false">Costos y descuentos</button>
                        </li>
                        <li wire:ignore class="nav-item" role="presentation">
                            <button class="nav-link" id="comentarios-tab" data-bs-toggle="tab" data-bs-target="#comentarios-tab-pane" type="button" role="tab" aria-controls="comentarios-tab-pane" aria-selected="false">Observaciones</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div wire:ignore.self class="tab-pane fade show active" id="generales-tab-pane" role="tabpanel" aria-labelledby="generales-tab" tabindex="0">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group autocomplete">
                                        <label for="">Abogado</label>
                                        @if (!$proyecto_abogado)
                                            <input wire:model='buscar_abogado' type="text" class="form-control" placeholder="Buscar...">
                                            <div class="autocomplete-items">
                                                @foreach ($abogados as $abogado)
                                                    <a wire:click='asignar_abogado({{$abogado}})'>
                                                        <div>
                                                            <strong>
                                                                {{$abogado->name}} {{$abogado->apaterno}} {{$abogado->amaterno}}
                                                            </strong>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @if ($proyecto_abogado)
                                    <div class="col-lg-12 mb-2">
                                        <span class="mt-2 avatar-chip avatar-dismiss bg-primary me-4 position-relative">
                                            <img onerror="this.src='/v3/src/assets/img/avatarprofile.png';" src="{{url($proyecto_abogado['user_image'])}}" alt="Person" width="96" height="96">
                                            <span class="text">{{$proyecto_abogado['name']}} {{$proyecto_abogado['apaterno']}} {{$proyecto_abogado['amaterno']}}</span>
                                            <a wire:click='remover_abogado'>
                                                <span class="closebtn ms-2">x</span>
                                            </a>
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-12 mt-4">
                                <div class="form-group autocomplete">
                                    <label for="">Asistentes</label>
                                    @if ($proyecto_abogado)
                                        <input wire:model='buscar_abogado' type="text" class="form-control" placeholder="Buscar...">
                                        @error('asistente-registrado')
                                            <span class="badge badge-warning mt-2 mb-2">{{$message}}</span>
                                        @enderror
                                        <div class="autocomplete-items">
                                            @foreach ($abogados as $asistente)
                                                <a wire:click='agregar_asistente({{$asistente}})'>
                                                    <div>
                                                        <strong>
                                                            {{$asistente->name}} {{$asistente->apaterno}} {{$asistente->amaterno}}
                                                        </strong>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                    @if (!$proyecto_asistentes)
                                        <span class="mt-2 badge badge-danger">Sin asistentes</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12 mt-2">
                                @foreach ($proyecto_asistentes as $key => $asistente_data)
                                    <span class="mt-2 avatar-chip avatar-dismiss bg-primary me-4 position-relative">
                                        <img onerror="this.src='/v3/src/assets/img/avatarprofile.png';" src="{{url($asistente_data['user_image'])}}" alt="Person" width="96" height="96">
                                        <span class="text">{{$asistente_data['name']}} {{$asistente_data['apaterno']}} {{$asistente_data['amaterno']}}</span>
                                        <a wire:click='remover_asistente({{$key}})'>
                                            <span class="closebtn ms-2">x</span>
                                        </a>
                                    </span>
                                @endforeach
                            </div>
                            <div class="col-lg-12 mt-4">
                                <div class="form-group autocomplete">
                                    <label for="">Cliente</label>
                                    @if (!$proyecto_cliente)
                                        <input wire:model='buscar_cliente' type="text" class="form-control" placeholder="Buscar...">
                                        <div class="autocomplete-items">
                                            @foreach ($clientes as $cliente)
                                                <a wire:click='asignar_cliente({{$cliente}})'>
                                                    <div>
                                                        <strong>
                                                            {{$cliente->nombre}} {{$cliente->apaterno}} {{$cliente->amaterno}}
                                                        </strong>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @if ($proyecto_cliente)
                                <div class="col-lg-12">
                                    <span class="mt-2 avatar-chip avatar-dismiss bg-primary position-relative">
                                        <img src="{{url('/v3/src/assets/img/avatarprofile.png')}}" alt="Person" width="96" height="96">
                                        <span class="text">{{$proyecto_cliente['nombre']}} {{$proyecto_cliente['apaterno']}} {{$proyecto_cliente['amaterno']}}</span>
                                        <a wire:click='remover_cliente'>
                                            <span class="closebtn ms-2">x</span>
                                        </a>
                                    </span>
                                </div>
                            @endif
                            <div class="col-lg-12 mt-4">
                                <label for="">Acto</label>
                                <select class="form-select" wire:model='acto_juridico_id' wire:change='buscarHonorarios'>
                                    <option value="">Seleccionar...</option>
                                    @foreach ($actos as $acto)
                                        <option value="{{$acto->id}}">{{$acto->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div wire:ignore.self class="tab-pane fade" id="costos_descuentos-tab-pane" role="tabpanel" aria-labelledby="costos_descuentos-tab" tabindex="0">
                            <div class="row">
                                <div class="col-lg-6 mt-2 mb-2">
                                    <div class="form-group">
                                        <label for="">Honorarios</label>
                                        <input type="number" class="form-control" placeholder="$0.0" wire:model='acto_honorarios'>
                                        @error('acto_honorarios')
                                            <span class="text-danger">Es necesario colocar la cantidad de honorarios</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-2 mt-2">
                                    <div class="form-group">
                                        <label for="">Descuento</label>
                                        <input type="number" class="form-control" placeholder="$0.0" wire:model='acto_descuento'>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-2 mt-2">
                                    <div class="row">
                                        @if ($conceptos_pago)
                                            <div class="col-lg-12 mt-4">
                                                <h6>Impuestos y derechos</h6>
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <button wire:click='guardarCostos' class="btn btn-outline-primary"><i class="fa-solid fa-plus"></i> Agregar concepto</button>
                                            </div>
                                            @foreach ($conceptos_pago as $concepto)
                                                <div class="mb-1 mt-1 col-lg-6 d-xl-flex d-block justify-content-between">
                                                    <div>
                                                        <label>{{$concepto->descripcion}}</label>
                                                    </div>
                                                    <div>
                                                        <input wire:model='costos_proyecto.{{$concepto->id}}' type="number" class="form-control" placeholder="$0.0">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div wire:ignore.self class="tab-pane fade" id="comentarios-tab-pane" role="tabpanel" aria-labelledby="comentarios-tab" tabindex="0">
                            <div class="row">
                                <div class="col-lg-12">
                                    <textarea wire:model='proyecto_descripcion' placeholder="Sin comentarios..." class="form-control" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='crear_proyecto' class="btn btn-outline-success">
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
    window.addEventListener('abrir-modal-nuevo-proyecto', event => {
        $(".modal-nuevo-proyecto").modal("show")
    })

    window.addEventListener('cerrar-modal-nuevo-proyecto', event => {
        $(".modal-nuevo-proyecto").modal("hide")

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


</script>
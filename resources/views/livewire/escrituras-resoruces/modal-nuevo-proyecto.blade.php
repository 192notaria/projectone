<div wire:ignore.self class="modal fade modal-nuevo-proyecto"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-between" style="width: 100%;">
                    <h5>Nuevo proyecto</h5>
                    <div class="text-center">
                        <button wire:click='crear_proyecto' class="btn btn-outline-success">
                            Guardar
                        </button>
                        <button class="btn btn-outline-danger" data-bs-dismiss="modal">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <p>
                    <ul>
                        @error('acto_honorarios')
                            <li class="text-danger">{{$message}}</li>
                        @enderror
                        @error('acto_juridico_id')
                            <li class="text-danger">{{$message}}</li>
                        @enderror
                        @error('proyecto_cliente')
                            <li class="text-danger">{{$message}}</li>
                        @enderror
                        @error('proyecto_abogado')
                            <li class="text-danger">{{$message}}</li>
                        @enderror
                        @error("numero_escritura")
                            <li class="text-danger">{{$message}}</li>
                        @enderror
                        @error("volumen_escritura")
                            <li class="text-danger">{{$message}}</li>
                        @enderror
                    </ul>
                </p>
                <div class="row gx-3 gy-3">
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
                        @error("proyecto_abogado")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
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
                    {{-- <div class="col-lg-12 mt-4">
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
                    </div> --}}
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
                        @error("proyecto_cliente")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
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
                            <option value="" disabled>Seleccionar...</option>
                            @foreach ($actos as $acto)
                                <option value="{{$acto->id}}">{{$acto->nombre}}</option>
                            @endforeach
                        </select>
                        @error("acto_juridico_id")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    @if ($acto_juridico_id == 25)
                        <div class="col-lg-12 mt-4">
                            <label for="">Tipo de Acta de asamblea</label>
                            <select class="form-select" wire:model='tipo_servicio'>
                                <option value="" disabled>Seleccionar...</option>
                                <option value="Extraordinaria">Extraordinaria</option>
                                <option value="Ordinaria">Ordinaria</option>
                                <option value="Mixta">Mixta</option>
                            </select>
                            @error("tipo_servicio")
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    @endif
                    @if ($acto_juridico_id == 22)
                        <div class="col-lg-12 mt-4">
                            <label for="">Tipo de Acta constitutiva</label>
                            <select class="form-select" wire:model='tipo_servicio'>
                                <option value="" disabled>Seleccionar...</option>
                                <option value="Asociaciones">Asociaciones</option>
                                <option value="Sociedades">Sociedades</option>
                            </select>
                            @error("tipo_servicio")
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    @endif
                    @if ($acto_juridico_id == 2)
                        <div class="col-lg-12 mt-4">
                            <label for="">Tipo de Compraventa</label>
                            <select class="form-select" wire:model='tipo_servicio'>
                                <option value="" disabled>Seleccionar...</option>
                                <option value="De Contado">De Contado</option>
                                <option value="Credito Banorte">Credito Banorte</option>
                                <option value="Credito Cofinavit">Credito Cofinavit</option>
                                <option value="Credito Foviiste">Credito Fovissste</option>
                                <option value="Credito infonavit">Credito Infonavit</option>
                                <option value="Credito Pensiones Civiles">Credito Pensiones Civiles</option>
                            </select>
                            @error("tipo_servicio")
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    @endif
                    <div class="col-lg-12 mt-4">
                        <div class="form-group">
                            <label for="">Honorarios</label>
                            <input type="number" class="form-control" placeholder="$0.0" wire:model='acto_honorarios'>
                            @error('acto_honorarios')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12 mb-2 mt-2">
                        <div class="row">
                            @if ($conceptos_pago)
                                <div class="col-lg-12 mt-4">
                                    <h6>Impuestos y derechos</h6>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <button wire:click='modalAgregarConcepto' class="btn btn-outline-primary"><i class="fa-solid fa-plus"></i> Agregar concepto</button>
                                </div>
                                @foreach ($conceptos_pago as $concepto)
                                    <div class="mb-1 mt-1 col-lg-6 d-xl-flex d-block justify-content-between">
                                        <div>
                                            <label>{{$concepto['descripcion']}}</label>
                                        </div>
                                        <div>
                                            <input wire:model='costos_proyecto.{{$concepto['id']}}' type="number" class="form-control" placeholder="$0.0">
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <textarea wire:model='proyecto_descripcion' placeholder="Sin comentarios..." class="form-control" cols="30" rows="10"></textarea>
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

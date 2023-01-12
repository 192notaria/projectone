<div wire:ignore.self class="modal fade modal-nuevo-proyecto-clientes"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Nuevo proyecto de escritura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="">Servicio</label>
                            <select wire:model="servicio_id" class="form-select">
                                <option value="" selected disabled>Seleccionar servicio...</option>
                                @foreach ($proyectos_escrituras as $servicio)
                                    <option value="{{$servicio->id}}">{{$servicio->nombre}}</option>
                                @endforeach
                            </select>
                            @error('servicio_id') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group mb-3">
                            <label for="">Numero de escritura</label>
                            <input type="number" wire:model="numero_de_escritura" class="form-control" placeholder="Numero...">
                            @error('numero_de_escritura') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group mb-3">
                            <label for="">Volumen</label>
                            <input type="number" wire:model="volumen" class="form-control" placeholder="Volumen...">
                            @error('volumen') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group mb-3 autocomplete">
                            <label for="">Asignar abogado</label>
                            <input type="text" class="form-control" wire:model='buscarAbogado' placeholder="Jorge Luis...">
                            {{-- <input type="hidden" wire:model='municipio_nacimiento_id'> --}}
                            @error('municipio_nacimiento_id') <span class="text-danger">{{ $message }}</span>@enderror
                            <div class="autocomplete-items-2">
                                @foreach ($abogados as $abogado)
                                    <div class="abogadolist">
                                        <a wire:click="asignarAbogado({{$abogado}})">
                                            <div class="media">
                                                <div class="avatar me-2">
                                                    <img alt="avatar" src="{{url($abogado->user_image)}}" class="rounded-circle" />
                                                </div>
                                                <div class="media-body align-self-center">
                                                    <span class="badge badge-primary">{{$abogado->name}} {{$abogado->apaterno}} {{$abogado->amaterno}}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        @if ($id_Abogado == "")
                            <div class="form-group text-center border border-danger">
                                <p class="text-danger">No se ha asignado un abogado para este proyecto</p>
                            </div>
                        @else
                            <div class="form-group text-center border border-success p-3">
                                <div class="row justify-content-lefth">
                                    <div class="col-lg-4">
                                        <div class="avatar avatar-xl">
                                            <img alt="avatar" src="{{url($avatarAbogado)}}" class="rounded" />
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <span class="fw-bold">
                                                    {{$nombreAbogado}} {{$apaternoAbogado}} {{$amaternoAbogado}}
                                                </span>
                                            </div>
                                            <div class="col-lg-6 text-start">
                                                <span class="fw-bold text-primary">Genero: </span>{{$generoAbogado}}
                                            </div>
                                            <div class="col-lg-6 text-start">
                                                <span class="fw-bold text-primary">Telefono: </span>{{$telefonoAbogado}}
                                            </div>
                                            <div class="col-lg-6 text-start">
                                                <span class="fw-bold text-primary">Email: </span>{{$emailAbogado}}
                                            </div>
                                            <div class="col-lg-6 text-start">
                                                <span class="fw-bold text-primary">Edad: </span>{{\Carbon\Carbon::parse($fecha_nacimientoAbogado)->diff(\Carbon\Carbon::now())->format('%y')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click='guardarProyecto' type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-nuevo-proyecto-clientes', event => {
        $(".modal-nuevo-proyecto-clientes").modal("show")
    })

    window.addEventListener('cerrar-modal-nuevo-proyecto-clientes', event => {
        $(".modal-nuevo-proyecto-clientes").modal("hide")

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

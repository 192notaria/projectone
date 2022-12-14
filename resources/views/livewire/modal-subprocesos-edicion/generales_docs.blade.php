<div wire:ignore.self class="modal fade modal-generales-docs"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">{{$tituloModal}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-3 autocomplete">

                                <label for="">Buscar en lista de clientes</label>
                                <input type="text" class="form-control" wire:model='buscarCliente' placeholder="Jorge Luis...">
                                @error('asignar_error')
                                    <span class="badge badge-danger" style="width: 100%">{{$message}}</span>
                                @enderror
                                <div class="autocomplete-items-2">
                                    @foreach ($clientes as $cliente)
                                        <div class="abogadolist">
                                            <a wire:click="asignarCliente({{$cliente}})">
                                                <div class="media">
                                                    <div class="avatar me-2">
                                                        <img alt="avatar" src="{{$cliente->genero == "Masculino" ? url('v3/src/assets/img/male-avatar.svg') : url('v3/src/assets/img/female-avatar.svg')}}" class="rounded-circle" />
                                                    </div>
                                                    <div class="media-body align-self-center">
                                                        <p><span class="text-primary">Nombre:</span> {{$cliente->nombre}} {{$cliente->apaterno}} {{$cliente->amaterno}}</p>
                                                        <p><span class="text-primary">Fecha de nacimiento:</span> {{$cliente->fecha_nacimiento}}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @if ($tipoGenerales == "")
                            <div class="col-lg-12 text-center">
                                <span class="badge badge-warning" style="width: 100%">Sin cliente asignado</span>
                            </div>
                        @else
                            <div class="col-lg-12">
                                <div class="form-group text-center border border-success p-3">
                                    <div class="row justify-content-lefth">
                                        <div class="col-lg-4">
                                            <div class="avatar avatar-xl">
                                                <img alt="avatar" src="{{$tipoGenerales['genero'] == "Masculino" ? url('v3/src/assets/img/male-avatar.svg') : url('v3/src/assets/img/female-avatar.svg')}}" class="rounded" />
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-12 text-start">
                                                    <span class="fw-bold">
                                                        {{$tipoGenerales['nombre']}} {{$tipoGenerales['apaterno']}} {{$tipoGenerales['amaterno']}}
                                                    </span>
                                                </div>
                                                <div class="col-lg-6 text-start">
                                                    <span class="fw-bold text-primary">Genero: </span>{{$tipoGenerales['genero']}}
                                                </div>
                                                <div class="col-lg-6 text-start">
                                                    <span class="fw-bold text-primary">Telefono: </span>{{$tipoGenerales['telefono']}}
                                                </div>
                                                <div class="col-lg-6 text-start">
                                                    <span class="fw-bold text-primary">Email: </span>{{$tipoGenerales['email']}}
                                                </div>
                                                <div class="col-lg-6 text-start">
                                                    <span class="fw-bold text-primary">Edad: </span>{{\Carbon\Carbon::parse($tipoGenerales['fecha_nacimiento'])->diff(\Carbon\Carbon::now())->format('%y')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <label for="">Acta de nacimiento</label>
                                <x-file-pond wire:model="acta_nac"
                                    :options="['labelIdle' => 'Cargar un archivo... o arrastra y suelta']">
                                </x-file-pond>
                                @error('acta_nac') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-lg-12 mt-3">
                                <label for="">Acta de matrimonio</label>
                                <x-file-pond wire:model="acta_matrimonio"
                                    :options="['labelIdle' => 'Cargar un archivo... o arrastra y suelta']">
                                </x-file-pond>
                                @error('acta_matrimonio') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-lg-12 mt-3">
                                <label for="">CURP</label>
                                <x-file-pond wire:model="curp"
                                    :options="['labelIdle' => 'Cargar un archivo... o arrastra y suelta']">
                                </x-file-pond>
                                @error('curp') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-lg-12 mt-3">
                                <label for="">RFC</label>
                                <x-file-pond wire:model="rfc"
                                    :options="['labelIdle' => 'Cargar un archivo... o arrastra y suelta']">
                                </x-file-pond>
                                @error('rfc') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-lg-12 mt-3">
                                <label for="">Identificacion oficial con fotografia</label>
                                <x-file-pond wire:model="identificacion_oficial"
                                    :options="['labelIdle' => 'Cargar un archivo... o arrastra y suelta']">
                                </x-file-pond>
                                @error('identificacion_oficial') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                            <div class="col-lg-12 mt-3">
                                <label for="">Comprobante de domicilio</label>
                                <x-file-pond wire:model="comprobante_domicilio"
                                    :options="['labelIdle' => 'Cargar un archivo... o arrastra y suelta']">
                                </x-file-pond>
                                @error('comprobante_domicilio') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click='editarGeneralesDocs' type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-editar-generales-docs', event => {
        $(".modal-generales-docs").modal("show")
    })
    window.addEventListener('cerrar-editar-generales-docs', event => {
        $(".modal-generales-docs").modal("hide")
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

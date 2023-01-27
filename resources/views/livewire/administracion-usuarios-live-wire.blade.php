<div class="row">
    <div class="col-lg-12 mb-2" style="display:flex; align-items:right;">
        @can('crear-usuarios')
            <button type="button" wire:click='openModal' class="btn btn-outline-success mr-2">
                <i class="fa-solid fa-user-plus"></i>
            </button>
        @endcan
        <select wire:model='cantidadUsuarios' class="form-select" style="width: 6%; margin-left: 5px; margin-right: 5px;">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="20">20</option>
            <option value="50">50</option>
        </select>
        <input type="text" wire:model="search" class="form-control" placeholder="Buscar..." autocomplete="off">
    </div>
    <div class="col-lg-12">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Role</th>
                    @role('ADMINISTRADOR')
                        <th class="text-center" scope="col">Status</th>
                        <th class="text-center" scope="col">Ultima actividad</th>
                    @endrole
                    <th class="text-center" scope="col"></th>
                </tr>
                <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                @if ($usuario->email != "admin@admin.com")
                    <tr>
                        <td>
                            <div class="media">
                                <div class="avatar me-2">
                                    <img alt="avatar" src="{{$usuario->user_image}}" class="rounded-circle" />
                                </div>
                                <div class="media-body align-self-center">
                                    <h6 class="mb-0">{{$usuario->name}} {{$usuario->apaterno}} {{$usuario->amaterno}}</h6>
                                    <span>{{$usuario->email}}</span>
                                </div>
                                <p>
                                    <button
                                        @if (!$recording)
                                            wire:click='startRecording({{$usuario->id}})'
                                            class="btn btn-primary"
                                        @endif
                                        @if ($recording && $interphoneUser != $usuario->id)
                                            class="btn btn-primary"
                                            disabled
                                        @endif
                                        @if ($interphoneUser == $usuario->id && $recording)
                                            wire:click='stopRecording'
                                            class="btn btn-danger"
                                        @endif
                                        >

                                        @if (!$recording)
                                            <i class="fa-solid fa-microphone"></i>
                                        @endif
                                        @if ($recording && $interphoneUser != $usuario->id)
                                            <i class="fa-solid fa-microphone"></i>
                                        @endif
                                        @if ($interphoneUser == $usuario->id && $recording)
                                            <i class="fa-solid fa-circle-stop"></i>
                                        @endif
                                    </button>
{{--
                                    @if(!$recording)
                                    @else
                                        <button @if ($interphoneUser != $usuario->id) disabled @endif wire:click='stopRecording' class="btn btn-danger"><i class="fa-solid fa-circle-stop"></i></button>
                                    @endif --}}
                                </p>
                            </div>

                        </td>
                        <td>
                            @if (isset($usuario))
                                <p class="mb-0">
                                    @foreach ($usuario->roles as $rolName)
                                        <h5>
                                            <span class="badge badge-primary">{{$rolName->name}}</span>
                                        </h5>
                                    @endforeach
                                </p>
                                <span class="text-success">{{$usuario->getOcupacion->nombre}}</span>
                            @endif
                        </td>
                        @role('ADMINISTRADOR')
                            <td class="text-center">
                                @if (Cache::has('user-is-online-' . $usuario->id))
                                    <span class="badge badge-light-success">Online</span>
                                @else
                                    <span class="badge badge-light-danger">Offline</span>
                                @endif
                            </td>
                        @endrole

                        @role('ADMINISTRADOR')
                            <td class="text-center">
                                @if ($usuario->last_seen != null)
                                    <span>
                                        <i class="fa-solid fa-clock"></i>
                                        {{ \Carbon\Carbon::parse($usuario->last_seen)->diffForHumans(now()) }}
                                    </span>
                                @endif
                            </td>
                        @endrole

                        <td class="text-center">
                            <div class="action-btns">
                                @can('ban-usuario')
                                    <a wire:click='closeSession({{$usuario->id}})' title="Bloquear usuario" style="cursor: pointer;" class="action-btn btn-view bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="View">
                                        <i class="fa-solid fa-ban text-danger"></i>
                                    </a>
                                @endcan
                                <a wire:click='verUsuarios({{$usuario->id}})' style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#userInfoModal" class="action-btn btn-view bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="View">
                                    <i class="fa-solid fa-eye text-primary"></i>
                                </a>
                                @can('editar-usuarios')
                                    <a style="cursor: pointer;" wire:click='editarRegistro({{ $usuario->id }})' class="action-btn btn-edit bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fa-solid fa-pen-to-square text-success"></i>
                                    </a>
                                @endcan
                                @can('borrar-usuarios')
                                    <a style="cursor: pointer;" wire:click='borrarRegistro({{ $usuario->id }}, {{auth()->user()->id}})' class="action-btn btn-delete bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete">
                                        <i class="fa-sharp fa-solid fa-trash text-danger"></i>
                                    </a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endif

                @endforeach
            </tbody>
        </table>
        {{$usuarios->links('pagination-links')}}
    </div>

    <style>
        .modal{
            backdrop-filter: blur(5px);
            background-color: #01223770;
            -webkit-animation: fadeIn 0.3s;
            font-weight: bold;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        @keyframes fadeOut {
            0% { opacity: 1; }
            100% { opacity: 0; }
        }
    </style>

    <!-- Modal -->
    <div class="modal @if($modal) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modal) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modal) aria-modal="true" @endif  @if(!$modal) aria-hidden="true" @endif>
        <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Nuevo Usuario</h5>
                        <button wire:click='closeModal' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="">Nombre</label>
                                    <input type="hidden" wire:model="id_usuario" class="form-control">
                                    <input wire:model="name" type="text" class="form-control" placeholder="Juan">
                                    @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="">Apellido Paterno</label>
                                    <input wire:model="apaterno" type="text" class="form-control" placeholder="Perez">
                                    @error('apaterno') <span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-3">
                                    <label for="">Apellido Materno</label>
                                    <input wire:model="amaterno" type="text" class="form-control" placeholder="Rodriguez">
                                    @error('amaterno') <span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="">Genero</label>
                                    <select wire:model="genero" name="genero" class="form-control">
                                        <option value="" selected disabled>Seleccionar...</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                    </select>
                                    @error('genero') <span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="">Telefono</label>
                                    <input wire:model="telefono" type="number" class="form-control" placeholder="4521234567">
                                    @error('telefono') <span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="">Fecha de nacimiento</label>
                                    <input wire:model="fecha_nacimiento" type="date" class="form-control">
                                    @error('fecha_nacimiento') <span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="">Ocupacion</label>
                                    {{-- <input wire:model="ocupacion" type="text" class="form-control"> --}}
                                    <select wire:model="ocupacion" class="form-select">
                                        <option value="" selected disabled>Seleccionar...</option>
                                        @foreach ($ocupaciones as $ocupacion)
                                            <option value="{{$ocupacion->id}}">{{$ocupacion->nombre}}</option>
                                        @endforeach
                                    </select>
                                    @error('ocupacion') <span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="">Email</label>
                                    <input wire:model="email" type="email" class="form-control" placeholder="usuario@correo.com">
                                    @error('email') <span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="">Contraseña</label>
                                    <input wire:model="password" type="password" class="form-control" placeholder="********">
                                    @error('password') <span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="">Confirmar Contraseña</label>
                                    <input wire:model="password_confirmation" type="password" class="form-control" placeholder="********">
                                    @error('password_confirmation') <span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label for="">Rol de usuario</label>
                                    <select wire:model='selectedRol' class="form-control">
                                        <option value="" selected disabled>Seleccionar...</option>
                                        @foreach ($rolesUsuario as $rol)
                                            <option value="{{$rol}}">{{$rol}}</option>
                                        @endforeach
                                    </select>
                                    @error('rolesUsuario') <span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button wire:click='closeModal' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                        <button wire:click.prevent='save({{ auth()->user()->id }})' type="button" class="btn btn-outline-primary">Guardar</button>
                    </div>
                </div>
        </div>
    </div>

    <!-- Modal Datos Usuario-->
    <div wire:ignore.self class="modal fade" id="userInfoModal" tabindex="-1" role="dialog" aria-labelledby="userInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {{-- <div class="modal-header">
                    <button type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div> --}}
                <div class="modal-body">
                    <div class="user-profile">
                        <div class="widget-content widget-content-area">
                            <div class="d-flex justify-content-between">
                                <h3>
                                    @if (isset($usuario))
                                        @foreach ($usuario->getRoleNames() as $rolName)
                                            <span class="badge badge-success">{{$rolName}}</span>
                                        @endforeach
                                    @endif
                                </h3>
                                <button class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            <div class="text-center user-info">
                                <img src="http://notaria-v1.0.0.test/v3/src/assets/img/g-8.png" alt="avatar">
                                <p class="">{{$name}} {{$apaterno}} {{$amaterno}}</p>
                            </div>
                            <div class="user-info-list">
                                <div class="">
                                    <ul class="contacts-block list-unstyled">
                                        <li class="contacts-block__item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-coffee me-3"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>
                                            {{$ocupacion->nombre}}
                                        </li>
                                        <li class="contacts-block__item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar me-3"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                            {{$fecha_nacimiento}}
                                        </li>
                                        <li class="contacts-block__item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin me-3"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                            Morelia Michoacan
                                        </li>
                                        <li class="contacts-block__item">
                                            <a href="mailto:{{$email}}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail me-3"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                                {{$email}}
                                            </a>
                                        </li>
                                        <li class="contacts-block__item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone me-3"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                            {{$telefono}}
                                        </li>
                                    </ul>

                                    <ul class="list-inline mt-4">
                                        <li class="list-inline-item mb-0">
                                            <a class="btn btn-info btn-icon btn-rounded" href="javascript:void(0);">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                                            </a>
                                        </li>
                                        <li class="list-inline-item mb-0">
                                            <a class="btn btn-danger btn-icon btn-rounded" href="javascript:void(0);">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dribbble"><circle cx="12" cy="12" r="10"></circle><path d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72m2.54-15.38c-3.72 4.35-8.94 5.66-16.88 5.85m19.5 1.9c-3.5-.93-6.63-.82-8.94 0-2.58.92-5.01 2.86-7.44 6.32"></path></svg>
                                            </a>
                                        </li>
                                        <li class="list-inline-item mb-0">
                                            <a class="btn btn-dark btn-icon btn-rounded" href="javascript:void(0);">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <script src="{{ url('v3/recorder/app.js') }}"></script> --}}
    <script src="{{ url('v3/recorder/recorder.js') }}"></script>
    <script>

        var userid; 						//stream from getUserMedia()
        var gumStream; 						//stream from getUserMedia()
        var rec; 							//Recorder.js object
        var input; 							//MediaStreamAudioSourceNode we'll be recording

        // shim for AudioContext when it's not avb.
        var AudioContext = window.AudioContext || window.webkitAudioContext;
        var audioContext //audio context to help us record
        window.addEventListener('start-interphone', event => {
            console.log("start")
            startRecording()
        })

        window.addEventListener('stop-interphone', event => {
            userid = event.detail
            stopRecording()
        })


        function startRecording(){
            var constraints = { audio: true, video:true }
            // recordButton.disabled = true;
            // stopButton.disabled = false;
            // pauseButton.disabled = false
            navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
                // console.log("getUserMedia() success, stream created, initializing Recorder.js ...");
                audioContext = new AudioContext();
                // document.getElementById("formats").innerHTML="Format: 1 channel pcm @ " + audioContext.sampleRate/1000+"kHz"
                gumStream = stream
                input = audioContext.createMediaStreamSource(stream)
                rec = new Recorder(input,{numChannels:1})
                rec.record()
            }).catch(function(err) {
                // recordButton.disabled = false;
                // stopButton.disabled = true;
                // pauseButton.disabled = true
            });
        }


        function stopRecording() {
            rec.stop();
            // gumStream.getAudioTracks()[0].stop();
            gumStream.getAudioTracks().forEach(track => {
                track.stop();
            });
            rec.exportWAV(createDownloadLink);
        }

        function createDownloadLink(blob) {
            var url = URL.createObjectURL(blob);
            var filename = new Date().toISOString();
            var fd =new FormData();

            fd.append("audio_data", blob, filename);
            fd.append("_token", "{{csrf_token()}}");
            fd.append("user_id", userid);

            $.ajax({
                url: "http://192.168.68.157/intefone",
                type: 'POST',
                data: fd,
                // headers:{
                //     "_token": '{{csrf_token()}}'
                // },
                success: function (data) {
                    console.log(data)
                },
                error: function(error){
                    console.log(error)
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    </script>
</div>

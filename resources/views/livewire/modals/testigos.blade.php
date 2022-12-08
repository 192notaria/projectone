<div class="modal @if($modalAvance) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modalAvance) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modalAvance) aria-modal="true" @endif  @if(!$modalAvance) aria-hidden="true" @endif>
    <div class="modal-dialog modal-lg" role="document">
        <form wire:submit.prevent="registrarAsignacion">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{$tituloModal}}</h5>
                    <button wire:click='closeModal' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                        <i class="fa-solid fa-circle-xmark"></i>
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
                                        <span class="badge badge-warning" style="width: 100%">Sin testigos asignados</span>
                                    </div>
                                @else
                                    <div class="col-lg-12">
                                        <div class="form-group text-center border border-success p-3">
                                            <div class="row justify-content-lefth">
                                                <div class="col-lg-4">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="avatar avatar-xl">
                                                                <img alt="avatar" src="{{$tipoGenerales['genero'] == "Masculino" ? url('v3/src/assets/img/male-avatar.svg') : url('v3/src/assets/img/female-avatar.svg')}}" class="rounded" />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 text-center">
                                                            <span class="fw-bold">
                                                                {{$tipoGenerales['nombre']}} {{$tipoGenerales['apaterno']}} {{$tipoGenerales['amaterno']}}
                                                            </span>
                                                        </div>
                                                        <div class="col-lg-12 text-start">
                                                            <span class="fw-bold text-primary">Genero: </span>{{$tipoGenerales['genero']}}
                                                        </div>
                                                        <div class="col-lg-12 text-start">
                                                            <span class="fw-bold text-primary">Telefono: </span>{{$tipoGenerales['telefono']}}
                                                        </div>
                                                        <div class="col-lg-12 text-start">
                                                            <span class="fw-bold text-primary">Email: </span>{{$tipoGenerales['email']}}
                                                        </div>
                                                        <div class="col-lg-12 text-start">
                                                            <span class="fw-bold text-primary">Edad: </span>{{\Carbon\Carbon::parse($tipoGenerales['fecha_nacimiento'])->diff(\Carbon\Carbon::now())->format('%y')}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="row">
                                                        <div class="col-lg-12 mt-3">
                                                            <label for="">Acta de nacimiento</label>
                                                            {{-- <input type="file" class="form-control" wire:model="acta_nac"> --}}
                                                            @if ($modalAvance)
                                                                <x-file-pond wire:model="acta_nac" x-init="
                                                                    var Pond = FilePond.create($refs.input);
                                                                    this.addEventListener('pondReset', e => {
                                                                        Pond.removeFiles();
                                                                    });" :options="['labelIdle' => 'Cargar un archivo... o arrastra y suelta']">
                                                                </x-file-pond>
                                                            @endif
                                                            @error('acta_nac') <span class="text-danger">{{$message}}</span> @enderror
                                                        </div>
                                                        <div class="col-lg-12 mt-3">
                                                            <label for="">Acta de matrimonio</label>
                                                            {{-- <input type="file" class="form-control" wire:model="acta_matrimonio"> --}}
                                                            @if ($modalAvance)
                                                            <x-file-pond wire:model="acta_matrimonio" x-init="
                                                                var Pond = FilePond.create($refs.input);
                                                                this.addEventListener('pondReset', e => {
                                                                    Pond.removeFiles();
                                                                });" :options="['labelIdle' => 'Cargar un archivo... o arrastra y suelta']">
                                                            </x-file-pond>
                                                        @endif
                                                        @error('acta_matrimonio') <span class="text-danger">{{$message}}</span> @enderror
                                                        </div>
                                                        <div class="col-lg-12 mt-3">
                                                            <label for="">CURP</label>
                                                            {{-- <input type="file" class="form-control" wire:model="curp"> --}}
                                                            @if ($modalAvance)
                                                                <x-file-pond wire:model="curp" x-init="
                                                                    var Pond = FilePond.create($refs.input);
                                                                    this.addEventListener('pondReset', e => {
                                                                        Pond.removeFiles();
                                                                    });" :options="['labelIdle' => 'Cargar un archivo... o arrastra y suelta']">
                                                                </x-file-pond>
                                                            @endif
                                                            @error('curp') <span class="text-danger">{{$message}}</span> @enderror
                                                        </div>
                                                        <div class="col-lg-12 mt-3">
                                                            <label for="">RFC</label>
                                                            {{-- <input type="file" class="form-control" wire:model="rfc"> --}}
                                                            @if ($modalAvance)
                                                                <x-file-pond wire:model="rfc" x-init="
                                                                    var Pond = FilePond.create($refs.input);
                                                                    this.addEventListener('pondReset', e => {
                                                                        Pond.removeFiles();
                                                                    });" :options="['labelIdle' => 'Cargar un archivo... o arrastra y suelta']">
                                                                </x-file-pond>
                                                            @endif
                                                            @error('rfc') <span class="text-danger">{{$message}}</span> @enderror
                                                        </div>
                                                        <div class="col-lg-12 mt-3">
                                                            <label for="">Identificacion oficial con fotografia</label>
                                                            {{-- <input type="file" class="form-control" wire:model="identificacion_oficial"> --}}
                                                            @if ($modalAvance)
                                                                <x-file-pond wire:model="identificacion_oficial" x-init="
                                                                    var Pond = FilePond.create($refs.input);
                                                                    this.addEventListener('pondReset', e => {
                                                                        Pond.removeFiles();
                                                                    });" :options="['labelIdle' => 'Cargar un archivo... o arrastra y suelta']">
                                                                </x-file-pond>
                                                            @endif
                                                            @error('identificacion_oficial') <span class="text-danger">{{$message}}</span> @enderror
                                                        </div>
                                                        <div class="col-lg-12 mt-3">
                                                            <label for="">Comprobante de domicilio</label>
                                                            {{-- <input type="file" class="form-control" wire:model="comprobante_domicilio"> --}}
                                                            @if ($modalAvance)
                                                                <x-file-pond wire:model="comprobante_domicilio" x-init="
                                                                    var Pond = FilePond.create($refs.input);
                                                                    this.addEventListener('pondReset', e => {
                                                                        Pond.removeFiles();
                                                                    });" :options="['labelIdle' => 'Cargar un archivo... o arrastra y suelta']">
                                                                </x-file-pond>
                                                            @endif
                                                            @error('comprobante_domicilio') <span class="text-danger">{{$message}}</span> @enderror
                                                        </div>
                                                        <div class="col-lg-12 mt-3 text-end">
                                                            <button wire:click='registrarTestigo' @if ($identificacion_oficial == "") disabled @endif class="btn btn-success">Guardar</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- @if ($testigos) --}}

                                                {{-- @endif --}}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                        </div>
                    </div>
                    @if (count($testigos) > 0)
                        <div class="container mt-4">
                            <h4>Testigos</h4>
                            <div class="row">
                                @foreach ($testigos as $testigo)
                                    <div class="col-lg-4 mt-3">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card style-6" href="javascript:void(0);">
                                                    <a style="cursor: pointer;" wire:click='borrarTestigo({{$testigo->id}})'>
                                                        <span class="badge badge-danger"><i class="fa-solid fa-trash"></i></span>
                                                    </a>
                                                    <img src="{{url('/v3/src/assets/img/avatarprofile.png')}}" class="card-img-top" alt="...">
                                                    <div class="card-footer">
                                                        <div class="row">
                                                            <div class="col-12 mb-0 text-center">
                                                                <b>{{$testigo->cliente->nombre}} {{$testigo->cliente->apaterno}} {{$testigo->cliente->amaterno}}</b>
                                                                <ul class="text-start text-info">
                                                                    <li>Masculino</li>
                                                                    <li>Edad</li>
                                                                    <li>4521996106</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
                <div class="modal-footer">
                    <button wire:click='closeModal' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                    @if (count($testigos) > 0) <button wire:click='guardarTestigos' type="submit" class="btn btn-outline-primary">Guardar</button>@endif
                </div>
            </div>
        </form>
    </div>
</div>

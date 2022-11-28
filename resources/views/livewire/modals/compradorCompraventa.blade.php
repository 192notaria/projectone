<div class="modal @if($modalAvance) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modalAvance) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modalAvance) aria-modal="true" @endif  @if(!$modalAvance) aria-hidden="true" @endif>
    <div class="modal-dialog modal-lg" role="document">
        <form wire:submit.prevent="registrarAsignacion('comprador')">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{$subprocesoActual->nombre}}</h5>
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
                                    <input type="text" class="form-control" wire:model='buscarComprador' placeholder="Jorge Luis...">
                                    {{-- <input type="hidden" wire:model='municipio_nacimiento_id'> --}}
                                    @error('municipio_nacimiento_id') <span class="text-danger">{{ $message }}</span>@enderror
                                    <div class="autocomplete-items-2">
                                        @foreach ($compradores as $compradorlist)
                                            <div class="abogadolist">
                                                <a wire:click="asignarComprador({{$compradorlist}})">
                                                    <div class="media">
                                                        <div class="avatar me-2">
                                                            <img alt="avatar" src="{{$compradorlist->genero == "Masculino" ? url('v3/src/assets/img/male-avatar.svg') : url('v3/src/assets/img/female-avatar.svg')}}" class="rounded-circle" />
                                                        </div>
                                                        <div class="media-body align-self-center">
                                                            <p><span class="text-primary">Nombre:</span> {{$compradorlist->nombre}} {{$compradorlist->apaterno}} {{$compradorlist->amaterno}}</p>
                                                            <p><span class="text-primary">Fecha de nacimiento:</span> {{$compradorlist->fecha_nacimiento}}</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                                @if ($comprador == "")
                                    <div class="col-lg-12 text-center">
                                        <span class="badge badge-danger" style="width: 100%">Sin comprador asignado</span>
                                    </div>
                                @else
                                    <div class="col-lg-12">
                                        <div class="form-group text-center border border-success p-3">
                                            <div class="row justify-content-lefth">
                                                <div class="col-lg-4">
                                                    <div class="avatar avatar-xl">
                                                        <img alt="avatar" src="{{$comprador['genero'] == "Masculino" ? url('v3/src/assets/img/male-avatar.svg') : url('v3/src/assets/img/female-avatar.svg')}}" class="rounded" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="row">
                                                        <div class="col-lg-12 text-start">
                                                            <span class="fw-bold">
                                                                {{$comprador['nombre']}} {{$comprador['apaterno']}} {{$comprador['amaterno']}}
                                                            </span>
                                                        </div>
                                                        <div class="col-lg-6 text-start">
                                                            <span class="fw-bold text-primary">Genero: </span>{{$comprador['genero']}}
                                                        </div>
                                                        <div class="col-lg-6 text-start">
                                                            <span class="fw-bold text-primary">Telefono: </span>{{$comprador['telefono']}}
                                                        </div>
                                                        <div class="col-lg-6 text-start">
                                                            <span class="fw-bold text-primary">Email: </span>{{$comprador['email']}}
                                                        </div>
                                                        <div class="col-lg-6 text-start">
                                                            <span class="fw-bold text-primary">Edad: </span>{{\Carbon\Carbon::parse($comprador['fecha_nacimiento'])->diff(\Carbon\Carbon::now())->format('%y')}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-3">
                                        <label for="">Acta de nacimiento</label>
                                        @if ($modalAvance)
                                            <x-file-pond wire:model="acta_nac" x-init="
                                                var Pond = FilePond.create($refs.input);
                                                this.addEventListener('pondReset', e => {
                                                    Pond.removeFiles();
                                                });">
                                            </x-file-pond>
                                        @endif
                                        @error("acta_nac") <span class="text-danger">{{$message}}</span> @enderror
                                        {{-- <input type="file" class="form-control" wire:model="acta_nac"> --}}
                                    </div>
                                    <div class="col-lg-12 mt-3">
                                        <label for="">Acta de matrimonio</label>
                                        {{-- <input type="file" class="form-control" wire:model="acta_matrimonio"> --}}
                                        @if ($modalAvance)
                                            <x-file-pond wire:model="acta_matrimonio" x-init="
                                                var Pond = FilePond.create($refs.input);
                                                this.addEventListener('pondReset', e => {
                                                    Pond.removeFiles();
                                                });">
                                            </x-file-pond>
                                        @endif
                                        @error("acta_matrimonio") <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="col-lg-12 mt-3">
                                        <label for="">CURP</label>
                                        {{-- <input type="file" class="form-control" wire:model="curp"> --}}
                                        @if ($modalAvance)
                                            <x-file-pond wire:model="curp" x-init="
                                                var Pond = FilePond.create($refs.input);
                                                this.addEventListener('pondReset', e => {
                                                    Pond.removeFiles();
                                                });">
                                            </x-file-pond>
                                        @endif
                                        @error("curp") <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="col-lg-12 mt-3">
                                        <label for="">RFC</label>
                                        {{-- <input type="file" class="form-control" wire:model="rfc"> --}}
                                        @if ($modalAvance)
                                            <x-file-pond wire:model="rfc" x-init="
                                                var Pond = FilePond.create($refs.input);
                                                this.addEventListener('pondReset', e => {
                                                    Pond.removeFiles();
                                                });">
                                            </x-file-pond>
                                        @endif
                                        @error("rfc") <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="col-lg-12 mt-3">
                                        <label for="">Identificacion oficial con fotografia</label>
                                        {{-- <input type="file" class="form-control" wire:model="identificacion_oficial"> --}}
                                        @if ($modalAvance)
                                            <x-file-pond wire:model="identificacion_oficial" x-init="
                                                var Pond = FilePond.create($refs.input);
                                                this.addEventListener('pondReset', e => {
                                                    Pond.removeFiles();
                                                });">
                                            </x-file-pond>
                                        @endif
                                        @error("identificacion_oficial") <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="col-lg-12 mt-3">
                                        <label for="">Comprobante de domicilio</label>
                                        {{-- <input type="file" class="form-control" wire:model="comprobante_domicilio"> --}}
                                        @if ($modalAvance)
                                            <x-file-pond wire:model="comprobante_domicilio" x-init="
                                                var Pond = FilePond.create($refs.input);
                                                this.addEventListener('pondReset', e => {
                                                    Pond.removeFiles();
                                                });">
                                            </x-file-pond>
                                        @endif
                                        @error("comprobante_domicilio") <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click='closeModal' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                    <button type="submit" class="btn btn-outline-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
    @if ($modalAvance)
        <script>
            FilePond.registerPlugin(
                FilePondPluginImagePreview,
                FilePondPluginImageExifOrientation,
                FilePondPluginFileValidateSize,
                //FilePondPluginImageEdit
            );

            // FilePond.create(
            //     document.querySelector('.file-upload-multiple')
            // );

        </script>
    @endif
</div>

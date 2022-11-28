<!-- Modal nuevo proyecto-->
<div class="modal @if($modalNuevoProyecto) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modalNuevoProyecto) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modalNuevoProyecto) aria-modal="true" @endif  @if(!$modalNuevoProyecto) aria-hidden="true" @endif>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo proyecto</h5>
                <button wire:click='closeModalNuevoProyecto' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                    <i class="fa-solid fa-circle-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="form-group mb-3">
                            <label for="">Servicio</label>
                            <select wire:model="servicio_id" class="form-select">
                                <option value="" selected disabled>Seleccionar servicio...</option>
                                @foreach ($servicios as $servicio)
                                    <option value="{{$servicio->id}}">{{$servicio->nombre}}</option>
                                @endforeach
                            </select>
                            @error('servicio_id') <span class="text-danger">{{ $message }}</span>@enderror
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
                <button wire:click='closeModalNuevoProyecto' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click='guardarProyecto' type="button" class="btn btn-outline-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

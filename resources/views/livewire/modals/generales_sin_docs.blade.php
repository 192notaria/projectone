<div class="modal @if($modalAvance) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modalAvance) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modalAvance) aria-modal="true" @endif  @if(!$modalAvance) aria-hidden="true" @endif>
    <div class="modal-dialog modal-lg" role="document">
        <form wire:submit.prevent="asignacionSinDocs">
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
                                                    <div class="col-lg-12 text-start mt-3">
                                                        <span class="fw-bold">GENERALES</span>
                                                    </div>
                                                    <div class="col-lg-12 text-start">
                                                        <ul>
                                                            <li><span class="fw-bold text-primary">Nombre: </span>{{$tipoGenerales->nombre}} {{$tipoGenerales->apaterno}} {{$tipoGenerales->amaterno}}</li>
                                                            <li><span class="fw-bold text-primary">Genero: </span>{{$tipoGenerales['genero']}}</li>
                                                            <li><span class="fw-bold text-primary">Telefono: </span>{{$tipoGenerales['telefono']}}</li>
                                                            <li><span class="fw-bold text-primary">Edad: </span>{{\Carbon\Carbon::parse($tipoGenerales['fecha_nacimiento'])->diff(\Carbon\Carbon::now())->format('%y')}}</li>
                                                            <li><span class="fw-bold text-primary">Email: </span>{{$tipoGenerales['email']}}</li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-12 text-start mt-3">
                                                        <span class="fw-bold">DOMICILIO</span>
                                                    </div>
                                                    <div class="col-lg-12 text-start">
                                                        <ul>
                                                            <li><span class="text-primary fw-bold">Calle: </span> {{$tipoGenerales->domicilio->calle}}</li>
                                                            <li><span class="text-primary fw-bold">Numero Exterior: </span> {{$tipoGenerales->domicilio->numero_ext}}</li>
                                                            <li><span class="text-primary fw-bold">Numero Interior: </span> {{$tipoGenerales->domicilio->numero_int == "" ? "S/N" : $tipoGenerales->domicilio->numero_int}}</li>
                                                            <li><span class="text-primary fw-bold">Colonia: </span> {{$tipoGenerales->domicilio->getColonia->nombre}}</li>
                                                            <li><span class="text-primary fw-bold">Municipio: </span> {{$tipoGenerales->domicilio->getColonia->getMunicipio->nombre}}</li>
                                                            <li><span class="text-primary fw-bold">Estado: </span> {{$tipoGenerales->domicilio->getColonia->getMunicipio->getEstado->nombre}}</li>
                                                            <li><span class="text-primary fw-bold">Pais: </span> {{$tipoGenerales->domicilio->getColonia->getMunicipio->getEstado->getPais->nombre}}</li>
                                                            <li><span class="text-primary fw-bold">Codigo Postal: </span> {{$tipoGenerales->domicilio->getColonia->codigo_postal}}</li>
                                                        </ul>
                                                    </div>
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
                    <button wire:click='closeModal' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                    @if ($tipoGenerales != "")<button type="submit" class="btn btn-outline-primary">Guardar</button>@endif
                </div>
            </div>
        </form>
    </div>
</div>

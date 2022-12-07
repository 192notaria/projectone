<!-- Modal nuevo proyecto-->
<div class="modal @if($agregarApoyoModal) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($agregarApoyoModal) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($agregarApoyoModal) aria-modal="true" @endif  @if(!$agregarApoyoModal) aria-hidden="true" @endif>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar apoyo</h5>
                <button wire:click='closeModalAgregarApoyo' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                    <i class="fa-solid fa-circle-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-lg-12 mt-4">
                        <div class="form-group mb-3 autocomplete">
                            <label for="">Asignar abogado de apoyo</label>
                            <input type="text" class="form-control" wire:model='buscarAbogado' placeholder="Jorge Luis...">
                            {{-- <input type="hidden" wire:model='municipio_nacimiento_id'> --}}
                            @error('municipio_nacimiento_id') <span class="text-danger">{{ $message }}</span>@enderror
                            <div class="autocomplete-items-2">
                                @foreach ($abogados_apoyo as $abogado)
                                    <div class="abogadolist">
                                        <a wire:click="asignarAbogadoApoyo({{$abogado->id}})">
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
                        @if ($abogadoApoyo == "")
                            <div class="form-group text-center border border-danger">
                                <p class="text-danger">No se ha asignado un abogado de apoyo para este proyecto</p>
                            </div>
                        @else
                            <div class="form-group text-center border border-success p-3">
                                <div class="row justify-content-lefth">
                                    <div class="col-lg-4">
                                        <div class="avatar avatar-xl">
                                            <img alt="avatar" src="{{url($abogadoApoyo->user_image)}}" class="rounded" />
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <span class="fw-bold">
                                                    {{$abogadoApoyo->name}} {{$abogadoApoyo->apaterno}} {{$abogadoApoyo->amaterno}}
                                                </span>
                                            </div>
                                            <div class="col-lg-6 text-start">
                                                <span class="fw-bold text-primary">Genero: </span>{{$abogadoApoyo->genero}}
                                            </div>
                                            <div class="col-lg-6 text-start">
                                                <span class="fw-bold text-primary">Telefono: </span>{{$abogadoApoyo->telefono}}
                                            </div>
                                            <div class="col-lg-6 text-start">
                                                <span class="fw-bold text-primary">Email: </span>{{$abogadoApoyo->email}}
                                            </div>
                                            <div class="col-lg-6 text-start">
                                                <span class="fw-bold text-primary">Edad: </span>{{\Carbon\Carbon::parse($abogadoApoyo->fecha_nacimiento)->diff(\Carbon\Carbon::now())->format('%y')}}
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
                <button wire:click='closeModalAgregarApoyo' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click='saveAgregarApoyo' type="button" class="btn btn-outline-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

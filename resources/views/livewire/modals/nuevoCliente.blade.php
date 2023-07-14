  <!-- Modal -->
  <div class="modal @if($modal) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modal) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modal) aria-modal="true" @endif  @if(!$modal) aria-hidden="true" @endif>
    <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo Cliente</h5>
                    <button wire:click='closeModal' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @error('existeCliente')
                            <span class="badge badge-light-danger mb-2 me-4">{{$message}}</span>
                        @enderror
                        <div class="col-lg-4">
                            <div class="form-group mb-3">
                                <label for="">Nombre</label>
                                <input type="hidden" wire:model="id_cliente" class="form-control">
                                <input wire:model="nombre" type="text" class="form-control" placeholder="Juan">
                                @error('nombre') <span class="text-danger">{{ $message }}</span>@enderror
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
                                <label for="">Estado civil</label>
                                <select wire:model="estado_civil" class="form-control">
                                    <option value="" selected disabled>Seleccionar...</option>
                                    <option value="Soltero">Soltero</option>
                                    <option value="Casado">Casado</option>
                                </select>
                                @error('estado_civil') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="">Genero</label>
                                <select wire:model="genero" class="form-control">
                                    <option value="" selected disabled>Seleccionar...</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                </select>
                                @error('genero') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3 autocomplete">
                                <label for="">Municipio de nacimiento</label>
                                <select id="select-beast" placeholder="Select a person..." autocomplete="off">
                                    <option value="">Select a person...</option>
                                    @foreach ($municipios as $municipio)
                                        <option value="{{$municipio->id}}">{{$municipio->nombre}}</option>
                                    @endforeach
                                </select>
                                <script>
                                    new TomSelect("#select-beast",{
                                        create: true,
                                        sortField: {
                                            field: "text",
                                            direction: "asc"
                                        }
                                    });
                                </script>
                                {{-- <input type="text" class="form-control" wire:model="buscarMunicipio" placeholder="Morelia, Uruapan, Zamora...">
                                <input type="hidden" wire:model='municipio_nacimiento_id'>
                                @error('municipio_nacimiento_id') <span class="text-danger">{{ $message }}</span>@enderror
                                <div class="autocomplete-items">
                                    @foreach ($municipiosData as $municipio)
                                        <div>
                                            <a wire:click='selectMunicipio({{$municipio->id}})'>
                                                <strong>{{$municipio->nombre}}, {{$municipio->getEstado->nombre}}, {{$municipio->getEstado->getPais->nombre}}</strong>
                                            </a>
                                        </div>
                                    @endforeach
                                </div> --}}
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
                                <label for="">Correo</label>
                                <input wire:model="email" type="email" class="form-control" placeholder="nombre@email.com">
                                @error('email') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="">Telefono</label>
                                <input wire:model="telefono" type="telefono" class="form-control" placeholder="4431997809">
                                @error('telefono') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="">Ocupacion</label>
                                {{-- <input wire:model="ocupacion" type="text" class="form-control" placeholder="Abogado, Medico, Ingeniero"> --}}
                                <select wire:model="ocupacion"  class="form-select">
                                    <option value="" selected disabled>Seleccionar...</option>
                                    @foreach ($ocupaciones as $ocupacion)
                                        <option value="{{$ocupacion->id}}">{{$ocupacion->nombre}}</option>
                                    @endforeach
                                </select>
                                @error('ocupacion') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click='closeModal' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                    <button wire:click='save' type="button" class="btn btn-outline-primary">Guardar</button>
                </div>
            </div>
    </div>
</div>

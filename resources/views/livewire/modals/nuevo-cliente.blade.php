<div wire:ignore.self class="modal fade new-cliente-modal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">{{$id_cliente ? "Editar Cliente" : "Nuevo Cliente"}}</h5>
                <button wire:loading.attr='disabled' wire:click='clearInputs' type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="row gx-3 gy-3">
                    @error('existeCliente')
                        <span class="badge badge-light-danger mb-2 me-4">{{$message}}</span>
                    @enderror
                    <div class="col-lg-12">
                        <label for="">Tipo de cliente</label>
                        <select class="form-select" wire:model='tipo_cliente'>
                            <option value="" selected disabled>Seleccionar...</option>
                            <option value="Persona Fisica">Persona Fisica</option>
                            <option value="Persona Moral">Persona Moral</option>
                        </select>
                    </div>
                    @if ($tipo_cliente == "Persona Fisica")
                        <div class="col-lg-6">
                            <div class="form-group ">
                                <label for="">Nombre</label>
                                <input type="hidden" wire:model="id_cliente" class="form-control">
                                <input wire:model="nombre" type="text" class="form-control was-validated" placeholder="Juan">
                                @error('nombre') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group ">
                                <label for="">Apellido Paterno</label>
                                <input wire:model="apaterno" type="text" class="form-control" placeholder="Perez">
                                @error('apaterno') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group ">
                                <label for="">Apellido Materno</label>
                                <input wire:model="amaterno" type="text" class="form-control" placeholder="Rodriguez">
                                @error('amaterno') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group ">
                                <label for="">Fecha de nacimiento</label>
                                <input wire:model="fecha_nacimiento" type="date" class="form-control">
                                @error('fecha_nacimiento') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group ">
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
                            <div class="form-group ">
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
                            <div class="form-group ">
                                <label for="">Curp</label>
                                <input wire:model='curp' type="text" class="form-control" placeholder="CURP">
                                @error('curp') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group ">
                                <label for="">Rfc</label>
                                <input wire:model='rfc' type="text" class="form-control" placeholder="RFC">
                                @error('rfc') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group ">
                                <label for="">Correo</label>
                                <input wire:model="email" type="email" class="form-control" placeholder="nombre@email.com">
                                @error('email') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group ">
                                <label for="">Télefono</label>
                                <input wire:model="telefono" type="telefono" class="form-control" placeholder="4431997809">
                                @error('telefono') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group  autocomplete" wire:ignore>
                                <label for="">Municipio de nacimiento</label>
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
                                <select id="municipio_nacimiento" placeholder="Seleccionar..." autocomplete="off" wire:model='municipio_nacimiento_id'>
                                    <option value="">Seleccionar...</option>
                                    @foreach ($municipios_data as $municipio)
                                        <option value="{{$municipio->id}}">
                                            {{$municipio->nombre}}, {{$municipio->getEstado->nombre}}, {{$municipio->getEstado->getPais->nombre}}
                                        </option>
                                    @endforeach
                                </select>
                                <script>
                                    new TomSelect("#municipio_nacimiento",{
                                        create: false,
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group " wire:ignore>
                                <label for="">Ocupacion</label>
                                <select id="ocupaciones-select" placeholder="Seleccionar..." autocomplete="off" wire:model='ocupacion'>
                                    <option value="" disabled>Seleccionar...</option>
                                    @foreach ($ocupaciones as $ocupacion)
                                        <option value="{{$ocupacion->id}}">{{$ocupacion->nombre}}</option>
                                    @endforeach
                                </select>
                                @error('ocupacion') <span class="text-danger">{{ $message }}</span>@enderror
                                <script>
                                    new TomSelect("#ocupaciones-select",{
                                        create: false,
                                    });
                                </script>
                            </div>
                        </div>
                        @error('existeCliente')
                            <span class="badge badge-light-danger mb-2 me-4">{{$message}}</span>
                        @enderror
                    @endif

                    @if ($tipo_cliente == "Persona Moral")
                        <div class="col-lg-6">
                            <div class="form-group ">
                                <label for="">Razón social</label>
                                <input wire:model="razon_social" type="text" class="form-control was-validated" placeholder="Empresa S.A. de C.V.">
                                @error('razon_social') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group ">
                                <label for="">Administrador unico / Representante Legal</label>
                                <input wire:model="admin_unico" type="text" class="form-control was-validated" placeholder="Nombre completo">
                                @error('admin_unico') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group ">
                                <label for="">Rfc</label>
                                <input wire:model='rfc' type="text" class="form-control" placeholder="RFC">
                                @error('rfc') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group ">
                                <label for="">Correo</label>
                                <input wire:model="email" type="email" class="form-control" placeholder="nombre@email.com">
                                @error('email') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group ">
                                <label for="">Telefono</label>
                                <input wire:model="telefono" type="telefono" class="form-control" placeholder="4431997809">
                                @error('telefono') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    @endif

                </div>
            </div>
            <div class="modal-footer">
                <a href="#" wire:click='clearInputs' class="text-primary mr-3" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</a>
                <button wire:loading.attr='disabled' wire:click='save' type="button" class="btn btn-success">Guardar</button>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener('open-new-cliente-modal', event => {
        $(".new-cliente-modal").modal("show")
    })

    window.addEventListener('close-new-cliente-modal', event => {
        $(".new-cliente-modal").modal("hide")
    })
</script>


@if (!$nuevoCliente)
    <div class="col-lg-12">
        <button wire:click='cambiarVistaPartes(0)' class="btn btn-danger">
            <i class="fa-solid fa-chevron-left"></i> Regresar
        </button>
        <button wire:click='registrarParte' class="btn btn-success">
            <i class="fa-solid fa-floppy-disk"></i> Guardar
        </button>
    </div>

    <div class="col-lg-12 mt-3">
        <div class="form-group autocomplete">
            <label for="">Buscar en lista de clientes</label>
            <input wire:model='buscarClienteParte' type="text" class="form-control" placeholder="Buscar...">
            <div class="autocomplete-items">
                @foreach ($cliente_partes as $cliente)
                    <a wire:click='asignarCliente({{$cliente}})'>
                        <div>
                            @if ($cliente->tipo_cliente == 'Persona Moral')
                                <strong>
                                    {{$cliente->admin_unico}} - {{$cliente->razon_social}}
                                </strong>
                            @else
                                <strong>
                                    {{$cliente->nombre}} {{$cliente->apaterno}} {{$cliente->amaterno}}
                                </strong>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <a wire:click='cambiarRegistroCliente(1)' href="#">No encuentras el cliente?... <span class="text-warning">Registralo aqui!</span></a>
    </div>
@endif

@if ($clienteParte)
    <div class="col-lg-12 table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Curp</th>
                    <th>RFC</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$clienteParte['nombre']}} {{$clienteParte['apaterno']}} {{$clienteParte['amaterno']}}</td>
                    <td>{{$clienteParte['curp']}}</td>
                    <td>{{$clienteParte['rfc']}}</td>
                    <td><button wire:click='limpiarVariablesPartes' class="btn btn-danger">Remover</button></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-lg-4 mt-3">
        <label for="">Tipo</label>
        <select wire:model='tipo_parte' class="form-select">
            <option value="" disabled selected>Seleccionar...</option>
            @if ($proyecto_activo)
                @foreach ($proyecto_activo->servicio->partes as $parte)
                    <option value="{{$parte->descripcion}}">{{$parte->descripcion}}</option>
                @endforeach
            @endif
        </select>
    </div>
    <div class="col-lg-12 mt-3">
        <div class="switch form-switch-custom switch-inline form-switch-primary">
            <input wire:model='copropietario_parte' class="switch-input" type="checkbox" role="switch" id="form-custom-switch-primary">
            <label class="switch-label" for="form-custom-switch-primary">Copropietario</label>
        </div>
    </div>
    @if ($copropietario_parte)
        <div class="col-lg-4 mt-3">
            <label for="">Porcentaje</label>
            <input wire:model='porcentaje_copropietario' type="number" class="form-control" placeholder="%">
            @error("porcentaje_copropietario")
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
    @endif
@endif

@if ($nuevoCliente)
    <div class="col-lg-12">
        <button wire:click='cambiarRegistroCliente(0)' class="btn btn-danger" wire:loading.attr='disabled'>
            <i class="fa-solid fa-chevron-left"></i> Cancelar Registro
        </button>
        <button wire:click='guardarCliente' class="btn btn-success" wire:loading.attr='disabled'>
            <i class="fa-solid fa-floppy-disk"></i> Guardar Cliente
        </button>
    </div>
    <div class="col-lg-12 mt-3">
        <div class="switch form-switch-custom switch-inline form-switch-primary">
            <input wire:model='persona_moral' class="switch-input" type="checkbox" role="switch" id="form-custom-switch-moral">
            @error("persona_moral")
                <span class="text-danger">{{$message}}</span>
            @enderror
            <label class="switch-label" for="form-custom-switch-moral">¿Es persona moral?</label>
        </div>
    </div>
    <div class="col-lg-4 mt-3">
        <label for="">{{$persona_moral ? "Razon social" : "Nombre"}}</label>
        <input wire:model='nombre_parte' type="text" class="form-control" placeholder="{{$persona_moral ? "Razon social" : "Nombre"}}">
        @error("nombre_parte")
                <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    @if (!$persona_moral)
        <div class="col-lg-4 mt-3">
            <label for="">Apellido Paterno</label>
            <input wire:model='paterno_parte' type="text" class="form-control" placeholder="Apellido paterno">
            @error("paterno_parte")
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="col-lg-4 mt-3">
            <label for="">Apellido Materno</label>
            <input wire:model='materno_parte' type="text" class="form-control" placeholder="Apellido materno">
            @error("materno_parte")
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="col-lg-4 mt-3">
            <label for="">Curp</label>
            <input wire:model='curp_parte' type="text" class="form-control" placeholder="Curp">
            @error("curp_parte")
                <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
    @endif
    <div class="col-lg-4 mt-3">
        <label for="">Rfc</label>
        <input wire:model='rfc_parte' type="text" class="form-control" placeholder="Rfc">
        @error("rfc_parte")
                <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
@endif

{{--
{{-- @if ($nuevoCliente)
    <div class="col-lg-12 mt-3">
        <div class="switch form-switch-custom switch-inline form-switch-primary">
            <input wire:model='persona_moral' class="switch-input" type="checkbox" role="switch" id="form-custom-switch-moral">
            <label class="switch-label" for="form-custom-switch-moral">¿Es persona moral?</label>
        </div>
    </div>
    <div class="col-lg-4 mt-3">
        <label for="">{{$persona_moral ? "Razon social" : "Nombre"}}</label>
        <input wire:model='nombre_parte' type="text" class="form-control" placeholder="{{$persona_moral ? "Razon social" : "Nombre"}}">
    </div>
    <div class="col-lg-4 mt-3">
        <label for="">Apellido Paterno</label>
        <input wire:model='paterno_parte' type="text" class="form-control" placeholder="Apellido paterno">
    </div>
    <div class="col-lg-4 mt-3">
        <label for="">Apellido Materno</label>
        <input wire:model='materno_parte' type="text" class="form-control" placeholder="Apellido materno">
    </div>
    <div class="col-lg-4 mt-3">
        <label for="">Curp</label>
        <input wire:model='curp_parte' type="text" class="form-control" placeholder="Curp">
    </div>
    <div class="col-lg-4 mt-3">
        <label for="">Rfc</label>
        <input wire:model='rfc_parte' type="text" class="form-control" placeholder="Rfc">
    </div>
@endif

@if (!$nuevoCliente)


    @if ($clienteParte)
    <div class="col-lg-4 mt-3">
        <button class="btn btn-info mb-2 me-4">
            <span class="btn-text-inner">
                <ul class="list-group">
                    <li class="list-group-item text-white text-start"> <span class="fw-bold">Nombre:</span> {{$clienteParte['nombre']}} {{$clienteParte['apaterno']}} {{$clienteParte['amaterno']}}</li>
                    <li class="list-group-item text-white text-start"> <span class="fw-bold">Curp:</span> {{$clienteParte['curp']}}</li>
                    <li class="list-group-item text-white text-start"> <span class="fw-bold">Rfc:</span> {{$clienteParte['rfc']}}</li>
                </ul>
            </span>
            <a wire:click='limpiarVariablesPartes'>
                <span class="badge badge-danger counter">
                    <i class="fa-solid fa-xmark"></i>
                </span>
            </a>
        </button>
    </div>
    <div class="col-lg-6"></div>
    @else
        @if (!$persona_moral)
            <div class="col-lg-4 mt-3">
                <label for="">{{$persona_moral ? "Razon social" : "Nombre"}}</label>
                <input wire:model='nombre_parte' type="text" class="form-control" placeholder="{{$persona_moral ? "Razon social" : "Nombre"}}">
            </div>
            <div class="col-lg-4 mt-3">
                <label for="">Apellido Paterno</label>
                <input wire:model='paterno_parte' type="text" class="form-control" placeholder="Apellido paterno">
            </div>
            <div class="col-lg-4 mt-3">
                <label for="">Apellido Materno</label>
                <input wire:model='materno_parte' type="text" class="form-control" placeholder="Apellido materno">
            </div>
            <div class="col-lg-4 mt-3">
                <label for="">Curp</label>
                <input wire:model='curp_parte' type="text" class="form-control" placeholder="Curp">
            </div>
        @endif
        <div class="col-lg-4 mt-3">
            <label for="">Rfc</label>
            <input wire:model='rfc_parte' type="text" class="form-control" placeholder="Rfc">
        </div>
    @endif

    <div class="col-lg-4 mt-3">
        <label for="">Tipo</label>
        <select wire:model='tipo_parte' class="form-select">
            <option value="" disabled selected>Seleccionar...</option>
            @if ($proyecto_activo)
                @foreach ($proyecto_activo->servicio->partes as $parte)
                    <option value="{{$parte->descripcion}}">{{$parte->descripcion}}</option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="col-lg-12 mt-3">
        <div class="switch form-switch-custom switch-inline form-switch-primary">
            <input wire:model='copropietario_parte' class="switch-input" type="checkbox" role="switch" id="form-custom-switch-primary">
            <label class="switch-label" for="form-custom-switch-primary">Copropietario</label>
        </div>
    </div>
    @if ($copropietario_parte)
        <div class="col-lg-4 mt-3">
            <label for="">Porcentaje</label>
            <input wire:model='porcentaje_copropietario' type="number" class="form-control" placeholder="%">
        </div>
@endif
@endif --}}


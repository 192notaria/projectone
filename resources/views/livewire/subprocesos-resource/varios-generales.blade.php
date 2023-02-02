<div class="card">
    <div class="card-header">
        <h3>{{$sub->catalogosSubprocesos->nombre}}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="">{{$sub->id}}</label>
                    <input wire:model='buscar_cliente.{{$sub->id}}' wire:keyup='obtenerClientes({{$sub->id}})' wire:key='{{$sub->id}}' type="text" class="form-control" placeholder="Buscar en lista de clientes...">
                    <div class="autocomplete-items">
                        @if (isset($clientes['data']))
                            @if ($clientes['input'] == $sub->id)
                                @foreach ($clientes['data'] as $cliente)
                                    <div>
                                        <a>
                                            <strong>
                                                @if (isset($cliente->nombre))
                                                    {{$cliente->nombre}}, {{$cliente->apaterno}}, {{$cliente->amaterno}}
                                                @endif
                                            </strong>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

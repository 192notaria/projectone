<div class="card">
    <div class="card-header">
        <h3>{{$sub->catalogosSubprocesos->nombre}}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="">{{$sub->id}}</label>
                    <input wire:model='buscar_cliente.{{$sub->id}}' :key='{{$sub->id}}' type="text" class="form-control" placeholder="Buscar en lista de clientes...">
                    <div class="autocomplete-items">
                        @foreach ($buscar_cliente as $key => $buscar)
                            @if ($key == $sub->id)
                                 @foreach ($clientes as $cliente)
                                    <div>
                                        <a>
                                            <strong>{{$cliente->nombre}}, {{$cliente->apaterno}}, {{$cliente->amaterno}}</strong>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

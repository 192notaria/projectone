<div class="card">
    <div class="card-header">
        <h3>{{$sub->catalogosSubprocesos->nombre}}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Buscar en lista de clientes...">
                    <div class="autocomplete-items">
                        @foreach ($municipiosData as $municipio)
                            <div>
                                <a wire:click='selectMunicipio({{$municipio->id}})'>
                                    <strong>{{$municipio->nombre}}, {{$municipio->getEstado->nombre}}, {{$municipio->getEstado->getPais->nombre}}</strong>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

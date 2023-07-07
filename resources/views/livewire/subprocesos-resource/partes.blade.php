<div class="row gx-4 gy-4">
    @if ($vistaPartes == 1)
        @include('livewire.forms.agregar-partes')
    @endif

    @if ($vistaPartes == 0)
        <div class="col-lg-12 mb-2">
            <button wire:click='cambiarVistaPartes(1)' class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Agregar partes
            </button>
        </div>
        <div class="col-lg-12 mb-2 mt-2">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Parte</th>
                                <th>Tipo de persona</th>
                                <th>Tipo de parte</th>
                                <th>Curp y Rfc</th>
                                <th>Copropietario</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($proyecto_activo)
                                @forelse ($proyecto_activo->partes as $parte)
                                    <tr>
                                        <td>
                                            @if ($parte->cliente->tipo_cliente == 'Persona Moral')
                                                {{$parte->cliente->razon_social}}
                                            @else
                                                {{$parte->cliente->nombre}} {{$parte->cliente->apaterno}} {{$parte->cliente->amaterno}}
                                            @endif
                                        </td>
                                        <td>{{$parte->tipo_persona}}</td>
                                        <td>{{$parte->tipo}}</td>
                                        <td>
                                            <p>{{$parte->curp}}</p>
                                            <p>{{$parte->rfc}}</p>
                                        </td>
                                        <td>{{$parte->porcentaje != 0 ?  $parte->porcentaje . "%" : "N/A"}}</td>
                                        <td>
                                            <button wire:click='removerParte({{$parte->id}})' class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="6">Sin registros...</td>
                                    </tr>
                                @endforelse

                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

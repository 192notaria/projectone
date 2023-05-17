<div class="row gx-4 gy-4">
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
                        @if ($escritura_activa)
                            @forelse ($escritura_activa->partes as $parte)
                                <tr>
                                    <td>{{$parte->nombre}} {{$parte->apaterno}} {{$parte->amaterno}}</td>
                                    <td>{{$parte->tipo_persona}}</td>
                                    <td>{{$parte->tipo}}</td>
                                    <td>
                                        <p>{{$parte->curp}}</p>
                                        <p>{{$parte->rfc}}</p>
                                    </td>
                                    <td>{{$parte->porcentaje != 0 ?  $parte->porcentaje . "%" : "N/A"}}</td>
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
</div>

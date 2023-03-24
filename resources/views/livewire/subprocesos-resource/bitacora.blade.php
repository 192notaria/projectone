<div class="row">
    <div class="col-lg-12 mb-2 mt-2">
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Proceso</th>
                            <th>Registro</th>
                            <th>Abogado del proyecto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($proyecto_activo)
                            @forelse ($proyecto_activo->bitacora as $bitacora)
                                <tr>
                                    <td>{{$bitacora->created_at}}</td>
                                    <td>{{$bitacora->proceso->nombre}}</td>
                                    <td>{{$bitacora->subproceso->nombre}}</td>
                                    <td>{{$bitacora->proyecto->abogado->name}} {{$bitacora->proyecto->abogado->apaterno}} {{$bitacora->proyecto->abogado->amaterno}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Sin registros...</td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

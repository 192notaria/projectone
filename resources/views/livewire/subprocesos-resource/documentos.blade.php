<div class="row">
    <div class="col-lg-12 table-responsive">
        <table class="table table-responsive table-stripped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo de documento</th>
                    <th>Fecha de creacion</th>
                </tr>
            </thead>
            <tbody>
                @if ($proyecto_activo)
                    @forelse ($proyecto_activo->documentos as $document_data)
                        <tr>
                            <td>
                                <a target="_blank" href="{{$document_data->storage}}">
                                    {{$document_data->nombre}}
                                </a>
                            </td>
                            <td>{{$document_data->tipoDoc->nombre}}</td>
                            <td>{{$document_data->created_at}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Sin registros</td>
                        </tr>
                    @endforelse
                @endif
            </tbody>
        </table>
    </div>

</div>

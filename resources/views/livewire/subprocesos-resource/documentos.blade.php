<div class="row gx-4 gy-4">
    <div class="col-lg-12">
        <button wire:click='abrir_agregar_documentos' class="btn btn-primary">Agregar documentos</button>
    </div>
    <div class="col-lg-12 table-responsive card">
       <div class="card-body">
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
                                    <a target="_blank" href="/{{$document_data->storage}}">
                                        {{$document_data->nombre}}
                                    </a>
                                </td>
                                <td>{{$document_data->tipoDoc->nombre ?? ""}}</td>
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
    <div class="col-lg-12 mt-4 card">
        <div class="card-header">
            <h5>Crear recibo de entrega</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-check form-check-primary form-check-inline">
                        <input class="form-check-input" type="checkbox" value="" id="form-check-primary" wire:model='check_cliente'>
                        <label class="form-check-label" for="form-check-primary">
                            ¿Recibe el cliente registrado?
                        </label>
                    </div>
                </div>
                @if (!$check_cliente)
                    <div class="col-lg-12 mt-2">
                        <label for="">Nombre de la persona que recibe</label>
                        <input type="text" class="form-control" placeholder="Nombre y Apellidos" wire:model='nombre_quien_recibe'>
                        @error('nombre_quien_recibe')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                @endif
                <div class="col-lg-12 mt-2">
                    <button class="btn btn-primary" wire:click='crear_recibo_entrega'>Descagar recibo</button>
                </div>
            </div>
        </div>
    </div>
</div>

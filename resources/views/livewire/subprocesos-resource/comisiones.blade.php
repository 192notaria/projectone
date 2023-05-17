<div class="row">
    @if ($vistaComisiones == 1)
        @include('livewire.forms.agregar-comision')
    @endif

    @if ($vistaComisiones == 2)
        @include('livewire.forms.agregar-promotor')
    @endif

    @if ($vistaComisiones == 0)
        <div class="col-lg-12 mb-3">
            <button wire:click='cambiarVistaComision(1)' class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Agregar comisión
            </button>
        </div>
        <div class="col-lg-12 mb-2 mt-2">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Promotor</th>
                                <th>Comisión</th>
                                <th>Observaciones</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($proyecto_activo)
                                @forelse ($proyecto_activo->comisiones as $comision)
                                    <tr>
                                        <td>
                                            {{$comision->promotor->nombre}}
                                            {{$comision->promotor->apaterno}}
                                            {{$comision->promotor->amaterno}}
                                        </td>
                                        <td>{{number_format($comision->cantidad, 2)}}</td>
                                        <td>{{$comision->observaciones}}</td>
                                        <td>
                                            <button wire:click='editarComision(1)' class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                            <button class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="4">Sin registros...</td>
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

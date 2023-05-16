<div class="card">

    <style>
        .modal{
            backdrop-filter: blur(5px);
            background-color: #01223770;
            -webkit-animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        @keyframes fadeOut {
            0% { opacity: 1; }
            100% { opacity: 0; }
        }
    </style>

    <div class="card-header">
        <div class="d-flex justify-content-between">
            <select class="form-select" style="width: 8%;" wire:model='cantidadEscrituras'>
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
            <input type="text" class="form-control me-2" placeholder="Buscar..." style="width: 30%;">
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Cliente</th>
                            <th scope="col">Volumen</th>
                            <th scope="col">Acto</th>
                            <th scope="col">Abogado</th>
                            <th scope="col">Fecha de creación</th>
                            <th scope="col"></th>
                        </tr>
                        <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                    </thead>
                    <tbody>
                        @foreach ($escrituras as $escritura)
                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="avatar avatar-sm me-2">
                                            <span class="avatar-title badge bg-{{$escritura->servicio->tipo_acto->color}} rounded-circle">{{$escritura->numero_escritura}}</span>
                                        </div>
                                        <div class="media-body align-self-center">
                                            <h6 class="mb-0 fw-bold">{{$escritura->cliente->nombre}} {{$escritura->cliente->apaterno}} {{$escritura->cliente->amaterno}}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    {{$escritura->volumen}}
                                </td>
                                <td>
                                    {{strtoupper($escritura->servicio->nombre)}}
                                </td>
                                <td>
                                    <div class="media">
                                        <div class="avatar me-2">
                                            <img alt="avatar" src="{{url($escritura->abogado->user_image ?? 'v3/src/assets/img/male-avatar.svg')}}" class="rounded-circle" />
                                        </div>
                                        <div class="media-body align-self-center">
                                            <h6 class="mb-0 fw-bold">{{$escritura->abogado->name}} {{$escritura->abogado->apaterno}}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{$escritura->created_at}}
                                </td>
                                <td class="text-center">
                                    <div class="action-btns">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            @can('editar-proyectos')
                                                <button wire:click='abrir_escritura({{$escritura->id}})' type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target=".modal-procesos-escritura">
                                                    <i class="fa-solid fa-magnifying-glass"></i>
                                                </button>
                                            @endcan
                                            @can('borrar-proyectos')
                                                <button data-bs-toggle="modal" data-bs-target=".modal-cancelar-proyecto" type="button" class="btn btn-outline-danger">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$escrituras->links('pagination-links')}}
            </div>
        </div>
    </div>
    @include("livewire.escritura_resources.escritura-detalles")
    @include("livewire.escritura_resources.preview_escritura_modal")
</div>

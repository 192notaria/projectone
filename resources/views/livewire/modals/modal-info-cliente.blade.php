<div wire:ignore.self class="modal fade modal-info-cliente"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cliente</h5>
                <button class="btn btn-outline-danger" style="cursor: pointer" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <a class="card style-7" href="https://themeforest.net/item/cork-responsive-admin-dashboard-template/25582188" target="_blank">
                            <img src="{{url("assets/img/img-8.jpg")}}" style="max-height: 200px;" class="card-img-top" alt="...">
                            <div class="card-footer">
                                @if ($cliente_activo)
                                    <h5 class="card-title mb-0">{{$cliente_activo->nombre}} {{$cliente_activo->apaterno}} {{$cliente_activo->amaterno}}</h5>
                                    <p class="card-text">Télefono: {{$cliente_activo->telefono}}</p>
                                    <p class="card-text">Email: {{$cliente_activo->email}}</p>
                                @endif
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>Documentos</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <style>
                                    .text-overflow{
                                        white-space: nowrap;
                                        overflow: hidden;
                                        text-overflow: ellipsis;
                                        width: 100px !important;
                                    }
                                </style>
                                @if ($cliente_activo)
                                    @forelse ($cliente_activo->documentos as $key => $docs)
                                        <tr>
                                            <td>
                                                <h5 class="card-title">{{$docs->tipo_doc_data->nombre}}</h5>
                                                <p class="mb-0">{{$docs->tipo}}</p>
                                            </td>
                                            <td>
                                                <a href="{{url($docs->path)}}"  target="_blank" class="btn btn-outline-dark">
                                                    <i class="fa-solid fa-file"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Sin registros...</td>
                                        </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <a href="#" wire:click='clearInputs' class="text-primary mr-3" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cerrar</a>
            </div> --}}
        </div>
    </div>
</div>
<script>
    window.addEventListener('open-modal-info-cliente', event => {
        $(".modal-info-cliente").modal("show")
    })

    window.addEventListener('close-modal-info-cliente', event => {
        $(".modal-info-cliente").modal("hide")
    })
</script>

<div class="middle-content container-xxl p-0">
    @include('livewire.resource.modal-guardias')
    <div wire:ignore class="row layout-top-spacing layout-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="calendar-container">
                @can('crear-guardia')
                    <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target=".modal-guardias">Generar guardia</button>
                @endcan
                <div class="calendar"></div>
            </div>
        </div>
    </div>

    @if ($calendario)
        <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Solicitud de cambio de guardia</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($nombre_usuario_guardia)
                            <span class="text-warning" id="event-title">
                                ¿{{$mensaje}} <span class="fw-bold">{{$nombre_usuario_guardia}}</span>?
                            </span>
                        @else
                            <span class="text-success" id="event-title">
                                {{$mensaje}}
                            </span>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-success btn-update-event" data-fc-event-public-id="">Update changes</button>
                        @if ($nombre_usuario_guardia)
                            <button type="button" class="btn btn-primary" wire:click='cambiodeguardia'>Aceptar</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    @include("livewire.guardias-resources.modal-new-guardia")
</div>

<div class="middle-content container-xxl p-0">
    @include('livewire.resource.modal-guardias')
    <div wire:ignore class="row layout-top-spacing layout-spacing" id="cancel-row">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="calendar-container">
                @can('crear-guardi')
                    <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target=".modal-guardias">Generar guardia</button>
                @endcan

                <div class="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Modal -->
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
                    {{-- <div class="row">
                        <div class="col-md-12">
                            <div class="">
                                <label class="form-label">Enter Title</label>
                                <input id="event-title" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12 d-none">
                            <div class="">
                                <label class="form-label">Enter Start Date</label>
                                <input id="event-start-date" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12 d-none">
                            <div class="">
                                <label class="form-label">Enter End Date</label>
                                <input id="event-end-date" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="d-flex mt-4">
                                <div class="n-chk">
                                    <div class="form-check form-check-primary form-check-inline">
                                        <input class="form-check-input" type="radio" name="event-level" value="Work" id="rwork">
                                        <label class="form-check-label" for="rwork">Work</label>
                                    </div>
                                </div>
                                <div class="n-chk">
                                    <div class="form-check form-check-warning form-check-inline">
                                        <input class="form-check-input" type="radio" name="event-level" value="ChangeGuard" id="rtravel">
                                        <label class="form-check-label" for="rtravel">Travel</label>
                                    </div>
                                </div>
                                <div class="n-chk">
                                    <div class="form-check form-check-success form-check-inline">
                                        <input class="form-check-input" type="radio" name="event-level" value="Personal" id="rPersonal">
                                        <label class="form-check-label" for="rPersonal">Personal</label>
                                    </div>
                                </div>
                                <div class="n-chk">
                                    <div class="form-check form-check-danger form-check-inline">
                                        <input class="form-check-input" type="radio" name="event-level" value="Important" id="rImportant">
                                        <label class="form-check-label" for="rImportant">Important</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> --}}
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

</div>

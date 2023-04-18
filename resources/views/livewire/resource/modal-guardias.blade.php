<div wire:ignore.self class="modal fade modal-guardias"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button wire:click='generarGuardia' class="btn btn-primary mb-2" wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        Crear guardia
                    </span>
                    <span wire:loading>
                        Creando guardia, porfavor espere...
                    </span>
                </button>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 mb-2 mt-2">
                        <label for="">Mes de guardia</label>
                        <input type="month" class="form-control" wire:model='mes_elejido'>
                        @error($mes_elejido)
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-lg-6 table-responsive">
                        <h3>Guardia semanal</h3>
                        <table class="table table-responsive table-striped">
                            <thead>
                                <tr class="mb-2">
                                    <th>Equipo</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($guardia_semanal as $key => $guardia)
                                    @if (Carbon\Carbon::create($guardia['fecha'])->isoFormat('dddd') != 'sábado')
                                        <tr>
                                            <td><span class="badge badge-primary">{{$guardia['team']}}</span></td>
                                            <td>
                                                <p class="mb-0 fw-bold">{{$guardia['guardia1']['nombre']}}</p>
                                                <p class="mb-0 fw-bold">{{$guardia['guardia2']['nombre']}}</p>
                                                {{-- <p class="mb-0 fw-bold">{{$guardia['guardia3']['nombre']}}</p> --}}
                                            </td>
                                            <td>{{$guardia['dia']}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6 table-responsive">
                        <h3>Guardia fin de semana</h3>
                        <table class="table table-responsive table-striped">
                            <thead>
                                <tr>
                                    <th>Equipo</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($guardia_semanal as $key => $guardia)
                                    @if (Carbon\Carbon::create($guardia['fecha'])->isoFormat('dddd') == 'sábado')
                                        <tr>
                                            <td><span class="badge badge-primary">{{$guardia['team']}}</span></td>
                                            <td>
                                                <p class="mb-0 fw-bold">{{$guardia['guardia1']['nombre']}}</p>
                                                <p class="mb-0 fw-bold">{{$guardia['guardia2']['nombre']}}</p>
                                            </td>
                                            <td>{{$guardia['dia']}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='guardarGuardia' class="btn btn-success"><i class="flaticon-cancel-12"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-guardias', event => {
        $(".modal-guardias").modal("show")
    })

    window.addEventListener('cerrar-modal-guardias', event => {
        $(".modal-guardias").modal("hide")
        var myAudio= document.createElement('audio')
        myAudio.src = "{{ url("/v3/src/assets/audio/notification.mp3") }}"
        myAudio.play()

        Snackbar.show({
            text: event.detail,
            actionTextColor: '#fff',
            backgroundColor: '#00ab55',
            pos: 'top-center',
            duration: 5000,
            actionText: '<i class="fa-solid fa-circle-xmark"></i>'
        })
    })

    window.addEventListener('existe-guardia', event => {
        var myAudio= document.createElement('audio')
        myAudio.src = "{{ url("/v3/src/assets/audio/notification.mp3") }}"
        myAudio.play()

        Snackbar.show({
            text: event.detail,
            actionTextColor: '#fff',
            backgroundColor: '#00ab55',
            pos: 'top-center',
            duration: 5000,
            actionText: '<i class="fa-solid fa-circle-xmark"></i>'
        })
    })
</script>

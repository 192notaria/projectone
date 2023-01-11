<div wire:ignore.self class="modal fade modal-registrar-informacion-viaje"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">{{$tituloModal}}</h5>
                <button wire:click='closeModal' type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="">Pais de procedencia</label>
                            <select class="form-select" wire:model='pais_procedencia'>
                                <option value="" selected disabled>Seleccionar...</option>
                                @foreach ($paises as $pais)
                                    <option value="{{$pais->id}}">{{$pais->nombre}}</option>
                                @endforeach
                            </select>
                            @error('pais_procedencia') <span class="mt-3 badge badge-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="">Pais de destino</label>
                            <select class="form-select" wire:model='pais_destino'>
                                <option value="" selected disabled>Seleccionar...</option>
                                @foreach ($paises as $pais)
                                    <option value="{{$pais->id}}">{{$pais->nombre}}</option>
                                @endforeach
                            </select>
                            @error('pais_destino') <span class="mt-3 badge badge-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="">Aereolinea</label>
                            <input type="text" class="form-control" wire:model='aereolinea'>
                            @error('aereolinea') <span class="mt-3 badge badge-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="">Numero de vuelo</label>
                            <input type="text" class="form-control" wire:model='numero_vuelo'>
                            @error('numero_vuelo') <span class="mt-3 badge badge-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="">Via terreste (Nombre de garita)</label>
                            <input type="text" class="form-control" wire:model='nombre_garita'>
                            @error('nombre_garita') <span class="mt-3 badge badge-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="">Tiempo en el extranjero (En dias)</label>
                            <input type="number" class="form-control" wire:model='tiempo_extranjero'>
                            @error('tiempo_extranjero') <span class="mt-3 badge badge-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="">Domicilio de destino</label>
                            <textarea class="form-control" cols="30" rows="4" wire:model='domicilio_destino'></textarea>
                            @error('domicilio_destino') <span class="mt-3 badge badge-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="">Personas con las que viaja</label>
                            <textarea class="form-control" cols="30" rows="4" wire:model='personas_viaje'></textarea>
                            @error('personas_viaje') <span class="mt-3 badge badge-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='closeModal' class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click='registrarinformacionmenor' type="button" class="btn btn-outline-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-registrar-informacion-viaje', event => {
        $(".modal-registrar-informacion-viaje").modal("show")
    })

    window.addEventListener('cerrar-modal-registrar-informacion-viaje', event => {
        $(".modal-registrar-informacion-viaje").modal("hide")

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

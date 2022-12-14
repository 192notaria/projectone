<div wire:ignore.self class="modal fade modal-recibo-pago"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">{{$tituloModal}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Gasto del recibo</label>
                                <input wire:model='gasto_de_recibo' wire:change='gastoRecibo' type="number" class="form-control" placeholder="0.0">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Gastos de gestoria</label>
                                <input wire:model='gasto_de_gestoria' wire:change='gastoRecibo' type="number" class="form-control" placeholder="0.0">
                            </div>
                        </div>

                        <div class="col-lg-6 mt-2">
                            <div class="form-group">
                                <label for="">Total: <span class="text-primary">${{$totalRecbio}}</span></label>
                            </div>
                        </div>

                        <div class="col-lg-12 mt-3">
                            <div class="form-group">
                                <label for="">Recibo de pago</label>
                                <x-file-pond wire:model="recibo_de_pago"
                                    :options="['labelIdle' => 'Cargar un archivo... o arrastra y suelta']">
                                </x-file-pond>
                                @error('recibo_de_pago') <span class="text-danger">{{$message}}</span> @enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click='registrarReciboPago' type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-recibo-pago', event => {
        $(".modal-recibo-pago").modal("show")
    })
    window.addEventListener('cerrar-modal-recibo-pago', event => {
        $(".modal-recibo-pago").modal("hide")

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

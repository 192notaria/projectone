<div wire:ignore.self class="modal fade modal-guardias"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button wire:click='generarGuardia' class="btn btn-primary mb-2">Generar guardia</button>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach ($guardia_semanal as $key => $guardia)
                        <div class="col-lg-2 mb-5" wire:key='{{$key}}'>
                            <span class="badge badge-primary mb-2">{{$guardia['fecha']}}</span>
                            <p><span class="badge badge-info">{{$guardia['dia']}}</span></p>
                            <p>{{$guardia['usuarios']['primero']['nombre']}}</p>
                            <p>{{$guardia['usuarios']['segundo']['nombre']}}</p>
                        </div>
                    @endforeach
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
    })
</script>

<div wire:ignore.self class="modal fade modal-ver-recibo-pago"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">{{$tituloModal}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <span class="text-primary">Gasto del recibo</span> {{$gasto_de_recibo}}
                                    </div>
                                    <div class="col-lg-12">
                                        <span class="text-primary">Gastos de gestoria</span> {{$gasto_de_gestoria}}
                                    </div>
                                    <div class="col-lg-12">
                                        <span class="text-primary">Total</span> {{$totalRecbio}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($recibo_de_pago != "")
                        <div class="col-lg-12 mt-3">
                            <embed src="{{url($recibo_de_pago)}}" style="width: 100%; height: 400px;" type="application/pdf">
                        </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-ver-recibo-pago', event => {
        $(".modal-ver-recibo-pago").modal("show")
    })
</script>

<div wire:ignore.self class="modal fade modal-vista-varios-generales"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">{{$tituloModal}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <div id="toggleAccordion" class="accordion">
                    @foreach ($varios_generales_data as $generales)
                        <div class="card">
                            <div class="card-header" id="generales{{$generales->id}}">
                                <section class="mb-0 mt-0">
                                    <div role="menu" class="collapsed" data-bs-toggle="collapse" data-bs-target="#defaultAccordionOne{{$generales->id}}" aria-expanded="false" aria-controls="defaultAccordionOne">
                                        {{$generales->cliente->nombre}} {{$generales->cliente->apaterno}} {{$generales->cliente->amaterno}}
                                        <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                                    </div>
                                </section>
                            </div>
                            <div id="defaultAccordionOne{{$generales->id}}" class="collapse" aria-labelledby="generales{{$generales->id}}" data-bs-parent="#toggleAccordion" style="">
                                <div class="card-body">
                                    <div class="row">
                                        @if ($generales->acta_nacmiento)
                                            <div class="col-lg-12 mt-3">
                                                <label for="">Acta de nacimiento</label>
                                                <embed src="{{url('/storage/' . $generales->acta_nacmiento)}}" style="width: 100%; height: 400px;" type="application/pdf">
                                            </div>
                                        @endif

                                        @if ($generales->acta_matrimonio)
                                            <div class="col-lg-12 mt-3">
                                                <label for="">Acta de matrimonio</label>
                                                <embed src="{{url('/storage/' . $generales->acta_matrimonio)}}" style="width: 100%; height: 400px;" type="application/pdf">
                                            </div>
                                        @endif

                                        @if ($generales->curp)
                                            <div class="col-lg-12 mt-3">
                                                <label for="">CURP</label>
                                                <embed src="{{url('/storage/' . $generales->curp)}}" style="width: 100%; height: 400px;" type="application/pdf">
                                            </div>
                                        @endif

                                        @if ($generales->rfc)
                                            <div class="col-lg-12 mt-3">
                                                <label for="">RFC</label>
                                                <embed src="{{url('/storage/' . $generales->rfc)}}" style="width: 100%; height: 400px;" type="application/pdf">
                                            </div>
                                        @endif

                                        @if ($generales->identificacion_oficial_con_foto)
                                            <div class="col-lg-12 mt-3">
                                                <label for="">Identificacion oficial con fotografia</label>
                                                <embed src="{{url('/storage/' . $generales->identificacion_oficial_con_foto)}}" style="width: 100%; height: 400px;" type="application/pdf">
                                            </div>
                                        @endif

                                        @if ($generales->comprobante_domicilio)
                                            <div class="col-lg-12 mt-3">
                                                <label for="">Comprobante de domicilio</label>
                                                <embed src="{{url('/storage/' . $generales->comprobante_domicilio)}}" style="width: 100%; height: 400px;" type="application/pdf">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-vista-varios-generales', event => {
        $(".modal-vista-varios-generales").modal("show")
    })
</script>

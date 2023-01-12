<div wire:ignore.self class="modal fade modal-vista-previa"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">{{$tituloModal}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                @if ($generales_data != "")
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <b class="text-primary fw-bold">{{$generales_data->cliente->nombre}} {{$generales_data->cliente->apaterno}} {{$generales_data->cliente->amaterno}}</b>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <li><span class="text-primary">Lugar de nacimiento: </span> {{$generales_data->cliente->getMunicipio->nombre}}, {{$generales_data->cliente->getMunicipio->getEstado->nombre}}, {{$generales_data->cliente->getMunicipio->getEstado->getPais->nombre}}</li>
                                        </div>
                                        <div class="col-lg-3">
                                            <li><span class="text-primary">CURP: </span> {{$generales_data->cliente->curp}}</li>
                                        </div>
                                        <div class="col-lg-3">
                                            <li><span class="text-primary">RFC: </span> {{$generales_data->cliente->rfc}}</li>
                                        </div>
                                        <div class="col-lg-3">
                                            <li><span class="text-primary">Fecha de nacimiento: </span> {{$generales_data->cliente->fecha_nacimiento}}</li>
                                        </div>
                                        <div class="col-lg-3">
                                            <li><span class="text-primary">Email: </span> {{$generales_data->cliente->email}}</li>
                                        </div>
                                        <div class="col-lg-3">
                                            <li><span class="text-primary">Telefono: </span> {{$generales_data->cliente->telefono}}</li>
                                        </div>
                                        <div class="col-lg-3">
                                            <li><span class="text-primary">Ocupacion: </span> {{$generales_data->cliente->getOcupacion->nombre}}</li>
                                        </div>
                                        <div class="col-lg-3">
                                            <li><span class="text-primary">Estado civil: </span> {{$generales_data->cliente->estado_civil}}</li>
                                        </div>
                                        <div class="col-lg-3">
                                            <li><span class="text-primary">Genero: </span> {{$generales_data->cliente->genero}}</li>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($generales_data->acta_nacmiento)
                            <div class="col-lg-12 mt-3">
                                <label for="">Acta de nacimiento</label>
                                <embed src="{{url('/storage/' . $generales_data->acta_nacmiento)}}" style="width: 100%; height: 400px;" type="application/pdf">
                            </div>
                        @endif

                        @if ($generales_data->acta_matrimonio)
                            <div class="col-lg-12 mt-3">
                                <label for="">Acta de matrimonio</label>
                                <embed src="{{url('/storage/' . $generales_data->acta_matrimonio)}}" style="width: 100%; height: 400px;" type="application/pdf">
                            </div>
                        @endif

                        @if ($generales_data->curp)
                            <div class="col-lg-12 mt-3">
                                <label for="">CURP</label>
                                <embed src="{{url('/storage/' . $generales_data->curp)}}" style="width: 100%; height: 400px;" type="application/pdf">
                            </div>
                        @endif

                        @if ($generales_data->rfc)
                            <div class="col-lg-12 mt-3">
                                <label for="">RFC</label>
                                <embed src="{{url('/storage/' . $generales_data->rfc)}}" style="width: 100%; height: 400px;" type="application/pdf">
                            </div>
                        @endif

                        @if ($generales_data->identificacion_oficial_con_foto)
                            <div class="col-lg-12 mt-3">
                                <label for="">Identificacion oficial con fotografia</label>
                                <embed src="{{url('/storage/' . $generales_data->identificacion_oficial_con_foto)}}" style="width: 100%; height: 400px;" type="application/pdf">
                            </div>
                        @endif

                        @if ($generales_data->comprobante_domicilio)
                            <div class="col-lg-12 mt-3">
                                <label for="">Comprobante de domicilio</label>
                                <embed src="{{url('/storage/' . $generales_data->comprobante_domicilio)}}" style="width: 100%; height: 400px;" type="application/pdf">
                            </div>
                        @endif
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button class="btn" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-vista_previa', event => {
        $(".modal-vista-previa").modal("show")
    })
</script>

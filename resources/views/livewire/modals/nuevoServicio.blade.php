
    <div class="modal @if($modalNuevo) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modalNuevo) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modalNuevo) aria-modal="true" @endif  @if(!$modalNuevo) aria-hidden="true" @endif>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{$modalTittle}}</h5>
                    <button wire:click='closeModalNew' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 mt-2 mb-2">
                            <div class="form-group">
                                <label for="">Nombre del servicio</label>
                                <input wire:model='nombre_del_servicio' type="text" class="form-control" placeholder="Compraventas, Divorcios...">
                                @error('nombre_del_servicio') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2 mb-2">
                            <div class="form-group">
                                <label for="">Minutos para firma de escritura</label>
                                <input wire:model='tiempo_firma' type="number" class="form-control" placeholder="Compraventas, Divorcios...">
                                @error('tiempo_firma') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6 mt-2 mb-2">
                            <label for="">Honorarios</label>
                            <input type="text" class="form-control" placeholder="0.0" wire:model='honorarios'>
                        </div>
                        <div class="col-lg-12 mt-2 mb-2 table-responsive">
                            <label for="">Conceptos de Pago</label>
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>Requerido</th>
                                        <th>Descripcion</th>
                                        <th>Precio sugerido</th>
                                        <th>Impuestos</th>
                                        <th>Tipo de impuesto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($conceptos_pagos as $key => $concepto)
                                        <tr>
                                            <td class="text-center">
                                                <div class="switch form-switch-custom switch-inline form-switch-primary">
                                                    <input class="switch-input" type="checkbox" role="switch" aria-controls="profile-tab-pane" aria-selected="false" id="form-custom-switch-default{{$key}}" wire:model='conceptos_pago.{{$concepto->id}}'>
                                                </div>
                                                {{-- <input class="form-check-input" type="checkbox" id="form-check-default{{$key}}" wire:model='conceptos_pago.{{$concepto->id}}'> --}}
                                            </td>
                                            <td>
                                                <p>
                                                    <span class="badge badge-primary">
                                                        {{$concepto->descripcion}}
                                                    </span>
                                                </p>
                                                {{$concepto->categoria->nombre}}
                                            </td>
                                            <td><span class="badge badge-success">${{number_format($concepto->precio_sugerido,2)}}</span></td>
                                            <td><span class="badge badge-danger">{{$concepto->impuestos}}%</span></td>
                                            <td>{{$concepto->impuesto->nombre}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click='closeModalNew' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                    <button wire:click='save' type="button" class="btn btn-outline-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

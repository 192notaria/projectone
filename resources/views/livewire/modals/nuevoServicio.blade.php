
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
                                        @if ($concepto->descripcion != "Honorarios")
                                            <tr>
                                                <td class="text-center">
                                                    <div class="switch form-switch-custom switch-inline form-switch-primary">
                                                        <input class="switch-input" type="checkbox" role="switch" aria-controls="profile-tab-pane" aria-selected="false" id="form-custom-switch-default{{$key}}" wire:model='conceptos_pago.{{$concepto->id}}'>
                                                    </div>
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
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 mt-4">
                            <h4>Partes</h4>
                        </div>
                        <div class="col-lg-12 mt-2">
                            <div class="d-flex justify-content-between">
                                <input wire:model='descripcion_parte' type="text" class="form-control me-2" placeholder="Ejem: VENDEDOR">
                                <button wire:click='asignarParte' class="btn btn-primary"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                        @error('descripcion_parte')
                            <div class="col-lg-12">
                                <span class="text-danger">{{$message}}</span>
                            </div>
                        @enderror
                        <div class="col-lg-12 mt-2 table-responsive">
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>Descripcón</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($partes_array as $key => $parte)
                                        <tr>
                                            <td>{{$parte['descripcion']}}</td>
                                            <td class="text-end">
                                                <button wire:click='removerParte({{$key}})' class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Sin partes asignadas</td>
                                        </tr>
                                    @endforelse
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

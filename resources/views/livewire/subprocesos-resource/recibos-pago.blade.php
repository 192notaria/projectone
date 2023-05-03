<div class="card">
    <div class="card-header">
        <h5>
            {{$subprocesos_info->nombre}}
            {{-- {{$subprocesos_info->tipo_id}}
            - {{$subproceso_activo->id}} --}}

            @if ($subproceso_activo->avance($proyecto_id, $proceso_activo))
                <i class="fa-solid fa-circle-check text-success"></i>
            @endif
        </h5>
    </div>
    <style>
        .td-max-size{
            max-width: 200px !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
    <div class="card-body">
        <div class="row">
            @if (!$subproceso_activo->avance($proyecto_id, $proceso_activo))
                <div class="col-lg-12 mb-3">
                    <div class="form-group">
                        <label for="">Concepto</label>
                        <input wire:model='concepto_pago' type="text" class="form-control" placeholder="Concepto">
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <div class="form-group">
                        <label for="">Fecha del pago</label>
                        <input wire:model='fecha_pago' type="datetime-local" class="form-control">
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="">Pago del recibo</label>
                        <input wire:model='gasto_recibo' wire:keyup='calcularTotal' type="number" class="form-control" placeholder="0.0">
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="">Gastos de gestoria</label>
                        <input wire:model='gasto_gestoria' wire:keyup='calcularTotal' type="number" class="form-control" placeholder="0.0">
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <span class="badge badge-success">Total: {{$gasto_total}}</span>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="">Recibo de pago</label>
                        <x-file-pond wire:model='recibo_de_pago' name='recibo_de_pago' accept='application/pdf'
                            :options="['labelIdle' => 'Cargar un archivo... o arrastra y suelta']">
                        </x-file-pond>
                        @error('recibo_de_pago')
                            <span class="badge badge-danger mb-2">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <label for="">Comentarios u observaciones</label>
                    <textarea class="form-control" cols="30" rows="5" wire:model='observaciones_pago' placeholder="Comentarios y observaciones..."></textarea>
                </div>
                <div class="col-lg-12 mb-3">
                    <button wire:loading.attr="disabled" wire:click='guardarRecbio' class="btn btn-outline-success">
                        <span wire:loading.remove>Guardar</span>
                        <span wire:loading>Guardando...</span>
                    </button>
                </div>
            @endif
            <div class="col-lg-12 table-responsive">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Concepto</th>
                            <th>Fecha del pago</th>
                            <th>Pagos</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <style>
                            .flex-style{
                                display: flex;
                                justify-content: space-between;
                            }

                            .box-comentary{
                                border-bottom: 1px solid rgb(131, 131, 131);
                            }
                        </style>
                        @foreach ($recibos_pagos as $recibo)
                            <tr>
                                <td>
                                    {{$recibo->nombre}}
                                </td>
                                <td>{{$recibo->fecha_pago}}</td>
                                <td style="justify-content: space-between;">
                                    <div class="flex-style">
                                        <div class="flex-item">Gasto general:</div>
                                        <div class="flex-item">${{$recibo->costo_recibo}}</div>
                                    </div>
                                    <div class="flex-style">
                                        <div class="flex-item">Gastos de gestoria:</div>
                                        <div class="flex-item">${{$recibo->gastos_gestoria}}</div>
                                    </div>
                                    <hr>
                                    <div class="flex-style">
                                        <div class="flex-item">Total:</div>
                                        <div class="flex-item"><span class="badge badge-success">${{$recibo->costo_recibo + $recibo->gastos_gestoria}}</span></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button  data-bs-toggle="collapse" data-bs-target="#defaultAccordionOne{{$recibo->id}}" aria-expanded="false" aria-controls="defaultAccordionOne" class="btn btn-outline-primary"><i class="fa-solid fa-chevron-down"></i></button>
                                        <a class="btn btn-outline-success" target="_blank" href="{{url($recibo->path)}}">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        </a>
                                        @if (!$subproceso_activo->avance($proyecto_id, $proceso_activo))
                                            <button type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <div id="defaultAccordionOne{{$recibo->id}}" class="collapse" aria-labelledby="..." data-bs-parent="#toggleAccordion">
                                        @if ($recibo->observaciones)
                                        <label for="">Comentarios u observaciones</label>
                                          <h5 class="mb-5">{{$recibo->observaciones}}</h5>
                                        @endif
                                        @if (!$recibo->observaciones)
                                            <div class="container text-center">
                                                <h5>Sin comentarios u observaciones</h5>
                                            </div>
                                        @endif
                                        <div class="box-comentary"></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer">
        @if (!$subproceso_activo->avance($proyecto_id, $proceso_activo) && count($recibos_pagos) > 0)
            <button wire:click='guardarAvance' class="btn btn-outline-success">Guardar Avance</button>
        @endif
    </div>
</div>


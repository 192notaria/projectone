<div wire:ignore.self class="modal fade modal-registrar-comision"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>{{$nuevoPromotor ? "Registrar Promotor" : "Registrar Comisión"}}</h5>
            </div>
            <div class="modal-body">
                <div class="row gx-4 gy-4">
                    @if (!$nuevoPromotor)
                        @if (!$promotor_data)
                            <div class="col-lg-12">
                                <div class="form-group autocomplete">
                                    <label for="">Promotor</label>
                                    <input wire:model='buscarPromotor' type="text" class="form-control" placeholder="Buscar...">
                                    <div class="autocomplete-items">
                                        @foreach ($promotores as $promotor)
                                        <a wire:click='asignar_promotor({{$promotor}})'>
                                            <div>
                                                <strong>
                                                    {{$promotor->nombre}} {{$promotor->apaterno}} {{$promotor->amaterno}}
                                                </strong>
                                            </div>
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                                <a href="#" wire:click='nuevoPromotor(1)'>Registrar nuevo promotor...</a>
                            </div>
                        @endif
                        @if ($promotor_data)
                            <div class="col-lg-12">
                                <span class="avatar-chip avatar-dismiss bg-success mb-2 me-4">
                                    <span class="text">{{$promotor_data['nombre']}} {{$promotor_data['apaterno']}} {{$promotor_data['amaterno']}}</span>
                                    <a href="#" wire:click='removerPromotor'>
                                        <span class="closebtn ms-2">x</span>
                                    </a>
                                </span>
                            </div>
                        @endif
                        @error("promotor_data")
                            <div class="col-lg-12">
                                <span class="text-danger">{{$message}}</span>
                            </div>
                        @enderror
                        <div class="col-lg-12">
                            <label for="">Monto</label>
                            <input type="number" class="form-control" wire:model='monto_comision'>
                            @error("monto_comision")
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-12">
                            <label for="">Observaciones</label>
                            <textarea class="form-control" cols="30" rows="5" wire:model='observaciones_comision'></textarea>
                        </div>
                    @endif
                    @if ($nuevoPromotor)
                        <div class="col-lg-12">
                            <label for="">Nombre</label>
                            <input type="text" class="form-control" wire:model='nombre_promotor'>
                            @error("nombre_promotor")
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-12">
                            <label for="">Apellido Paterno</label>
                            <input type="text" class="form-control" wire:model='paterno_promotor'>
                            @error("paterno_promotor")
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-12">
                            <label for="">Apellido Materno</label>
                            <input type="text" class="form-control" wire:model='materno_promotor'>
                        </div>
                        <div class="col-lg-12">
                            <label for="">Telefono</label>
                            <input type="number" class="form-control" wire:model='telefono_promotor'>
                        </div>
                        <div class="col-lg-12">
                            <label for="">Email</label>
                            <input type="email" class="form-control" wire:model='email_promotor'>
                        </div>
                        <div class="col-lg-12">
                            <button wire:loading.attr="disabled" wire:click='guardarPromotor' class="btn btn-success">Guardar</button>
                            <button wire:loading.attr="disabled" wire:click='nuevoPromotor(0)' class="btn btn-danger">Cancelar</button>
                        </div>
                    @endif
                </div>
            </div>
            @if (!$nuevoPromotor)
                <div class="modal-footer">
                    <button wire:loading.attr="disabled" wire:click='registrarcomision' class="btn btn-outline-success">Guardar</button>
                    <button wire:loading.attr="disabled" class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    window.addEventListener('abrir-modal-registrar-comision', event => {
        $(".modal-registrar-comision").modal("show")
    })

    window.addEventListener('cerrar-modal-registrar-comision', event => {
        $(".modal-registrar-comision").modal("hide")
    })
</script>

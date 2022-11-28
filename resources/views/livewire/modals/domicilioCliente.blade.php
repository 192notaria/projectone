<!-- Modal Domicilios-->
<div class="modal @if($modalDomicilios) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modalDomicilios) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modalDomicilios) aria-modal="true" @endif  @if(!$modalDomicilios) aria-hidden="true" @endif>
    <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{$tipoDomiclio}}</h5>
                    <button wire:click='closeModalDomicilios' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="">Ingresa el codigo postal</label>
                                <input wire:model="codigo_postal" wire:change='resetSearch' type="number" class="form-control mb-1" placeholder="58000">
                                <button wire:click='buscarCodigoPostal' class="btn btn-primary" style="width: 100%">Buscar</button>
                                @if (count($colonias) > 0)
                                    <span class="badge badge-success mt-2">Codigo Postal encontrado</span>
                                @else
                                    <span class="badge badge-danger mt-2">Sin codigo postal</span>
                                @endif
                                @error('codigo_postal') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="">Calle</label>
                                <input wire:model='calle' type="text" class="form-control" placeholder="Francisco I. Madero">
                                @error('calle') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="">Numero exterior</label>
                                <input wire:model='numero_ext' type="text" class="form-control" placeholder="45, 45-A, 45-B">
                                @error('numero_ext') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-3">
                                <label for="">Numero interior</label>
                                <input wire:model='numero_int' type="text" class="form-control" placeholder="16B, 16-B, B">
                                @error('numero_int') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="">Colonia</label>
                                <select wire:model="colonia_id" class="form-control">
                                    <option value="" selected disabled>Seleccionar Colonia...</option>
                                    @foreach ($colonias as $coloniaData)
                                        <option value="{{$coloniaData->id}}">{{$coloniaData->nombre}}</option>
                                    @endforeach
                                </select>
                                @error('colonia_id') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click='closeModalDomicilios' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                    <button wire:click='guardarDomicilio' type="button" class="btn btn-outline-primary">Guardar</button>
                </div>
            </div>
    </div>
</div>

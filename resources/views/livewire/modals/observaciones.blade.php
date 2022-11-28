<!-- Modal nuevo proyecto-->
<div class="modal @if($modalObservaciones) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modalObservaciones) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modalObservaciones) aria-modal="true" @endif  @if(!$modalObservaciones) aria-hidden="true" @endif>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nueva observacion</h5>
                <button wire:click='closeModalObservaciones' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                    <i class="fa-solid fa-circle-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <div class="form-group">
                            <label for="">Titulo</label>
                            <input type="text" class="form-control" wire:model='tituloObservacion'>
                            @error('tituloObservacion')
                                <span class="badge badge-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="form-group">
                            <label for="">Descripcion</label>
                            <textarea wire:model='descripcionObservacion' class="form-control" cols="30" rows="4"></textarea>
                            @error('descripcionObservacion')
                                <span class="badge badge-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="form-group">
                            <label for="">Imagen</label>
                            <input wire:model='imgobservacion' type="file" class="form-control">
                            @error('imgobservacion')
                                <span class="badge badge-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='closeModalObservaciones' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click='saveObservacion' type="button" class="btn btn-outline-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

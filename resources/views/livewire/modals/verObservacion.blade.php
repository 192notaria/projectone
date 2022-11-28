<!-- Modal nuevo proyecto-->
<div class="modal @if($modalVerObservaciones) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modalVerObservaciones) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modalVerObservaciones) aria-modal="true" @endif  @if(!$modalVerObservaciones) aria-hidden="true" @endif>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{$tituloObservacion}}</h5>
                <button wire:click='cerrarModalVerObservacion' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                    <i class="fa-solid fa-circle-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <p>{{$descripcionObservacion}}</p>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <img style="width: 100%;" src="{{url(''.$imgobservacion)}}" alt="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='cerrarModalVerObservacion' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .modal{
        backdrop-filter: blur(5px);
        background-color: #01223770;
        -webkit-animation: fadeIn 0.3s;
    }

    @keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }

    @keyframes fadeOut {
        0% { opacity: 1; }
        100% { opacity: 0; }
    }

    .autocomplete {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        top: 100%;
        left: 0;
        right: 0;
    }

    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        border-bottom: 1px solid #d4d4d4;
        background-color: #ffff;
    }

    .autocomplete-items div:hover {
        background-color: #e9e9e9;
    }

    .autocomplete-items-2 {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        top: 100%;
        left: 0;
        right: 0;
    }

    .autocomplete-items-2 .abogadolist {
        padding: 10px;
        cursor: pointer;
        border-bottom: 1px solid #d4d4d4;
        background-color: #ffff;
    }

    .autocomplete-items-2 .abogadolist:hover {
        background-color: #e9e9e9;
    }

    .autocomplete-active {
        background-color: DodgerBlue !important;
        color: #ffffff;
    }

    .btn-outline-danger:hover{
        background-color: #e7515a !important;
        color: #ffffff !important;
    }

    .btn-outline-primary:hover{
        background-color: #4361ee !important;
        color: #ffffff !important;
    }
</style>
<div class="modal @if($modal) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modal) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modal) aria-modal="true" @endif  @if(!$modal) aria-hidden="true" @endif>
    <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo estado</h5>
                    <button wire:click='closeModal' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="">Nombre</label>
                                <input wire:model='nombre' type="text" class="form-control" placeholder="Michoacan, Sonora, Jalisco...">
                                @error('nombre') <span class="mt-3 badge badge-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-lg-12 mt-4">
                                <div class="form-group autocomplete">
                                    <label for="">Asignar Pais</label>
                                    <input type="text" class="form-control" wire:model="buscarpais" placeholder="Mexico, Canada, China...">
                                    @error('municipio_nacimiento_id') <span class="text-danger">{{ $message }}</span>@enderror
                                    <div class="autocomplete-items">
                                        @foreach ($paises as $pais)
                                            <div>
                                                <a wire:click='selectPais({{$pais->id}})'>
                                                    <strong>{{$pais->nombre}}</strong>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                @if ($pais_id == "")
                                    <span style="width: 100%;" class="badge badge-danger">Sin pais seleccionado</span>
                                @else
                                    <span style="width: 100%;" class="badge badge-success">{{$pais_nombre}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click='closeModal' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                    <button wire:click='save' type="button" class="btn btn-outline-primary">Guardar</button>
                </div>
            </div>
    </div>
</div>

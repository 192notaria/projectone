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
                    <h5 class="modal-title">Nueva Colonia</h5>
                    <button wire:click='closeModal' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="">Nombre de la colonia</label>
                                <input wire:model='nombre_colonia' type="text" class="form-control" placeholder="Centro, La Huerta, Tres Marias...">
                            </div>
                            @error('nombre_colonia')
                                <div class="col-lg-12">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                            <div class="col-lg-12 mt-4">
                                <label for="">Codigo Postal</label>
                                <div class="form-group autocomplete" style="display: flex">
                                    <input type="text" class="form-control" wire:model="cp" placeholder="58116, 58000, 56338...">
                                    <div class="autocomplete-items">
                                        @foreach ($cps as $cp_name)
                                            <a wire:click='asignarCp({{$cp_name->codigo_postal}})'>
                                                <div>
                                                    <strong>{{$cp_name->codigo_postal}}</strong>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                    @if ($cp != "" && count($cps) == 0)
                                        <button style="margin-left: 3px;" wire:click='asignarCp({{$cp}})' class="btn btn-success"><i class="fa-solid fa-circle-plus"></i></button>
                                    @endif
                                </div>
                            </div>
                            @error('codigo_postal')
                                <div class="col-lg-12">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                            <div class="col-lg-12 mt-3">
                                @if ($codigo_postal == "")
                                    <span style="width: 100%;" class="badge badge-danger">Sin codigo postal asignado</span>
                                @else
                                    <span style="width: 100%;" class="badge badge-success">{{$codigo_postal}}</span>
                                @endif
                            </div>
                            <div class="col-lg-12 mt-4">
                                <div class="form-group autocomplete">
                                    <label for="">Asignar Municipio</label>
                                    <input type="text" class="form-control" wire:model="buscarMunicipio" placeholder="Morelia, Tarimbaro, Acuitzio...">
                                    <div class="autocomplete-items">
                                        @foreach ($municipios as $municipio)
                                            <a wire:click='asignarMunicipio({{$municipio->id}})'>
                                                <div>
                                                    <strong>{{$municipio->nombre}}</strong>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @error('municipio_id')
                                <div class="col-lg-12">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                            <div class="col-lg-12 mt-3">
                                @if ($municipio_nombre == "")
                                    <span style="width: 100%;" class="badge badge-danger">Sin municipio seleccionado</span>
                                @else
                                    <span style="width: 100%;" class="badge badge-success">{{$municipio_nombre}}</span>
                                @endif
                            </div>
                            <div class="col-lg-12 mt-4">
                                <label for="">Ciudad o Localidad</label>
                                <div class="form-group autocomplete" style="display: flex">
                                    <input type="text" class="form-control" wire:model="ciudad_localidad" placeholder="Uruapan, Zamora, Hidalgo...">
                                    <div class="autocomplete-items">
                                        @foreach ($ciudades as $ciudad)
                                            <a wire:click='asignarCiudad("{{$ciudad->ciudad}}")'>
                                                <div>
                                                    <strong>{{$ciudad->ciudad}}</strong>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                    @if ($ciudad_localidad != "" && count($ciudades) == 0)
                                        <button style="margin-left: 3px;" wire:click='asignarCiudad({{$ciudad_localidad}})' class="btn btn-success"><i class="fa-solid fa-circle-plus"></i></button>
                                    @endif
                                </div>
                            </div>
                            @error('ciudad_o_localidad')
                                <div class="col-lg-12">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                            <div class="col-lg-12 mt-3">
                                @if ($ciudad_o_localidad == "")
                                    <span style="width: 100%;" class="badge badge-danger">Sin ciudad o localidad asignado</span>
                                @else
                                    <span style="width: 100%;" class="badge badge-success">{{$ciudad_o_localidad}}</span>
                                @endif
                            </div>
                            <div class="col-lg-12 mt-4">
                                <label for="">Asentamiento</label>
                                <div class="form-group autocomplete" style="display: flex">
                                    <input type="text" class="form-control" wire:model="buscar_asentamiento" placeholder="Colonia, Fraccionamiento, Barrio...">
                                    <div class="autocomplete-items">
                                        @foreach ($asentamientos as $asentamiento_data)
                                            <a wire:click='asignarAsentamiento("{{$asentamiento_data->asentamiento}}")'>
                                                <div>
                                                    <strong>{{$asentamiento_data->asentamiento}}</strong>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                    @if ($buscar_asentamiento != "" && count($asentamientos) == 0)
                                        <button style="margin-left: 3px;" wire:click='asignarAsentamiento("{{$buscar_asentamiento}}")' class="btn btn-success"><i class="fa-solid fa-circle-plus"></i></button>
                                    @endif
                                </div>
                            </div>
                            @error('asentamiento')
                                <div class="col-lg-12">
                                    <span class="text-danger">{{ $message }}</span>
                                </div>
                            @enderror
                            <div class="col-lg-12 mt-3">
                                @if ($asentamiento == "")
                                    <span style="width: 100%;" class="badge badge-danger">Sin asentamiento asignado</span>
                                @else
                                    <span style="width: 100%;" class="badge badge-success">{{$asentamiento}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click='closeModal' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                    <button wire:click='saveColonia' type="button" class="btn btn-outline-primary">Guardar</button>
                </div>
            </div>
    </div>
</div>

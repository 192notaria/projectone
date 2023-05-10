<div class="row">
    <div class="col-lg-12 mb-3">
        <div class="card">
            <div class="card-header">
                <div class="row ">
                    <div class="col-lg-12 mb-2">
                        <h3>
                            Paises
                            @can("crear-paises")
                                <button wire:click='openModal' class="btn btn-outline-success"><i class="fa-solid fa-circle-plus"></i></button>
                            @endcan
                        </h3>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-1 mb-2">
                        <select wire:model='cantidadPaises' class="form-control">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                    <div class="col-lg-11 mb-0 col-md-11 col-sm-11 filtered-list-search">
                        <form class="form-inline">
                            <div class="w-100">
                                <input wire:model="buscarPais" type="text" class="w-100 form-control product-search br-30" id="input-search" placeholder="Pais">
                                <button class="btn btn-primary" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Pais</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paisesData as $pais)
                            <tr>
                                <td>{{mb_strtoupper($pais->nombre)}}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Actions Buttons">
                                        @can("editar-paises")
                                            <button wire:click='edit({{$pais->id}})' type="button" class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></button>
                                        @endcan
                                        @can("borrar-paises")
                                            <button wire:click='delete({{$pais->id}})' type="button" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$paisesData->links('pagination-links')}}
            </div>
        </div>
    </div>

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
    </style>

     <!-- Modal -->
     <div class="modal @if($modal) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modal) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modal) aria-modal="true" @endif  @if(!$modal) aria-hidden="true" @endif>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo País</h5>
                    <button wire:click='closeModal' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="">Nombre del pais</label>
                                <input wire:model="nombre" type="text" class="form-control" placeholder="México, Canada, China...">
                                @error('nombre') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click='closeModal' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                    <button wire:click='guardar' type="button" class="btn btn-outline-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-12 mb-2">
        <button type="button" wire:click='openModal' class="btn btn-outline-primary">
            <i class="fa-solid fa-plus"></i>
        </button>
    </div>
    <div class="col-lg-12">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha de creación</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if (count($roles) > 0)
                    @foreach ($roles as $rol)
                        <tr>
                            <td>
                                <div class="media">
                                    <div class="media-body align-self-center">
                                        <h6 class="mb-0">{{$rol->name}}</h6>
                                        <span>Plataforma: {{$rol->guard_name}}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <svg class="text-info" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                <span>{{$rol->created_at}}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Basic">
                                    <button wire:click='viewRole({{$rol->id}})' type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalViewRol">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    @can('editar-rol')
                                        <button wire:click='editRole({{$rol->id}})' type="button" class="btn btn-primary">
                                            <i class="fa-solid fa-file-pen"></i>
                                        </button>
                                    @endcan
                                    @can('borrar-rol')
                                        <button wire:click='deleteRol({{$rol->id}})' type="button" class="btn btn-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="text-center">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <span>Sin roles creados</span>
                            </td>
                        </tr>
                    @endif
            </tbody>
        </table>
    </div>

    <style>
        .modal{
            backdrop-filter: blur(2px);
            background-color: #00000070;
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
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo Rol de Usuario</h5>
                    <button wire:click='closeModal' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="">Nombre</label>
                                <input wire:model="rolName" type="text" class="form-control" placeholder="Administrador, Editor, Analista...">
                                @error('rolName') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="">Permisos para el rol</label>
                                <div class="row">
                                    @foreach ($permisos as $key => $permiso)
                                        <div class="col-lg-3 mb-2">
                                            {{-- <div class="switch form-switch-custom switch-inline mb-3 form-switch-success">
                                                <input class="switch-input" type="checkbox" role="switch" id="form-custom-switch-success{{$key}}" wire:model='permisosCheck.{{$permiso->id}}' value="{{$permiso->id}}">
                                                <label class="switch-label" for="form-custom-switch-success{{$key}}">{{$permiso->name}}</label>
                                            </div> --}}
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title"><label class="switch-label" for="form-custom-switch-success{{$key}}">{{$permiso->name}}</label></h5>
                                                    <p class="mb-0">
                                                        <div class="switch form-switch-custom switch-inline mb-3 form-switch-success">
                                                            <input class="switch-input" type="checkbox" role="switch" id="form-custom-switch-success{{$key}}" wire:model='permisosCheck.{{$permiso->id}}' value="{{$permiso->id}}">
                                                        </div>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click='closeModal' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                    <button wire:click.prevent='saveRol({{ auth()->user()->id }})' type="button" class="btn btn-outline-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View-->
    <div class="modal fade" id="modalViewRol" tabindex="-1" role="dialog" aria-labelledby="modalViewRolLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalViewRolLabel">{{$rolName}}</h5>
                    <button wire:click='closeModal' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @foreach ($permisos as $key => $permiso)
                            {{-- <div class="col-lg-2">
                                <div class="switch form-switch-custom switch-inline mb-3 form-switch-success">
                                    <input disabled class="switch-input" type="checkbox" role="switch" id="form-custom-switch-success{{$key}}" wire:model='permisosCheck.{{$permiso->id}}' value="{{$permiso->id}}">
                                    <label class="switch-label" for="form-custom-switch-success{{$key}}">{{$permiso->name}}</label>
                                </div>
                            </div> --}}
                            <div class="col-lg-3 mb-2">
                                {{-- <div class="card">
                                    <div class="card-header">
                                        <label class="switch-label" for="form-custom-switch-success{{$key}}">{{$permiso->name}}</label>
                                    </div>
                                    <div class="card-footer">
                                        <div class="switch form-switch-custom switch-inline mb-3 form-switch-success">
                                            <input disabled class="switch-input" type="checkbox" role="switch" id="form-custom-switch-success{{$key}}" wire:model='permisosCheck.{{$permiso->id}}' value="{{$permiso->id}}">
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><label class="switch-label" for="form-custom-switch-success{{$key}}">{{$permiso->name}}</label></h5>
                                        <p class="mb-0">
                                            <div class="switch form-switch-custom switch-inline mb-3 form-switch-success">
                                                <input disabled class="switch-input" type="checkbox" role="switch" id="form-custom-switch-success{{$key}}" wire:model='permisosCheck.{{$permiso->id}}' value="{{$permiso->id}}">
                                            </div>
                                        </p>
                                    </div>
                                </div>
                                {{-- <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="media me-5">
                                        <div class="media-body align-self-center">
                                            <h6 class="mb-0 fw-bold">{{$permiso->name}}</h6>
                                        </div>
                                    </div>
                                    <div class="switch form-switch-custom switch-inline mb-3 form-switch-success">
                                        <input disabled class="switch-input" type="checkbox" role="switch" id="form-custom-switch-success{{$key}}" wire:model='permisosCheck.{{$permiso->id}}' value="{{$permiso->id}}">
                                        <label class="switch-label" for="form-custom-switch-success{{$key}}"></label>
                                    </div>
                                </li> --}}
                            </div>

                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

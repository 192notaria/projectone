<style>
    .error-form{
        border: 1px solid red !important;
    }
</style>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>{{$cuenta_tipo_id ? "Editar Tipo de Cuenta" : "Registrar Tipo de Cuenta"}}</h4>
        <div>
            <button wire:click='clearAndReturnToHome' class="btn btn-danger me-2">Cancelar</button>
            <button wire:click='registrar_tipo_cuenta' class="btn btn-success">Guardar</button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 mt-2">
                <label for="">Nombre tipo de cuenta</label>
                <input type="text" class="form-control" wire:model='nombre_tipo_cuenta'>
                @error("nombre_tipo_cuenta")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-lg-12 mt-2">
                <label for="">Descripcion</label>
                <textarea wire:model='descripcion_tipo_cuenta' class="form-control" cols="30" rows="5"></textarea>
                @error("descripcion_tipo_cuenta")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
        </div>
    </div>
</div>

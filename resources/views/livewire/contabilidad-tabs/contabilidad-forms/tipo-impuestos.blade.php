<style>
    .error-form{
        border: 1px solid red !important;
    }
</style>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>{{$impuesto_id ? "Editar Tipo de Impuesto" : "Registrar Tipo de Impuesto"}}</h4>
        <div>
            <button wire:click='clearAndReturnToHome' class="btn btn-danger me-2">Cancelar</button>
            <button wire:click='registrar_impuesto' class="btn btn-success">Guardar</button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 mt-2">
                <label for="">Nombre tipo del impuesto</label>
                <input type="text" class="form-control" wire:model='nombre_impuesto'>
                @error("nombre_impuesto")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-lg-12 mt-2">
                <label for="">Descripcion</label>
                <textarea wire:model='observaciones_impuesto' class="form-control" cols="30" rows="5"></textarea>
                @error("descripcion_tipo_cuenta")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
        </div>
    </div>
</div>

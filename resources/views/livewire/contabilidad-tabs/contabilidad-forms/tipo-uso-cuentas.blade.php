<style>
    .error-form{
        border: 1px solid red !important;
    }
</style>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>{{$tipo_uso_cuenta_id ? "Editar Tipo uso de cuenta" : "Registrar Tipo uso de cuenta"}}</h4>
        <div>
            <button wire:click='clearAndReturnToHome' class="btn btn-danger me-2">Cancelar</button>
            <button wire:click='registrar_tuc' class="btn btn-success">Guardar</button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 mt-2">
                <label for="">Nombre tipo del impuesto</label>
                <input type="text" class="form-control" wire:model='nombre_tuc'>
                @error("nombre_impuesto")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-lg-12 mt-2">
                <label for="">Descripción</label>
                <textarea wire:model='observaciones_tuc' class="form-control" cols="30" rows="5"></textarea>
                @error("descripcion_tipo_cuenta")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
        </div>
    </div>
</div>

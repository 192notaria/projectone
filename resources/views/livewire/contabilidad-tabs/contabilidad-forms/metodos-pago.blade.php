<style>
    .error-form{
        border: 1px solid red !important;
    }
</style>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>{{$metodo_pago_id ? "Editar Metodo de Pago" : "Registrar Metodo de Pago"}}</h4>
        <div>
            <button  wire:click='clearAndReturnToHome' class="btn btn-danger me-2">Cancelar</button>
            <button wire:click='registrar_metodo_pago' class="btn btn-success">Guardar</button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 mt-2">
                <label for="">Nombre</label>
                <input type="text" class="form-control" wire:model='nombre_metodo_pago'>
                @error("nombre_metodo_pago")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-lg-12 mt-2">
                <label for="">Observaciones</label>
                <textarea wire:model='observaciones_metodo_pago' class="form-control" cols="30" rows="5"></textarea>
            </div>
        </div>
    </div>
</div>

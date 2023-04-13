<style>
    .error-form{
        border: 1px solid red !important;
    }
</style>
<div class="card">
    <div class="card-header">
        <h4>{{$categoria_gasto_id ? "Editar Categoria de gasto" : "Registrar Categoria de gasto"}}</h4>
        <button class="btn btn-danger" wire:click='clearAndReturnToHome'>Cancelar</button>
        <button class="btn btn-success" wire:click='registro_categoria_gastos' >Guardar</button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 mt-2 mb-2">
                <label for="" @error("categoria_gasto_nombre") class="text-danger" @enderror>Nombre</label>
                <input wire:model='categoria_gasto_nombre' class="form-control @error("categoria_gasto_nombre") error-form @enderror" type="text" placeholder="Nombre">
                @error("categoria_gasto_nombre")
                    <span class="text-danger mt-2">{{$message}}</span>
                @enderror
            </div>
            <div class="col-lg-12 mt-2">
                <label for="">Descripcion</label>
                <textarea wire:model='categoria_gasto_descripcion' class="form-control" cols="30" rows="10"></textarea>
            </div>
        </div>
    </div>
</div>

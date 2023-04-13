<style>
    .error-form{
        border: 1px solid red !important;
    }
</style>
<div class="card">
    <div class="card-header">
        <h4>{{$banco_nombre ? "Editar Banco" : "Registrar Banco"}}</h4>
        <button class="btn btn-danger" wire:click='cambiar_vista("home")'>Cancelar</button>
        <button class="btn btn-success" wire:click='registro_bancos'>Guardar</button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 mt-2 mb-2">
                <label for="" @error("banco_nombre") class="text-danger" @enderror>Nombre</label>
                <input wire:model='banco_nombre' class="form-control @error("banco_nombre") error-form @enderror" type="text" placeholder="Nombre">
                @error("banco_nombre")
                    <span class="text-danger mt-2">{{$message}}</span>
                @enderror
            </div>
            <div class="col-lg-12 mt-2">
                <label for="">Descripcion</label>
                <textarea wire:model='banco_descripcion' class="form-control" cols="30" rows="10"></textarea>
            </div>
        </div>
    </div>
</div>

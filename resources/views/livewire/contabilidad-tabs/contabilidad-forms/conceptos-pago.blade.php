<style>
    .error-form{
        border: 1px solid red !important;
    }
</style>
<div class="card">
    <div class="card-header">
        <h4>{{$concepto_pago_id ? "Editar Concepto de Pago" : "Registrar Concepto de Pago"}}</h4>
        <button class="btn btn-danger" wire:click='clearAndReturnToHome'>Cancelar</button>
        <button class="btn btn-success" wire:click='guardar_concepto_pago'>Guardar</button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 mt-2 mb-2">
                <label for="" @error("concepto_pago_nombre") class="text-danger" @enderror>Concepto</label>
                <input wire:model='concepto_pago_nombre' class="form-control @error("concepto_pago_nombre") error-form @enderror" type="text" placeholder="Nombre">
                @error("concepto_pago_nombre")
                    <span class="text-danger mt-2">{{$message}}</span>
                @enderror
            </div>
            <div class="col-lg-3 mt-2">
                <label for="">Categoria</label>
                <select class="form-select" wire:model='concepto_pago_categoria_id'>
                    <option value="" selected disabled>Seleccionar...</option>
                    @foreach ($categoria_gastos as $cat)
                        <option value="{{$cat->id}}">{{$cat->nombre}}</option>
                    @endforeach
                </select>
                @error("concepto_pago_categoria_id")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-lg-3 mt-2">
                <label for="">Precio Sugerido</label>
                <input type="number" class="form-control" wire:model='concepto_pago_precio'>
                @error("concepto_pago_precio")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-lg-3 mt-2">
                <label for="">% Impuesto</label>
                <input type="number" class="form-control" wire:model='concepto_pago_impuesto'>
                @error("concepto_pago_impuesto")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-lg-3 mt-2">
                <label for="">Tipo de impuesto</label>
                <select class="form-select" wire:model='concepto_pago_impuesto_id'>
                    <option value="" selected disabled>Seleccionar...</option>
                    @foreach ($tipo_impuestos as $tipo)
                        <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                    @endforeach
                </select>
                @error("concepto_pago_impuesto_id")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
        </div>
    </div>
</div>

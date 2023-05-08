<style>
    .error-form{
        border: 1px solid red !important;
    }
</style>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>{{$cuenta_id ? "Editar Concepto de Pago" : "Registrar Concepto de Pago"}}</h4>
        <div>
            <button  wire:click='clearAndReturnToHome' class="btn btn-danger me-2">Cancelar</button>
            <button wire:click='registrar_cuenta' class="btn btn-success">Guardar</button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4 mt-2 mb-2">
                <label for="">Uso</label>
                <select class="form-select" wire:model='uso_cuenta_id'>
                    <option value="" selected disabled>Seleccionar...</option>
                    @foreach ($tipo_uso_cuentas as $tipo_uso )
                        <option value="{{$tipo_uso->id}}">{{$tipo_uso->nombre}}</option>
                    @endforeach
                </select>
                @error("uso_cuenta_id")
                    <span class="text-danger mt-2">{{$message}}</span>
                @enderror
            </div>
            <div class="col-lg-4 mt-2">
                <label for="">Tipo de cuenta</label>
                <select class="form-select" wire:model='tipo_cuenta_id'>
                    <option value="" selected disabled>Seleccionar...</option>
                    @foreach ($tipo_cuentas as $tipo )
                        <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                    @endforeach
                </select>
                @error("tipo_cuenta_id")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-lg-4 mt-2">
                <label for="">Banco</label>
                <select class="form-select" wire:model='banco_cuenta_id'>
                    <option value="" selected disabled>Seleccionar...</option>
                    @foreach ($bancos as $banco)
                        <option value="{{$banco->id}}">{{$banco->nombre}}</option>
                    @endforeach
                </select>
                @error("banco_cuenta_id")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-lg-4 mt-2">
                <label for="">Titular</label>
                <input type="text" class="form-control" wire:model='titular_cuenta'>
                @error("titular_cuenta")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-lg-4 mt-2">
                <label for="">Número de cuenta</label>
                <input type="number" class="form-control" wire:model='numero_cuenta'>
                @error("numero_cuenta")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-lg-4 mt-2">
                <label for="">Clabe interbancaria</label>
                <input type="number" class="form-control" wire:model='clabe_cuenta'>
                @error("clabe_cuenta")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="col-lg-12 mt-2">
                <label for="">Observaciones</label>
                <textarea wire:model='observaciones_cuenta' class="form-control" cols="30" rows="5"></textarea>
            </div>
        </div>
    </div>
</div>

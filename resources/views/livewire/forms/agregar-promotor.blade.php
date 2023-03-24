<div class="col-lg-12 mb-3">
    <button wire:click='cambiarVistaComision(1)' class="btn btn-danger"><i class="fa-solid fa-chevron-left"></i> Regresar</button>
    <button wire:click='registrarPromotor' class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Registrar Promotor</button>
</div>

<style>
    .input-error{
        border: 1px solid red !important;
    }
</style>

<div class="col-lg-4 mb-3">
    <label for="">Nombre</label>
    <input type="text" class="form-control" placeholder="Luis" wire:model='nombre_promotor'>
    @error('nombre_promotor') <span class="text-danger">{{$message}}</span> @enderror
</div>
<div class="col-lg-4 mb-3">
    <label for="">Apellido Paterno</label>
    <input type="text" class="form-control" placeholder="Rodiguez" wire:model='apaterno_promotor'>
    @error('apaterno_promotor') <span class="text-danger">{{$message}}</span> @enderror
</div>
<div class="col-lg-4 mb-3">
    <label for="">Apelido Materno</label>
    <input type="text" class="form-control" placeholder="Perez" wire:model='amaterno_promotor'>
    @error('amaterno_promotor') <span class="text-danger">{{$message}}</span> @enderror
</div>
<div class="col-lg-6 mb-3">
    <label for="">Teléfono</label>
    <input type="text" class="form-control" placeholder="443 123 4567" wire:model='telefono_promotor'>
    @error('telefono_promotor') <span class="text-danger">{{$message}}</span> @enderror
</div>
<div class="col-lg-6 mb-3">
    <label for="">Correo</label>
    <input type="text" class="form-control" placeholder="nombre@correo.com" wire:model='email_promotor'>
    @error('email_promotor') <span class="text-danger">{{$message}}</span> @enderror
</div>

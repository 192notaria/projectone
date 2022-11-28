@extends('layouts.auth')
@section('authContent')
<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center ms-lg-auto me-lg-0 mx-auto">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        @include('layouts.message')
                    </div>
                    <div class="col-md-12 mb-3">
                        <h2>Registro</h2>
                        <p>Ingresa tus datos para continuar</p>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input name="name" type="text" class="form-control" placeholder="Juan">
                            @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Apellido apaterno</label>
                            <input name="apaterno" type="text" class="form-control" placeholder="Perez">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Apellido amaterno</label>
                            <input name="amaterno" type="text" class="form-control" placeholder="Perez">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Genero</label>
                            <select class="form-select" name="genero">
                                <option value="" selected disabled>Genero...</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Ocupación</label>
                            {{-- <input name="ocupacion" class="form-control" type="text" placeholder="INGENIERO EN SISTEMAS"> --}}
                            <select name="ocupacion" class="form-select">
                                <option value="" selected disabled>Seleccionar...</option>
                                @foreach ($ocupaciones as $ocupacion)
                                    <option value="{{$ocupacion->id}}">{{$ocupacion->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label>Correo</label>
                            <input name="email" type="text" class="form-control" value="" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label">Fecha de nacimiento</label>
                            <input name="fecha_nacimiento" class="form-control" type="date">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label >Teléfono</label>
                            <input name="telefono" type="telefono" class="form-control" placeholder="4431234567">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-4">
                            <button type="submit" class="btn btn-warning w-100">Continuar</button>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="text-center">
                            <p class="mb-0">¿Ya tienes cuenta? <a href="/login" class="text-warning">Iniciar Sesión</a></p>
                        </div>
                    </div>
                    <br>
                    <br>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


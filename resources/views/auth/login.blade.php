@extends('layouts.auth')

@section('authContent')
<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center ms-lg-auto me-lg-0 mx-auto">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        @include('layouts.message')
                    </div>
                    <div class="col-md-12 mb-3">
                        <h2>Iniciar Sesión</h2>
                        <p>Ingresa tu correo y contraseña para iniciar sesión</p>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Correo</label>
                            <input name="email" type="email" class="form-control" placeholder="usuario@email.com">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label">Contraseña</label>
                            <input name="password" type="password" class="form-control" placeholder="***********">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-4">
                            <button type="submit" class="btn btn-warning w-100">Continuar</button>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="text-center">
                            <p class="mb-0">¿No tienes una cuenta? <a href="/register" class="text-warning">Solicitar una cuenta</a></p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


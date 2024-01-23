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
                        <h2>Hola!</h2>
                        <p>Bienvenid@ a la plataforma de la Notaria 192</p>
                    <div class="col-12">
                        <div class="mb-4">
                            <a href="/dashboard" class="btn btn-warning w-100">Continuar</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


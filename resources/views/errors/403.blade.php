

@extends('layouts.app')
@section('links-content')
    <link href="{{ url('v3/src/assets/css/light/elements/search.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('v3/src/assets/css/dark/elements/search.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ url('v3/src/assets/css/light/forms/switches.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('v3/src/assets/css/dark/forms/switches.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/dark/users/user-profile.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/light/elements/custom-pagination.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/dark/elements/custom-pagination.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/dark/pages/error/style-maintanence.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
    <div class="mt-5 ontainer maintanence-content">
        <div class="row justify-content-center">
            <div class="col-lg-1 mb-4">
                <a href="/dashboard" class="justify-content-center text-center">
                    <img alt="logo" src="{{url('v3/src/assets/img/rounded-logo-notaria.svg')}}" class="text-center dark-element theme-logo">
                    <img alt="logo" src="{{url('v3/src/assets/img/rounded-logo-notaria.svg')}}" class="text-center light-element theme-logo">
                </a>
            </div>
            <div class="col-lg-12 mt-4">
                <div class="text-center justify-content-center">
                    <h1 class="error-title">403!</h1>
                    <p class="error-text">No estas autorizado para entrar en esta seccion.</p>
                    <p class="text">Ponte en contacto con el administrador del sistema para obtener acceso y actualice esta pagina</p>
                    <p class="text">Puede regresar a la pagina de inicio desde aqui abajo o dando clic en el logo de arriba</p>
                    <a href="/dashboard" class="btn btn-dark mt-4">Inicio</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts-content')
    <script src="{{ url("v3/src/plugins/src/highlight/highlight.pack.js") }}"></script>
    <script src="{{ url('v3/src/assets/js/elements/custom-search.js') }}"></script>
@endsection



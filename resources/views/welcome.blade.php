<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
        <title>Login Notaria 192 </title>
        <link rel="icon" type="image/x-icon" href="{{ url("v3/src/assets/img/rounded-logo-notaria.svg") }}"/>
        <link href="{{url('v3/layouts/collapsible-menu/css/light/loader.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('v3/layouts/collapsible-menu/css/dark/loader.css')}}" rel="stylesheet" type="text/css" />
        <script src="{{url('v3/layouts/collapsible-menu/loader.js')}}"></script>
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
        <link href="{{url('v3/src/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />

        <link href="{{url('v3/layouts/collapsible-menu/css/light/plugins.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('v3/src/assets/css/light/authentication/auth-cover.css')}}" rel="stylesheet" type="text/css" />

        <link href="{{url('v3/layouts/collapsible-menu/css/dark/plugins.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('v3/src/assets/css/dark/authentication/auth-cover.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ url( 'v3/src/plugins/src/font-icons/fontawesome/css/all.css' ) }}" rel="stylesheet">

    </head>
    <body class="form">

        <div id="load_screen">
            <div class="loader">
                <div class="loader-content">
                    <div class="spinner-grow align-self-center"></div>
                </div>
            </div>
        </div>

        <div class="auth-container d-flex">
            <div class="container mx-auto align-self-center">
                <div class="row">
                    <div class="col-6 d-lg-flex d-none h-100 my-auto top-0 start-0 text-center justify-content-center flex-column">
                        <div class="auth-cover-bg-image"></div>
                        <div class="auth-overlay" style="width: 100%;"></div>
                        <div class="position-relative">
                            <img style="width: 100%;" src="{{url('v3/src/assets/img/notarialogo.svg')}}" alt="auth-img">
                            <h2 class="mt-5 text-white font-weight-bolder px-2">
                                La mejor Notaria de Michoacán
                            </h2>
                            <p class="text-white px-2">Enfocados a servir a nuestros clientes, mediante una atención personalizada para brindarles seguridad jurídica y ayudarlos a que su patrimonio crezca.</p>
                            <a href="/login" class="btn btn-warning">
                                Continuar <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <script src="{{url('v3/src/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    </body>
</html>

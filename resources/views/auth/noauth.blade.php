@guest
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
        <title>Error | CORK - Multipurpose Bootstrap Dashboard Template </title>
        <link rel="icon" type="image/x-icon" href="{{ url( 'v3/src/assets/img/favicon.ico' ) }}"/>
        <link href="{{ url( 'v3/layouts/collapsible-menu/css/light/loader.css' ) }}" rel="stylesheet" type="text/css" />
        <link href="{{ url( 'v3/layouts/collapsible-menu/css/dark/loader.css' ) }}" rel="stylesheet" type="text/css" />
        <script src="{{ url( 'v3/layouts/collapsible-menu/loader.js' ) }}"></script>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
        <link href="{{ url( 'v3/src/bootstrap/css/bootstrap.min.css' ) }}" rel="stylesheet" type="text/css" />

        <link href="{{ url( 'v3/layouts/collapsible-menu/css/light/plugins.css' ) }}" rel="stylesheet" type="text/css" />
        <link href="{{ url( 'v3/src/assets/css/light/pages/error/error.css' ) }}" rel="stylesheet" type="text/css" />

        <link href="{{ url( 'v3/layouts/collapsible-menu/css/dark/plugins.css' ) }}" rel="stylesheet" type="text/css" />
        <link href="{{ url( 'v3/src/assets/css/dark/pages/error/error.css' ) }}" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->

        <style>
            body.dark .theme-logo.dark-element {
                display: inline-block;
            }
            .theme-logo.dark-element {
                display: none;
            }
            body.dark .theme-logo.light-element {
                display: none;
            }
            .theme-logo.light-element {
                display: inline-block;
            }
        </style>

    </head>

    <body class="error text-center">

        <!-- BEGIN LOADER -->
        <div id="load_screen"> <div class="loader"> <div class="loader-content">
            <div class="spinner-grow align-self-center"></div>
        </div></div></div>
        <!--  END LOADER -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 mr-auto mt-5 text-md-left text-center">
                    <a href="index.html" class="ml-md-5">
                        <img alt="image-404" src="{{ url('v3/src/assets/img/logo.svg') }}" class="dark-element theme-logo">
                        <img alt="image-404" src="{{ url('v3/src/assets/img/logo2.svg') }}" class="light-element theme-logo">
                    </a>
                </div>
            </div>
        </div>
        <div class="container-fluid error-content">
            <div class="">
                <p class="mini-text">Ooops!</p>
                <h1>401</h1>
                <p class="error-text mb-5 mt-1">Parece que no tienes permiso para ver el contenido de esta pagina, porfavor inicia sesión para ver el contenido</p>
                <img src="{{ url( 'v3/src/assets/img/error.svg' ) }}" alt="cork-admin-404" class="error-img">
                <a href="/login" class="btn btn-dark mt-5">Log in</a>
            </div>
        </div>
        <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
        <script src="{{ url('v3/src/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- END GLOBAL MANDATORY SCRIPTS -->
    </body>
</html>
@endguest

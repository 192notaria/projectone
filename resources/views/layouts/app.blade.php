@auth
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
        <title>Notaria 192</title>
        <link rel="icon" type="image/x-icon" href="{{ url("v3/src/assets/img/rounded-logo-notaria.svg") }}"/>
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

        <link href="{{ url("v3/layouts/collapsible-menu/css/light/loader.css") }}" rel="stylesheet" type="text/css" />
        <link href="{{ url("v3/layouts/collapsible-menu/css/dark/loader.css") }}" rel="stylesheet" type="text/css" />

        <script src="{{ url("v3/layouts/collapsible-menu/loader.js") }}"></script>
        <link href="{{ url("v3/src/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />

        <link href="{{ url("v3/layouts/collapsible-menu/css/light/plugins.css") }}" rel="stylesheet" type="text/css" />
        <link href="{{ url("v3/layouts/collapsible-menu/css/dark/plugins.css") }}" rel="stylesheet" type="text/css" />

        <link href="{{ url('v3/src/plugins/src/font-icons/fontawesome/css/all.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ url('v3/src/assets/css/light/elements/alert.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ url('v3/src/assets/css/dark/elements/alert.css') }}">

        <link href="{{ url('v3/src/plugins/src/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('v3/src/plugins/css/light/notification/snackbar/custom-snackbar.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('v3/src/plugins/css/dark/notification/snackbar/custom-snackbar.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ url('v3/src/assets/css/light/components/modal.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('v3/src/assets/css/dark/components/modal.css') }}" rel="stylesheet" type="text/css" />

        @yield('links-content')
        @livewireStyles()
    </head>
        <body class=" layout-boxed alt-menu">
            <!-- BEGIN LOADER -->
            <div id="load_screen">
                <div class="loader">
                    <div class="loader-content">
                        <div class="spinner-grow align-self-center"></div>
                    </div>
                </div>
            </div>

            @include('layouts.header')

            <div class="main-container sidebar-closed " id="container">
                <div class="overlay"></div>
                <div class="search-overlay"></div>

                @include('layouts.sidebar')

                <div id="content" class="main-content">
                    @yield('content')
                    @include('layouts.footer')
                </div>
            </div>


            @livewireScripts()
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>

            <script src="{{ url("/v3/src/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
            <script src="{{ url("/v3/src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js") }}"></script>
            <script src="{{ url("/v3/src/plugins/src/mousetrap/mousetrap.min.js") }}"></script>
            <script src="{{ url("/v3/layouts/collapsible-menu/app.js") }}"></script>

            <script src="{{ url("/v3/src/plugins/src/global/vendors.min.js") }}"></script>
            <script src="{{ url('/v3/src/plugins/src/notification/snackbar/snackbar.min.js') }}"></script>

            <script src="{{ asset("js/app.js") }}"></script>

            @yield('scripts-content')
            <script>
                Echo.private('notification.{{auth()->id()}}').listen('.send.notification', (e) => {
                    if(e.message == "closession"){
                        document.getElementById('logout-form').submit();
                    }

                    Livewire.emit('listenNotify')

                    var myAudio= document.createElement('audio');
                    myAudio.src = "{{ url("v3/src/assets/audio/notification.mp3") }}";
                    myAudio.play();

                    Snackbar.show({
                        text: e.message,
                        actionTextColor: '#fff',
                        backgroundColor: '#00ab55',
                        pos: 'top-center',
                        duration: 5000,
                        actionText: '<i class="fa-solid fa-circle-xmark"></i>'
                    });
                })

                Echo.private('interphone.{{auth()->id()}}').listen('.send.interphone', (e) => {
                    console.log(e.route)
                    // if(e.message == "closession"){
                    //     document.getElementById('logout-form').submit();
                    // }

                    // Livewire.emit('listenNotify')

                    var myAudio= document.createElement('audio');
                    myAudio.src = "http://192.168.68.157/storage/" + e.route;
                    myAudio.play().then(()=>{
                        console.log("Escuchar")
                    });

                    Snackbar.show({
                        text: e.message,
                        actionTextColor: '#fff',
                        backgroundColor: '#00ab55',
                        pos: 'top-center',
                        duration: 5000,
                        actionText: '<i class="fa-solid fa-circle-xmark"></i>'
                    });
                })
            </script>
        </body>
</html>
@endauth
@include('auth.noauth')

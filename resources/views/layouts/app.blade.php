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

        <link href="{{ url( 'v3/src/plugins/src/font-icons/fontawesome/css/all.css' ) }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ url('v3/src/assets/css/light/elements/alert.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ url('v3/src/assets/css/dark/elements/alert.css') }}">

        <link href="{{ url('v3/src/plugins/src/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('v3/src/plugins/css/light/notification/snackbar/custom-snackbar.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('v3/src/plugins/css/dark/notification/snackbar/custom-snackbar.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ url('v3/src/assets/css/light/components/modal.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('v3/src/assets/css/dark/components/modal.css') }}" rel="stylesheet" type="text/css" />

        @yield('links-content')
        @livewireStyles()
        @fcStyles
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
            @fcScripts
            <script src="{{ url("v3/src/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
            <script src="{{ url("v3/src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js") }}"></script>
            <script src="{{ url("v3/src/plugins/src/mousetrap/mousetrap.min.js") }}"></script>
            <script src="{{ url("v3/layouts/collapsible-menu/app.js") }}"></script>

            <script src="{{ url("v3/src/plugins/src/global/vendors.min.js") }}"></script>
            <script src="{{ url('v3/src/plugins/src/notification/snackbar/snackbar.min.js') }}"></script>

            @yield('scripts-content')
            <script src="{{ asset("js/app.js") }}"></script>
            <script>
                Echo.private('notification.{{auth()->id()}}').listen('.send.notification', (e) => {

                    // const notificationsContent = document.getElementById("notifications-Content")
                    // document.getElementById("notificationsSpan").classList.add("badge", "badge-success")
                    // document.getElementById("no-notifications").style.display = "none"
                    if(e.message == "closession"){
                        document.getElementById('logout-form').submit();
                    }

                    // const content = '<div class="media server-log">'+
                    //     '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6" y2="6"></line><line x1="6" y1="18" x2="6" y2="18"></line></svg>'+
                    //         '<div class="media-body">'+
                    //             '<div class="data-info">'+
                    //                 '<h6 class="">' + e.message + '</h6>'+
                    //                 '<p class="">Hace 3 segundos</p>'+
                    //             '</div>'+
                    //             '<div class="icon-status">'+
                    //             '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>'+
                    //         '</div>'+
                    //     '</div>'+
                    // '</div>'

                    // const createDiv = document.createElement("div")
                    // createDiv.classList.add("dropdown-item")
                    // createDiv.innerHTML = content
                    // document.getElementById("notifications-Content").appendChild(createDiv)
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
            </script>
        </body>
</html>
@endauth
@include('auth.noauth')

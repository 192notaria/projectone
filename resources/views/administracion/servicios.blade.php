@extends('layouts.app')
@section('links-content')
    <link href="{{ url('v3/src/assets/css/light/elements/search.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('v3/src/assets/css/dark/elements/search.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ url('v3/src/assets/css/light/forms/switches.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('v3/src/assets/css/dark/forms/switches.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/dark/users/user-profile.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/light/elements/custom-pagination.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/dark/elements/custom-pagination.css')}}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{url('filepond-master/dist/filepond.css')}}" rel="stylesheet" type="text/css" /> --}}

@endsection
@section('content')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <h2>Servicios</h2>
                </nav>
            </div>
            <div class="row layout-top-spacing">
                <div class="col-lg-12">
                    @livewire("servicios")
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts-content')
    {{-- <script src="{{ url("filepond-master/dist/filepond.js") }}"></script> --}}
    <script src="{{ url("v3/src/plugins/src/highlight/highlight.pack.js") }}"></script>
    <script src="{{ url('v3/src/assets/js/elements/custom-search.js') }}"></script>

    {{-- <script>
        const inputElement = document.querySelector('input[type="file"]');
        const token = document.querySelector('input[name="_token"]');
        const pond = FilePond.create(inputElement);
        FilePond.setOptions({
            labelIdle: "Arrastra y suelta aqui o... <a class='btn btn-primary'>Buscar...</a>",
            server: {
                url: "/administracion/servicios/uploadFile",
                headers: {
                    'X-CSRF-TOKEN': token.value
                }
            }
        })
    </script> --}}
@endsection


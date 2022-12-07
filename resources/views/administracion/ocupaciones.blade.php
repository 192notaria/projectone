@extends('layouts.app')
@section('links-content')
    <link href="{{ url('v3/src/assets/css/light/elements/search.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('v3/src/assets/css/dark/elements/search.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('v3/src/assets/css/light/forms/switches.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('v3/src/assets/css/dark/forms/switches.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/dark/users/user-profile.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/light/elements/custom-pagination.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/dark/elements/custom-pagination.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <h2>Ocupaciones</h2>
                </nav>
            </div>
            <div class="row layout-top-spacing">
                <div class="col-lg-12">
                    @livewire("ocupaciones")
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts-content')
    <script src="{{ url("v3/src/plugins/src/highlight/highlight.pack.js") }}"></script>
    <script src="{{ url('v3/src/assets/js/elements/custom-search.js') }}"></script>
@endsection


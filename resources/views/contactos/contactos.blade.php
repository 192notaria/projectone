@extends('layouts.app')
@section('links-content')

    <link href="{{ url('v3/src/assets/css/light/forms/switches.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('v3/src/assets/css/dark/forms/switches.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/dark/users/user-profile.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/light/elements/custom-pagination.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/dark/elements/custom-pagination.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/dark/apps/contacts.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/light/apps/contacts.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            @livewire("contactos")
        </div>
    </div>
@endsection

@section('scripts-content')
    {{-- <script src="{{ url("v3/src/plugins/src/highlight/highlight.pack.js") }}"></script> --}}



@endsection


@extends('layouts.app')
@section('links-content')
    {{-- <link href="{{ url('v3/src/assets/css/light/elements/search.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('v3/src/assets/css/dark/elements/search.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="{{url('v3/src/plugins/src/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/plugins/css/light/fullcalendar/custom-fullcalendar.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/plugins/css/dark/fullcalendar/custom-fullcalendar.css')}}" rel="stylesheet" type="text/css" />


@endsection
@section('content')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="layout-top-spacing">
                @livewire("guardias")
            </div>
        </div>
    </div>
@endsection

@section('scripts-content')
    <script src="{{url('v3/src/plugins/src/fullcalendar/fullcalendar.min.js')}}"></script>
    <script src="{{url('v3/src/plugins/src/fullcalendar/custom-fullcalendar.js')}}"></script>
@endsection


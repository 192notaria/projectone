@extends('layouts.app')
@section('links-content')
    <link href="{{ url('v3/src/assets/css/light/elements/search.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('v3/src/assets/css/dark/elements/search.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ url('v3/src/assets/css/light/forms/switches.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('v3/src/assets/css/dark/forms/switches.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/dark/users/user-profile.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/light/elements/custom-pagination.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/dark/elements/custom-pagination.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/light/components/timeline.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/dark/components/timeline.css')}}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{url('filepond-master/dist/filepond.css')}}" rel="stylesheet" type="text/css" /> --}}
    {{-- <link href="{{url('v3/src/assets/css/light/scrollspyNav.css')}}" rel="stylesheet" type="text/css" /> --}}
    {{-- <link href="{{url('v3/src/assets/css/dark/scrollspyNav.css')}}" rel="stylesheet" type="text/css" /> --}}
    <link href="{{url('v3/src/assets/css/dark/components/list-group.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('v3/src/assets/css/light/components/list-group.css')}}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{url('v3/src/plugins/src/filepond/filepond.min.css')}}">
    <link rel="stylesheet" href="{{url('v3/src/plugins/src/filepond/FilePondPluginImagePreview.min.css')}}">
    <link href="{{url('v3/src/plugins/css/light/filepond/custom-filepond.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/dark/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/plugins/css/dark/filepond/custom-filepond.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <h2>Actos</h2>
                </nav>
            </div>
            <div class="row layout-top-spacing">
                <div class="col-lg-12">
                    @livewire("proyectos")
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts-content')
<script src="{{ url("v3/src/plugins/src/highlight/highlight.pack.js") }}"></script>
<script src="{{ url('v3/src/assets/js/elements/custom-search.js') }}"></script>
{{-- <script src="{{url('v3/src/assets/js/scrollspyNav.js')}}"></script> --}}

<script src="{{url('v3/src/plugins/src/filepond/filepond.min.js')}}"></script>
<script src="{{url('v3/src/plugins/src/filepond/FilePondPluginFileValidateType.min.js')}}"></script>
<script src="{{url('v3/src/plugins/src/filepond/FilePondPluginImageExifOrientation.min.js')}}"></script>
<script src="{{url('v3/src/plugins/src/filepond/FilePondPluginImagePreview.min.js')}}"></script>
<script src="{{url('v3/src/plugins/src/filepond/FilePondPluginImageCrop.min.js')}}"></script>
<script src="{{url('v3/src/plugins/src/filepond/FilePondPluginImageResize.min.js')}}"></script>
<script src="{{url('v3/src/plugins/src/filepond/FilePondPluginImageTransform.min.js')}}"></script>
<script src="{{url('v3/src/plugins/src/filepond/filepondPluginFileValidateSize.min.js')}}"></script>
<script src="{{url('v3/src/plugins/src/filepond/custom-filepond.js')}}"></script>

{{-- <script src="{{ url("filepond-master/dist/filepond.js") }}"></script> --}}
{{-- <script>
    document.addEventListener("DOMContentLoaded", () => {
        setTimeout(() => {
            const inputElement = document.querySelector('input[type="file"]');
            const token = document.querySelector('input[name="_token"]');
            const pond = FilePond.create(inputElement);

        }, 2000);
    })
</script> --}}
@endsection


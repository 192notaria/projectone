@extends('layouts.app')
@section('links-content')
    <link href="{{ url('v3/src/assets/css/light/components/list-group.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('v3/src/assets/css/light/users/user-profile.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('v3/src/assets/css/dark/components/list-group.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('v3/src/assets/css/dark/users/user-profile.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{url('v3/src/plugins/src/filepond/filepond.min.css')}}">
    <link rel="stylesheet" href="{{url('v3/src/plugins/src/filepond/FilePondPluginImagePreview.min.css')}}">
    <link href="{{url('v3/src/plugins/css/light/filepond/custom-filepond.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/dark/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/plugins/css/dark/filepond/custom-filepond.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @livewire('user-profile')
@endsection

@section('scripts-content')
    <script src="{{url('v3/src/plugins/src/filepond/filepond.min.js')}}"></script>
    <script src="{{url('v3/src/plugins/src/filepond/FilePondPluginFileValidateType.min.js')}}"></script>
    <script src="{{url('v3/src/plugins/src/filepond/FilePondPluginImageExifOrientation.min.js')}}"></script>
    <script src="{{url('v3/src/plugins/src/filepond/FilePondPluginImagePreview.min.js')}}"></script>
    <script src="{{url('v3/src/plugins/src/filepond/FilePondPluginImageCrop.min.js')}}"></script>
    <script src="{{url('v3/src/plugins/src/filepond/FilePondPluginImageResize.min.js')}}"></script>
    <script src="{{url('v3/src/plugins/src/filepond/FilePondPluginImageTransform.min.js')}}"></script>
    <script src="{{url('v3/src/plugins/src/filepond/filepondPluginFileValidateSize.min.js')}}"></script>
    <script src="{{url('v3/src/plugins/src/filepond/custom-filepond.js')}}"></script>
<script>
    FilePond.create(
        document.querySelector('.filepond'),{
            instantUpload: false,
            // allowProcess: false,
            labelIdle: `<span class="no-image-placeholder"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></span> <p class="drag-para">Drag & Drop your picture or <span class="filepond--label-action" tabindex="0">Browse</span></p>`,
            imagePreviewHeight: 170,
            imageCropAspectRatio: '1:1',
            imageResizeTargetWidth: 200,
            imageResizeTargetHeight: 200,
            stylePanelLayout: 'compact circle',
            styleLoadIndicatorPosition: 'center bottom',
            styleProgressIndicatorPosition: 'right bottom',
            styleButtonRemoveItemPosition: 'left bottom',
            styleButtonProcessItemPosition: 'right bottom',
            files: [
                {
                    source: '{{url(auth()->user()->user_image)}}',
                    options: {
                        type: 'image/png',
                    },
                },
            ],
        },
    );

    FilePond.setOptions({
        server:{
            url: '/administracion/servicios/uploadFile/{{auth()->user()->id}}',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            process:{
                onload: (response) => {
                    console.log(response)
                }, // saving response in global array
            }
        }
    });
</script>
@endsection


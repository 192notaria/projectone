<li class="nav-item dropdown notification-dropdown">
    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="favoriteContacsDropdown" aria-haspopup="true" aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
        <span id="notificationsSpan"
        {{-- class="@if(count($notificationsData) > 0) badge badge-success @endif" --}}
        ></span>
    </a>
    <div class="dropdown-menu position-absolute" id="favoriteContacsDropdownDiv" aria-labelledby="notificationDropdown">
        <div class="drodpown-title message">
            <h6 class="d-flex justify-content-between">
                <span class="align-self-center">Contactos Favoritos <i class="fa-solid fa-star"></i></span>
            </h6>
        </div>
        <div class="notification-scroll" id="notifications-Content">
            @foreach ($favorites as $favorite)
                <div class="dropdown-item">
                    <div class="media server-log">
                        <img src="{{url($favorite->usuario->user_image)}}" class="img-fluid me-2" alt="avatar">
                        <div class="media-body">
                            <div class="data-info">
                                <h6 class="">{{$favorite->usuario->name}} {{$favorite->usuario->apaterno}}</h6>
                            </div>
                            <button type="button"
                                @if (!$recording)
                                    wire:click='startRecording({{$favorite->id}})'
                                    class="btn btn-primary"
                                @endif
                                @if ($recording && $interphoneUser != $favorite->id)
                                    class="btn btn-primary"
                                    disabled
                                @endif
                                @if ($interphoneUser == $favorite->id && $recording)
                                    wire:click='stopRecording'
                                    class="btn btn-danger"
                                @endif
                                >

                                @if (!$recording)
                                    <i class="fa-solid fa-microphone"></i>
                                @endif
                                @if ($recording && $interphoneUser != $favorite->id)
                                    <i class="fa-solid fa-microphone"></i>
                                @endif
                                @if ($interphoneUser == $favorite->id && $recording)
                                    <i class="fa-solid fa-circle-stop"></i>
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script src="{{ url('v3/recorder/recorder.js') }}"></script>
    <script>
        var userid;
        var gumStream;
        var rec;
        var input;

        var AudioContext = window.AudioContext || window.webkitAudioContext;
        var audioContext
        window.addEventListener('start-interphone-favorite', event => {
            startRecording()
            console.log(window.location.hostname)
        })

        window.addEventListener('stop-interphone-favorite', event => {
            userid = event.detail
            stopRecording()
        })

        function startRecording(){
            var constraints = { audio: true, video:true }
            navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
                audioContext = new AudioContext();
                gumStream = stream
                input = audioContext.createMediaStreamSource(stream)
                rec = new Recorder(input,{numChannels:1})
                rec.record()
            }).catch(function(err) {
                // recordButton.disabled = false;
                // stopButton.disabled = true;
                // pauseButton.disabled = true
            });
        }


        function stopRecording() {
            rec.stop();
            // gumStream.getAudioTracks()[0].stop();
            gumStream.getAudioTracks().forEach(track => {
                track.stop();
            });
            rec.exportWAV(createDownloadLink);
        }

        function createDownloadLink(blob) {
            var url = URL.createObjectURL(blob);
            var filename = new Date().toISOString();
            var fd =new FormData();

            fd.append("audio_data", blob, filename);
            fd.append("_token", "{{csrf_token()}}");
            fd.append("user_id", userid);

            $.ajax({
                url: "https://192.168.68.157/intefone",
                type: 'POST',
                data: fd,
                success: function (data) {
                    console.log(data)
                },
                error: function(error){
                    console.log(error)
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    </script>
</li>

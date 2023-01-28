<li class="nav-item dropdown notification-dropdown">
    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="IntercomunicadorDropdown" aria-haspopup="true" aria-expanded="false">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-play-circle"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg>
        <span id="notificationsSpan" class="@if(count($intercomunicadores) > 0) badge badge-success @endif"></span>
    </a>
    <div class="dropdown-menu position-absolute" id="IntercomunicadorDropdownDiv" aria-labelledby="notificationDropdown">
        <div class="drodpown-title message">
            <h6 class="d-flex justify-content-between">
                <span class="align-self-center">Intercomunicador
                <i class="fa-solid fa-voicemail"></i>
            </h6>
        </div>
        <style>
            #intercomunicador-Content{
                max-height: 300px;
                overflow: scroll;
            }
        </style>
        <div class="notification-scroll" id="intercomunicador-Content">
            @foreach ($intercomunicadores as $intercomunicador)
                <div class="dropdown-item">
                    <div class="media server-log">
                        <img src="{{url($intercomunicador->usuarioTo->user_image)}}" class="img-fluid me-2" alt="avatar">
                        <div class="media-body">
                            <div class="data-info">
                                <h6 class="">{{$intercomunicador->usuarioTo->name}} {{$intercomunicador->usuarioTo->apaterno}}</h6>
                            </div>
                        </div>
                        <audio src="{{url($intercomunicador->path)}}" id="track" controls></audio>
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
                url: "192.168.68.157/intefone",
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

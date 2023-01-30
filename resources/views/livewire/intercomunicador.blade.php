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
                <div class="dropdown-item mb-3">
                    <div class="media server-log">
                        <img src="{{url($intercomunicador->usuarioTo->user_image)}}" class="img-fluid me-2" alt="avatar">
                        <div class="media-body">
                            <div class="data-info">
                                <h6>{{$intercomunicador->usuarioFrom->name}} {{$intercomunicador->usuarioFrom->apaterno}}</h6>
                                <p>{{$intercomunicador->created_at}}</p>
                            </div>
                        </div>
                        {{-- <audio src="{{url($intercomunicador->path)}}" id="track" controls></audio> --}}
                    </div>
                    <audio preload="auto" controls>
                        <source src="{{url($intercomunicador->path)}}">
                    </audio>
                </div>
            @endforeach
        </div>
    </div>
    <script src="{{url('js/jquery.js')}}"></script>

    <script>
        	$(function() {
				$('audio').audioPlayer();
			});
    </script>
</li>

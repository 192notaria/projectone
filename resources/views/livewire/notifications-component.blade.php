    <li class="nav-item dropdown notification-dropdown">
        <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" aria-haspopup="true" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
            <span id="notificationsSpan" class=" @if(count($notificationsData) > 0) badge badge-success @endif "></span>
        </a>
        <div class="dropdown-menu position-absolute" id="notificationDropdownDiv" aria-labelledby="notificationDropdown">
            <div class="drodpown-title message">
                <h6 class="d-flex justify-content-between">
                    <span class="align-self-center">Notificaciones</span>
                    <a style="cursor: pointer;" wire:click='deleteAllNotification({{auth()->user()->id}})'>
                        <span class="badge badge-primary">Limpiar</span>
                    </a>
                </h6>
            </div>
            <div class="notification-scroll" id="notifications-Content">
                @if (count($notificationsData) > 0)
                    @foreach ($notificationsData as $notification)
                        <div class="dropdown-item">
                            <div class="media file-upload">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                <div class="media-body">
                                    <div class="data-info">
                                        <h6 class="">{{ $notification->name }}</h6>
                                        <p style="font-weight: bold" class="">{{ $notification->body }}</p>
                                        {{-- <p>
                                            {{ $notification->created_at->diffForHumans(now()) }}
                                        </p> --}}
                                    </div>
                                    <a wire:click='deleteNotification({{$notification->id}})'>
                                        <div class="icon-status">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="dropdown-item text-center" id="no-notifications">
                        <p>Sin notificaciones</p>
                    </div>
                @endif
            </div>
        </div>
    </li>

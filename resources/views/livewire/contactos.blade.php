<div class="row layout-spacing layout-top-spacing" id="cancel-row">
    <div class="col-lg-12">
        <div class="widget-content searchable-container grid">

            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-5 col-sm-7 filtered-list-search layout-spacing align-self-center">
                    <form class="form-inline my-2 my-lg-0">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" class="form-control product-search" id="input-search" placeholder="Search Contacts...">
                        </div>
                    </form>
                </div>

                <div class="col-xl-8 col-lg-7 col-md-7 col-sm-5 text-sm-right text-center layout-spacing align-self-center">
                    <div class="d-flex justify-content-sm-end justify-content-center">
                        {{-- <svg id="btn-add-contact" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg> --}}

                        <div class="switch align-self-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list view-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid view-grid active-view"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title add-title" id="addContactModalTitleLabel1">Add Contact</h5>
                                    <h5 class="modal-title edit-title" id="addContactModalTitleLabel2" style="display: none;">Edit Contact</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                      <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <div class="add-contact-box">
                                        <div class="add-contact-content">
                                            <form id="addContactModalTitle">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <div class="contact-name">
                                                            <input type="text" id="c-name" class="form-control" placeholder="Name">
                                                            <span class="validation-text"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="contact-email">
                                                            <input type="text" id="c-email" class="form-control" placeholder="Email">
                                                            <span class="validation-text"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <div class="contact-occupation">
                                                            <input type="text" id="c-occupation" class="form-control" placeholder="Occupation">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <div class="contact-phone">
                                                            <input type="text" id="c-phone" class="form-control" placeholder="Phone">
                                                            <span class="validation-text"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="contact-location">
                                                            <input type="text" id="c-location" class="form-control" placeholder="Location">
                                                        </div>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button id="btn-edit" class="float-left btn btn-success">Save</button>
                                    <button class="btn" data-bs-dismiss="modal"> <i class="flaticon-delete-1"></i> Discard</button>
                                    <button id="btn-add" class="btn btn-primary">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="searchable-items grid">
                <div class="items items-header-section">
                    <div class="item-content">
                        <div class="d-inline-flex">
                            {{-- <div class="n-chk align-self-center text-center">
                                <div class="form-check form-check-primary me-0 mb-0">
                                    <input class="form-check-input inbox-chkbox" id="contact-check-all" type="checkbox">
                                </div>
                            </div> --}}
                            <h4>Name</h4>
                        </div>
                        <div class="user-email">
                            <h4>Email</h4>
                        </div>
                        {{-- <div class="user-location">
                            <h4 style="margin-left: 0;">Location</h4>
                        </div> --}}
                        <div class="user-phone">
                            <h4>Phone</h4>
                        </div>
                        <div class="action-btn">
                            <h4>Intercomunicador</h4>
                        </div>
                    </div>
                </div>
                @foreach ($contacts as $contact)
                    @if ($contact->email != "admin@admin.com")
                        <div class="items">
                            <div class="item-content">
                                <div class="user-profile">
                                    {{-- <div class="n-chk align-self-center text-center">
                                        <div class="form-check form-check-primary me-0 mb-0">
                                            <input class="form-check-input inbox-chkbox contact-chkbox" type="checkbox">
                                        </div>
                                    </div> --}}
                                    <img style="max-width: 80px;" src="{{url($contact->user_image)}}" alt="avatar">
                                    <div class="user-meta-info">
                                        <p class="user-name" data-name="Alan Green">{{$contact->name}} {{$contact->apaterno}}</p>
                                        <p class="user-work" data-occupation="Web Developer">{{$contact->getOcupacion->nombre}}</p>
                                    </div>
                                </div>
                                <div class="user-email">
                                    <p class="info-title">Email: </p>
                                    <p class="usr-email-addr" data-email="alan@mail.com">{{$contact->email}}</p>
                                </div>
                                <div class="user-phone">
                                    <p class="info-title">Phone: </p>
                                    <p class="usr-ph-no">{{$contact->telefono}}</p>
                                </div>
                                <div class="action-btn">
                                    <button
                                        @if (!$recording)
                                            wire:click='startRecording({{$contact->id}})'
                                            class="btn btn-primary"
                                        @endif
                                        @if ($recording && $interphoneUser != $contact->id)
                                            class="btn btn-primary"
                                            disabled
                                        @endif
                                        @if ($interphoneUser == $contact->id && $recording)
                                            wire:click='stopRecording'
                                            class="btn btn-danger"
                                        @endif
                                        >

                                        @if (!$recording)
                                            <i class="fa-solid fa-microphone"></i>
                                        @endif
                                        @if ($recording && $interphoneUser != $contact->id)
                                            <i class="fa-solid fa-microphone"></i>
                                        @endif
                                        @if ($interphoneUser == $contact->id && $recording)
                                            <i class="fa-solid fa-circle-stop"></i>
                                        @endif
                                    </button>
                                    @if ($contact->favorites)
                                        <button class="btn btn-success" wire:click='removeFavorites({{$contact->id}})'>
                                            <i class="fa-solid fa-star"></i>
                                        </button>
                                    @endif
                                    @if (!$contact->favorites)
                                        <button class="btn btn-primary" wire:click='addFavorites({{$contact->id}})'>
                                            <i class="fa-regular fa-star"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

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
        window.addEventListener('start-interphone', event => {
            startRecording()
        })

        window.addEventListener('stop-interphone', event => {
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
                url: "https.157/intefone",
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
</div>

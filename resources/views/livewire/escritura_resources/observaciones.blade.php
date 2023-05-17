<div class="row">
    @if ($escritura_activa)
        @forelse ($escritura_activa->observaciones_data as $observacion)
            <div class="col-lg-3 mb-2 mt-2">
                <div class="card style-5 bg-primary mb-md-0 mb-4">
                    <div class="card-top-content">
                        <div class="avatar avatar-md">
                            <img alt="avatar" src="{{url($observacion->usuarios->user_image)}}" class="rounded-circle">
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <h5 class="card-title mb-2">{{$observacion->usuarios->name}} {{$observacion->usuarios->apaterno}} {{$observacion->usuarios->amaterno}}</h5>
                            <p class="card-text">{{$observacion->comentarios}}</p>
                            <span class="text-white fw-bold mt-2 d-inline-block">{{$observacion->created_at}}</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <h5>Sin observaciones</h5>
        @endforelse
    @endif
</div>

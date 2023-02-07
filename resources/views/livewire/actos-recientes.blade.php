<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
    <div class="widget widget-table-two">
        <div class="widget-heading">
            <h5 class="">Actos recientes</h5>
        </div>

        <div class="widget-content">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><div class="th-content">Acto</div></th>
                            <th><div class="th-content">Cliente</div></th>
                            <th><div class="th-content">Abogado</div></th>
                            <th><div class="th-content th-heading">Escritura</div></th>
                            <th><div class="th-content">%Avance</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($actos as $acto)
                            <tr>
                                <td>
                                    <div class="td-content product-brand text-primary">
                                        {{$acto->servicio->nombre}}
                                    <p class="bs-popover" data-bs-container="body" data-bs-trigger="hover" data-bs-content="{{$acto->created_at}}">{{$acto->created_at->diffForHumans(now())}}</p>
                                    </div>
                                </td>
                                <td><div class="td-content customer-name"><span>{{$acto->cliente->nombre}} {{$acto->cliente->apaterno}}</span></div></td>
                                <td>
                                    <div class="td-content customer-name">
                                        <img src="{{url($acto->abogado->user_image)}}" alt="avatar">
                                        <span>{{$acto->abogado->name}} {{$acto->abogado->apaterno}}</span>
                                    </div>
                                </td>
                                <td><div class="td-content pricing"><span class="">{{$acto->numero_escritura}}</span></div></td>
                                {{-- @php
                                    $procesosCount = count($acto->porcentaje);
                                    $newArray = [];
                                    foreach ($acto->avanceCount as $data){
                                        array_push($newArray, $data->proceso_id);
                                    }
                                    $data = array_unique($newArray);
                                    $porcentaje = round(count($data) * 100 / $procesosCount);
                                @endphp --}}
                                <td>
                                    <div class="td-content">
                                        <span class="badge badge-success">
                                            %
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

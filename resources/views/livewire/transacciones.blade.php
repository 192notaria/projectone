<div class="widget-content">
    @foreach ($transacciones as $tran)
        <div class="transactions-list
        @if ($tran->fecha_egreso)
            t-danger
        @endif
        @if ($tran->fecha)
            t-info
        @endif
        ">
            <div class="t-item">
                <div class="t-company-name">
                    <div class="t-icon">
                        <div class="avatar">
                            <span class="avatar-title">
                                @if ($tran->fecha_egreso)
                                    <i class="fa-solid fa-file-invoice-dollar"></i>
                                @endif
                                @if ($tran->fecha)
                                    <i class="fa-solid fa-money-bill-1-wave"></i>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="t-name">
                        <h4>
                            @if ($tran->fecha_egreso)
                                {{$tran->proyecto->cliente->nombre ?? ""}} {{$tran->proyecto->cliente->apaterno ?? ""}} {{$tran->proyecto->cliente->amaterno ?? ""}} - {{$tran->proyecto->servicio->nombre ?? ""}}({{$tran->proyecto->numero_escritura ?? ""}})
                            @endif
                            @if ($tran->fecha)
                                {{$tran->proyecto->cliente->nombre ?? "as"}} {{$tran->proyecto->cliente->apaterno ?? ""}} {{$tran->proyecto->cliente->amaterno ?? ""}} - {{$tran->proyecto->servicio->nombre ?? ""}}({{$tran->proyecto->numero_escritura ?? ""}})
                            @endif
                        </h4>
                        <p class="meta-date">{{$tran->created_at}}</p>
                    </div>
                </div>
                <div class="t-rate rate-inc">
                    <p>
                        @if ($tran->fecha_egreso)
                            <span class="text-danger">
                                -${{$tran->monto}}
                            </span>
                        @endif
                        @if ($tran->fecha)
                            <span class="text-success">
                                +${{$tran->monto}}
                            </span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    @endforeach
</div>

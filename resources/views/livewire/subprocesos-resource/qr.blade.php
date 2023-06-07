<div class="row">
    <div class="col-lg-12">
        <div class="visible-print text-center">
            {{-- <img src="{!!QrCode::format('png')->generate('Embed me into an e-mail!'), 'QrCode.png', 'image/png'!!}"> --}}
            @if ($proyecto_activo)
                <img style="width: 500px; height: 500px;" src="data:image/png;base64, {!! base64_encode(QrCode::size(400)->format('png')->merge(url("v3/src/assets/img/notaria192logo2.png"), .3, true)->size(300)->style('round')->generate($proyecto_activo->qr)) !!} ">
            @endif
        </div>
    </div>
</div>

<div class="row gy-3 gx-3">
    @if ($proyecto_activo)
        <div class="col-lg-6">
            <div class="visible-print text-center">
                {{-- <img src="{!!QrCode::format('png')->generate('Embed me into an e-mail!'), 'QrCode.png', 'image/png'!!}"> --}}
                <img style="width: 500px; height: 500px;" src="data:image/png;base64, {!! base64_encode(QrCode::size(400)->format('png')->merge(url("v3/src/assets/img/192logocoloreado.png"), .4, true)->size(300)->style('round')->generate($proyecto_activo->qr)) !!} ">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="visible-print text-center">
                {{-- <img src="{!!QrCode::format('png')->generate('Embed me into an e-mail!'), 'QrCode.png', 'image/png'!!}"> --}}
                <img style="width: 500px; height: 500px;" src="data:image/png;base64, {!! base64_encode(QrCode::size(400)->format('png')->merge(url("v3/src/assets/img/rounded-logo-notaria-coloreado.png"), .4, true)->size(300)->style('round')->generate($proyecto_activo->qr)) !!} ">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="visible-print text-center">
                {{-- <img src="{!!QrCode::format('png')->generate('Embed me into an e-mail!'), 'QrCode.png', 'image/png'!!}"> --}}
                <img style="width: 500px; height: 500px;" src="data:image/png;base64, {!! base64_encode(QrCode::size(400)->format('png')->merge(url("v3/src/assets/img/notarialogocoloreado.png"), 1, true)->size(300)->style('round')->generate($proyecto_activo->qr)) !!} ">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="visible-print text-center">
                {{-- <img src="{!!QrCode::format('png')->generate('Embed me into an e-mail!'), 'QrCode.png', 'image/png'!!}"> --}}
                <img style="width: 500px; height: 500px;" src="data:image/png;base64, {!! base64_encode(QrCode::size(400)->format('png')->merge(url("v3/src/assets/img/rounded-logo-notaria.png"), .4, true)->size(300)->style('round')->generate($proyecto_activo->qr)) !!} ">
            </div>
        </div>
    @endif
</div>

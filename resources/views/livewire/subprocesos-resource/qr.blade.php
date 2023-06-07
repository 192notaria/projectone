<div class="row">
    <div class="col-lg-12">
        <div class="visible-print text-center">
            {{-- <img src="{!!QrCode::format('png')->generate('Embed me into an e-mail!'), 'QrCode.png', 'image/png'!!}"> --}}
            @if ($proyecto_activo)
                <img style="width: 200px; height: 200px;" src="data:image/png;base64, {!! base64_encode(QrCode::size(400)->format('png')->merge('https://upload.wikimedia.org/wikipedia/commons/thumb/f/f4/BMW_logo_%28gray%29.svg/2048px-BMW_logo_%28gray%29.svg.png', .3, true)->size(100)->style('round')->generate($proyecto_activo->qr)) !!} ">
            @endif
        </div>
    </div>
</div>

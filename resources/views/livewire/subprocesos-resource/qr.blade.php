<div class="row gy-3 gx-3">
    @if ($proyecto_activo)
        <div class="col-lg-6">
            <div class="visible-print text-center">
                <img style="width: 200px; height: 200px;" src="data:image/png;base64, {!! base64_encode(QrCode::size(400)->format('png')->merge(url("v3/src/assets/img/notarialogocoloreado.png"), 1, true)->size(300)->style('round')->generate($proyecto_activo->qr)) !!} ">
            </div>
        </div>
    @endif
</div>

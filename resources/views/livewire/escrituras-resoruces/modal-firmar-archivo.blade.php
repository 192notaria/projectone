<div wire:ignore.self class="modal fade modal-archivar-escritura-firma"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Archivar</h5>
            </div>
            <div class="modal-body">
                <div class="row gx-3 gy-3">
                    <div class="col-lg-12">
                        <label for="">Usuario que recibe</label>
                        <select class="form-select" id="">
                            <option value="">Seleccionar...</option>
                            @foreach ($usuarios_anticipos as $usuario)
                                <option value="{{$usuario->name}}">{{$usuario->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-12 text-center">
                        <canvas class="border border-primary" width="400" height="200" id="canvas"></canvas>
                    </div>
                    <div class="col-lg-12 text-center">
                        <button class="btn btn-primary" id="btnLimpiar">Limpiar</button>
                        <button class="btn btn-primary" id="btnGuardar">Guardar</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="text-danger me-3" data-bs-dismiss="modal">Cancelar</a>
                <button wire:click='' class="btn btn-outline-success">Guardar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .snackbar-container{
        z-index: 100000;
    }
</style>

<script>
    window.addEventListener('abrir-modal-archivar-escritura-firma', event => {
        $(".modal-archivar-escritura-firma").modal("show")
    })

    window.addEventListener('cerrar-modal-archivar-escritura-firma', event => {
        $(".modal-archivar-escritura-firma").modal("hide")
    })

    const $canvas = document.querySelector("#canvas"),
        $btnGuardar = document.querySelector("#btnGuardar"),
        $btnLimpiar = document.querySelector("#btnLimpiar");
    const contexto = $canvas.getContext("2d");
    const COLOR_PINCEL = "black";
    const COLOR_FONDO = "white";
    const GROSOR = 2;
    let xAnterior = 0, yAnterior = 0, xActual = 0, yActual = 0;
    const obtenerXReal = (clientX) => clientX - $canvas.getBoundingClientRect().left;
    const obtenerYReal = (clientY) => clientY - $canvas.getBoundingClientRect().top;
    let haComenzadoDibujo = false;

    const limpiarCanvas = () => {
        contexto.fillStyle = COLOR_FONDO;
        contexto.fillRect(0, 0, $canvas.width, $canvas.height);
    };

    limpiarCanvas();
    $btnLimpiar.onclick = limpiarCanvas;
// Escuchar clic del botón para descargar el canvas
// $btnDescargar.onclick = () => {
//     const enlace = document.createElement('a');
//     // El título
//     enlace.download = "Firma.png";
//     // Convertir la imagen a Base64 y ponerlo en el enlace
//     enlace.href = $canvas.toDataURL();
//     // Hacer click en él
//     enlace.click();
// };
    $btnGuardar.onclick = () => {
        var firma = $canvas.toDataURL();
        registrar_firma(firma);
    };

window.obtenerImagen = () => {
    return $canvas.toDataURL();
};

// $btnGenerarDocumento.onclick = () => {
//     window.open("documento.html");
// };

const onClicOToqueIniciado = evento => {
    // En este evento solo se ha iniciado el clic, así que dibujamos un punto
    xAnterior = xActual;
    yAnterior = yActual;
    xActual = obtenerXReal(evento.clientX);
    yActual = obtenerYReal(evento.clientY);
    contexto.beginPath();
    contexto.fillStyle = COLOR_PINCEL;
    contexto.fillRect(xActual, yActual, GROSOR, GROSOR);
    contexto.closePath();
    // Y establecemos la bandera
    haComenzadoDibujo = true;
}

const onMouseODedoMovido = evento => {
    evento.preventDefault(); // Prevenir scroll en móviles
    if (!haComenzadoDibujo) {
        return;
    }
    // El mouse se está moviendo y el usuario está presionando el botón, así que dibujamos todo
    let target = evento;
    if (evento.type.includes("touch")) {
        target = evento.touches[0];
    }
    xAnterior = xActual;
    yAnterior = yActual;
    xActual = obtenerXReal(target.clientX);
    yActual = obtenerYReal(target.clientY);
    contexto.beginPath();
    contexto.moveTo(xAnterior, yAnterior);
    contexto.lineTo(xActual, yActual);
    contexto.strokeStyle = COLOR_PINCEL;
    contexto.lineWidth = GROSOR;
    contexto.stroke();
    contexto.closePath();
}
const onMouseODedoLevantado = () => {
    haComenzadoDibujo = false;
};

// Lo demás tiene que ver con pintar sobre el canvas en los eventos del mouse
["mousedown", "touchstart"].forEach(nombreDeEvento => {
    $canvas.addEventListener(nombreDeEvento, onClicOToqueIniciado);
});

["mousemove", "touchmove"].forEach(nombreDeEvento => {
    $canvas.addEventListener(nombreDeEvento, onMouseODedoMovido);
});
["mouseup", "touchend"].forEach(nombreDeEvento => {
    $canvas.addEventListener(nombreDeEvento, onMouseODedoLevantado);
});

</script>

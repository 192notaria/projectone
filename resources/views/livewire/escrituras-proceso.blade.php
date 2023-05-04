<div class="card">
    <div class="card-header">
        <div style="display:flex; justify-content: space-between;">
            <div class="flex-item">
                @can("crear-proyectos")
                    <button wire:click='modalNuevoProyecto' style="height: 100%;" type="button" class="btn btn-outline-primary me-2">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                @endcan
            </div>
            <div class="flex-item" style="width: 100%;">
                <div style="display:flex; justify-content:end;">
                    <input style="width: 90%;" wire:model="search" type="text" class="form-control me-2" placeholder="Buscar: Nombre, Apellido, Servicio...">
                    <select style="width: 10%;" wire:model='cantidad_escrituras' class="form-select">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <style>
                .modal{
                    backdrop-filter: blur(5px);
                    background-color: #01223770;
                    -webkit-animation: fadeIn 0.3s;
                }

                @keyframes fadeIn {
                    0% { opacity: 0; }
                    100% { opacity: 1; }
                }

                @keyframes fadeOut {
                    0% { opacity: 1; }
                    100% { opacity: 0; }
                }

                .autocomplete {
                    position: relative;
                    display: inline-block;
                    width: 100%;
                }

                .autocomplete-items {
                    position: absolute;
                    border: 1px solid #d4d4d4;
                    border-bottom: none;
                    border-top: none;
                    z-index: 99;
                    top: 100%;
                    left: 0;
                    right: 0;
                }

                .autocomplete-items div {
                    padding: 10px;
                    cursor: pointer;
                    border-bottom: 1px solid #d4d4d4;
                    background-color: #ffff;
                }

                .autocomplete-items div:hover {
                    background-color: #e9e9e9;
                }

                .active_drag{
                    cursor: grabbing;
                }
            </style>
            <div class="col-lg-12 table-responsive drag" style="cursor: grab;">
                <table class="table table-striped" id="my_table">
                    <thead>
                        <tr>
                            <th scope="col">Cliente</th>
                            <th scope="col">Avance del Proyecto</th>
                            <th scope="col">Detalles del Proyecto</th>
                            <th scope="col">Fecha de creacion</th>
                            <th scope="col"></th>
                        </tr>
                        <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                    </thead>
                    <tbody>
                        @if (count($escrituras) > 0)
                            @foreach ($escrituras as $escritura)
                                @include('livewire.escrituras-resoruces.escrituras_tr_table')
                            @endforeach
                        @else
                            <td colspan="6" class="text-center">
                                Sin registros...
                            </td>
                        @endif
                    </tbody>
                </table>
                {{$escrituras->links('pagination-links')}}
            </div>
        </div>
    </div>
    @include("livewire.escrituras-resoruces.procesos_escritura")
    @include("livewire.escrituras-resoruces.modal-registrar-pago")
    @include("livewire.escrituras-resoruces.modal-borrar-proyecto")
    @include("livewire.escrituras-resoruces.modal-omitir-subproceso")
    @include("livewire.escrituras-resoruces.modal-registrar-costo")
    @include("livewire.escrituras-resoruces.modal-registrar-egresos")
    @include("livewire.escrituras-resoruces.modal-registrar-factura")
    @include("livewire.escrituras-resoruces.subir-documentos")
    @include("livewire.escrituras-resoruces.subir-recibos-pago")
    @include("livewire.escrituras-resoruces.modal-nuevo-proyecto")
    @include("livewire.escrituras-resoruces.modal-registrar-observacion")
    @include("livewire.escrituras-resoruces.modal-agregar-concepto-pago")

    <script>
        var mx = 0;

        $(".drag").on({
        mousemove: function(e) {
            var mx2 = e.pageX - this.offsetLeft;
            if(mx) this.scrollLeft = this.sx + mx - mx2;
        },

        mousedown: function(e) {
            this.sx = this.scrollLeft;
            mx = e.pageX - this.offsetLeft;
            document.getElementById("my_table").classList.add("active_drag")
        }
        });

        $(document).on("mouseup", function(){
            mx = 0;
            document.getElementById("my_table").classList.remove("active_drag")
        });

        window.addEventListener('success-event', event => {
            var myAudio= document.createElement('audio')
            myAudio.src = "{{ url("/v3/src/assets/audio/notification.mp3") }}"
            myAudio.play()

            Snackbar.show({
                text: event.detail,
                actionTextColor: '#fff',
                backgroundColor: '#00ab55',
                pos: 'top-center',
                duration: 5000,
                actionText: '<i class="fa-solid fa-circle-xmark"></i>'
            })
        })
    </script>

</div>

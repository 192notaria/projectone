<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between" wire:ignore>

            <h3>Poderes</h3>

            @can("crear-proyectos")
                <button wire:click='modalNuevoProyecto' wire:loading.attr='disabled' type="button" class="btn btn-outline-dark">
                    Nuevo poder <i class="fa-solid fa-user-plus"></i>
                </button>
            @endcan
        </div>
    </div>2222222
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-between">
                <div class="d-flex justify-content-start">
                    <select wire:model='cantidad_escrituras' class="form-select mb-3 me-1">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                       22 <option value="50">50</option>
                    </select>
                </div>
                <div>
                    {{-- <input wire:model="search" type="text" class="form-control" placeholder="Buscar..."> --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </span>
                        <input wire:model="search" type="text" class="form-control" placeholder="Busqueda rapida" aria-label="notification" aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>
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
                            <th scope="col"># Poder</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Abogado</th>
                            <th scope="col">Acto</th>
                            <th scope="col">Avance</th>
                            <th scope="col">Acciones</th>
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
            </div>
            {{$escrituras->links('pagination-links')}}
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
    @include("livewire.subprocesos-resource.modal-agregar-documentos")
    @include("livewire.escrituras-resoruces.modal-importar-recibo-pago")
    {{-- @include("livewire.modals-ignore-self.generar-qr") --}}

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

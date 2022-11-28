<div class="modal @if($modalAvance) fade show @endif" id="exampleModal" tabindex="-1" role="dialog"  @if($modalAvance) style="display: block;" @endif aria-labelledby="exampleModalLabel" @if($modalAvance) aria-modal="true" @endif  @if(!$modalAvance) aria-hidden="true" @endif>
    <div class="modal-dialog modal-lg" role="document">
        <form wire:submit.prevent="uploadDocument('{{$subprocesoActual->nombre}}')">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$tituloModal}}</h5>
                    <button wire:click='closeModal' type="button" class="btn btn-rounded btn-outline-danger" data-bs-dismiss="modal">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="">Subir documento</label>
                                @if ($inputFiles)
                                    <x-file-pond wire:model="documentFile" x-init="
                                    var Pond = FilePond.create($refs.input);
                                    this.addEventListener('pondReset', e => {
                                        Pond.removeFiles();
                                    });"></x-file-pond>
                                @endif
                                @error('documentFile') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click='closeModal' class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                    <button @if ($documentFile == "") disabled @endif type="submit" class="btn btn-outline-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
    @if ($inputFiles)
        <script>
            FilePond.registerPlugin(
                FilePondPluginImagePreview,
                FilePondPluginImageExifOrientation,
                FilePondPluginFileValidateSize,
                //FilePondPluginImageEdit
            );

            // FilePond.create(
            //     document.querySelector('.file-upload-multiple')
            // );

        </script>

    @endif
</div>

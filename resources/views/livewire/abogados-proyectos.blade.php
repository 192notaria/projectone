<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
    <div class="widget widget-table-three">
        <div class="widget-heading">
            <h5 class="">Trabajo de los abogados de la Notaria</h5>
        </div>
        <div class="widget-content">
            <div class="table-responsive">
                <table class="table table-scroll">
                    <thead>
                        <tr>
                            <th class="text-center"><div class="th-content">Abogado</div></th>
                            <th class="text-center"><div class="th-content th-heading">Actos realizados</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registros_abogados as $registro)
                            <tr>
                                <td>
                                    <div class="td-content product-name">
                                        <img onerror="this.src='/v3/src/assets/img/avatarprofile.png';" src="{{$registro->abogado->user_image}}" alt="product">
                                        <div class="align-self-center">
                                            <p class="prd-name">{{$registro->abogado->name}}</p>
                                            <p class="prd-category text-primary">{{$registro->abogado->apaterno}} {{$registro->abogado->amaterno}}</p>
                                        </div>
                                    </div>
                                </td>
                                <td><div class="td-content"><span class="pricing">{{$registro->cantidad}}</span></div></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

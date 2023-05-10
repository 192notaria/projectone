<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
    <div class="widget widget-table-three">

        <div class="widget-heading">
            <h5 class="">Actos mas requeridos</h5>
        </div>

        <div class="widget-content">
            <div class="table-responsive">
                <table class="table table-scroll">
                    <thead>
                        <tr>
                            <th><div class="th-content">Acto</div></th>
                            <th><div class="th-content th-heading">Cantidad</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($actos as $acto)
                            <tr>
                                <td>
                                    <div class="product-name">
                                        <div class="align-items-start">
                                            <p class="prd-category text-primary">{{$acto->servicio->nombre ?? ""}}</p>
                                        </div>
                                    </div>
                                </td>
                                <td><div class="td-content"><span class="pricing">{{$acto->cantidad}}</span></div></td>
                            </tr>
                        @endforeach




                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

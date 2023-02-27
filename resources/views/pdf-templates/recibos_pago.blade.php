<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Recibo de pago</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">

        <link type="text/css" rel="stylesheet" href="{{url('assets/css/bootstrap.min.css')}}">
        <link type="text/css" rel="stylesheet" href="{{url('assets/fonts/font-awesome/css/font-awesome.min.css')}}">

        <link rel="icon" type="image/x-icon" href="{{ url("v3/src/assets/img/rounded-logo-notaria.svg") }}"/>

        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900">

        <link type="text/css" rel="stylesheet" href="{{url('assets/css/style.css')}}">
    </head>
    <body>
        <div class="invoice-1 invoice-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="invoice-inner clearfix">
                            <div class="invoice-btn-section clearfix d-print-none">
                                <a style="width: 100%;" id="invoice_download_btn" class="btn btn-lg btn-download btn-theme">
                                    <i class="fa fa-download"></i> Descargar recibo
                                </a>
                            </div>
                            <div class="invoice-info clearfix" id="invoice_wrapper">
                                <div class="invoice-headar">
                                    <div class="row g-0">
                                        <div class="col-sm-6">
                                            <div class="invoice-logo">
                                                <div class="logo">
                                                    <img src="{{url('v3/src/assets/img/notaria192logo2.png')}}" alt="logo">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 invoice-id">
                                            <div class="info">
                                                <h1 class="color-white inv-header-1">Recibo</h1>
                                                <p class="color-white mb-1">
                                                    Número:
                                                    <span>{{$cobros->id}}</span>
                                                </p>
                                                <p class="color-white mb-0">
                                                    Fecha:
                                                    <span>
                                                        {{ \Carbon\Carbon::parse(strtotime(time()))->isoFormat('dddd D \d\e MMMM') }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="invoice-top">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="invoice-number mb-30">
                                                <h4 class="inv-title-1">Recibo de</h4>
                                                <h2 class="name mb-10">{{auth()->user()->name}} {{auth()->user()->apaterno}} {{auth()->user()->amaterno}}</h2>
                                                <p class="invo-addr-1">
                                                    Notaria 192 Michoacán <br/>
                                                    notaria192morelia@gmail.com <br/>
                                                    Perif. Paseo de la República, 3924-A Morelia Michoacán <br/>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="invoice-number mb-30">
                                                <div class="invoice-number-inner">
                                                    <h4 class="inv-title-1">Recibo para</h4>
                                                    <h2 class="name mb-10">JUAN PEREZ PEREZ</h2>
                                                    <p class="invo-addr-1">
                                                        Apexo Inc  <br/>
                                                        billing@apexo.com <br/>
                                                        Morelia Michoacan<br/>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="invoice-center">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-striped invoice-table">
                                            <thead class="bg-active">
                                                <tr class="tr">
                                                    <th>No.</th>
                                                    <th class="pl0 text-start">CONCEPTO</th>
                                                    <th class="text-center">COSTO</th>
                                                    <th class="text-center">IVA</th>
                                                    <th class="text-end">SUBTOTAL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $total = 0;
                                                @endphp
                                                @foreach ($cobros->cobrados as $key => $cobro)
                                                    <tr>
                                                        <td>
                                                            <div class="item-desc-1">
                                                                <span>{{$key + 1}}</span>
                                                            </div>
                                                        </td>
                                                        <td class="pl0">{{$cobro->costos_data->concepto_pago->descripcion}}</td>
                                                        <td class="text-center">${{number_format($cobro->costos_data->subtotal, 2)}}</td>
                                                        <td class="text-center">${{number_format($cobro->costos_data->subtotal * $cobro->costos_data->impuestos / 100, 2)}}</td>
                                                        <td class="text-end">${{number_format($cobro->monto, 2)}}</td>
                                                        @php
                                                            $total = $total + $cobro->monto;
                                                        @endphp
                                                    </tr>
                                                @endforeach
                                                {{-- <tr class="tr2">
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-center">SubTotal</td>
                                                    <td class="text-end">$710.99</td>
                                                </tr>
                                                <tr class="tr2">
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-center">Tax</td>
                                                    <td class="text-end">$85.99</td>
                                                </tr> --}}
                                                <tr class="tr2">
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-center f-w-600 active-color">TOTAL</td>
                                                    <td class="f-w-600 text-end active-color">{{number_format($total, 2)}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="invoice-bottom">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-8 col-sm-7 mt-5">
                                            <div class="mb-30 dear-client">
                                                <h3 class="inv-title-1">Firma y sello</h3>
                                                <p>
                                                    Not. Claudia Oropeza
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-4 col-sm-5">
                                            <div class="mb-30 payment-method">
                                                <h3 class="inv-title-1">Metodo de pago</h3>
                                                <ul class="payment-method-list-1 text-14">
                                                    <li><strong>Pago:</strong> Efectivo</li>
                                                    <li><strong>No. Cuenta:</strong> 00 123 647 840</li>
                                                    <li><strong>Titular:</strong> Jhon Doe</li>
                                                    <li><strong>Banco:</strong> BBVA</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="invoice-contact clearfix">
                                    <div class="row g-0">
                                        <div class="col-lg-9 col-md-11 col-sm-12">
                                            <div class="contact-info">
                                                <p>
                                                    <a href="#"><i class="fa fa-phone"></i> 4431234567</a>
                                                    <a href="#"><i class="fa fa-envelope"></i> notaria192morelia@gmail.com</a>
                                                </p>
                                                <p>
                                                    <a href="#" class="mr-0 d-none-580"><i class="fa fa-map-marker"></i> Perif. Paseo de la República, 3924-A Morelia Michoacán</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{url('assets/js/jquery.min.js')}}"></script>
        <script src="{{url('assets/js/jspdf.min.js')}}"></script>
        <script src="{{url('assets/js/html2canvas.js')}}"></script>
        <script src="{{url('assets/js/app.js')}}"></script>

    </body>
</html>

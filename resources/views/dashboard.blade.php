
@extends('layouts.app')
@section('links-content')

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="{{url('v3/src/plugins/src/apex/apexcharts.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('v3/src/assets/css/light/components/list-group.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('v3/src/assets/css/light/dashboard/dash_2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/dark/dashboard/dash_2.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{url('v3/src/assets/css/dark/widgets/modules-widgets.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('v3/src/assets/css/light/widgets/modules-widgets.css')}}">
    <link href="{{url('v3/src/assets/css/light/elements/popover.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/dark/elements/popover.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="layout-px-spacing">
    <div class="middle-content container-xxl p-0">
        <div class="row layout-top-spacing">
            <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-chart-one">
                    <div class="widget-heading">
                        <h5 class="">Ingresos Anuales</h5>
                        <div class="task-action">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="renvenue" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                </a>
                                <div class="dropdown-menu left" aria-labelledby="renvenue" style="will-change: transform;">
                                    <a class="dropdown-item" href="javascript:void(0);">Semanal</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Mensual</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Anual</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="widget-content">
                        <div id="revenueMonthly"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-chart-two">
                    <div class="widget-heading">
                        <h5 class="">Actos por categoria</h5>
                    </div>
                    <div class="widget-content">
                        <div id="chart-2" class=""></div>
                    </div>
                </div>
            </div>
            {{--

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget-two">
                    <div class="widget-content">
                        <div class="w-numeric-value">
                            <div class="w-content">
                                <span class="w-value">Actos diarios</span>
                                <span class="w-numeric-title">Ir a las columnas para mas detalles.</span>
                            </div>
                            <div class="w-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                            </div>
                        </div>
                        <div class="w-chart">
                            <div id="daily-sales"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-three">
                    <div class="widget-heading">
                        <h5 class="">Resumen</h5>

                        <div class="task-action">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="summary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                </a>

                                <div class="dropdown-menu left" aria-labelledby="summary" style="will-change: transform;">
                                    <a class="dropdown-item" href="javascript:void(0);">View Report</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Edit Report</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Mark as Done</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="widget-content">

                        <div class="order-summary">

                            <div class="summary-list">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                </div>
                                <div class="w-summary-details">

                                    <div class="w-summary-info">
                                        <h6>Ingresos</h6>
                                        <p class="summary-count">$92,600</p>
                                    </div>

                                    <div class="w-summary-stats">
                                        <div class="progress">
                                            <div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="summary-list">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7" y2="7"></line></svg>
                                </div>
                                <div class="w-summary-details">

                                    <div class="w-summary-info">
                                        <h6>Ganancias</h6>
                                        <p class="summary-count">$37,515</p>
                                    </div>

                                    <div class="w-summary-stats">
                                        <div class="progress">
                                            <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="summary-list">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                </div>
                                <div class="w-summary-details">

                                    <div class="w-summary-info">
                                        <h6>Gastos</h6>
                                        <p class="summary-count">$55,085</p>
                                    </div>

                                    <div class="w-summary-stats">
                                        <div class="progress">
                                            <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div> --}}

            {{-- <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                <div class="widget-one widget">
                    <div class="widget-content">
                        <div class="w-numeric-value">
                            <div class="w-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                            </div>
                            <div class="w-content">
                                <span class="w-value">3,192</span>
                                <span class="w-numeric-title">Actos totales</span>
                            </div>
                        </div>
                        <div class="w-chart">
                            <div id="total-orders"></div>
                        </div>
                    </div>
                </div>
            </div> --}}

            @can('ver-actividad-reciente')
                @livewire("bitacora-dashboard")
            @endcan

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-one">
                    <div class="widget-heading">
                        <h5 class="">Transacciones</h5>
                        <div class="task-action">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                </a>
                                <div class="dropdown-menu left" aria-labelledby="pendingTask" style="will-change: transform;">
                                    <a class="dropdown-item" href="javascript:void(0);">View Report</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Edit Report</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Mark as Done</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @livewire("transacciones")

                </div>
            </div>

            {{-- <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">

                <div class="widget widget-wallet-one">

                    <div class="wallet-info text-center mb-3">

                        <p class="wallet-title mb-3">Total Balance</p>

                        <p class="total-amount mb-3">$ 26,177.88</p>

                        <a href="#" class="wallet-text"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up me-2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg> Get 6% interest</a>

                    </div>


                    <div class="wallet-action text-center d-flex justify-content-around">

                        <button class="btn btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                            <span class="btn-text-inner">Topup</span>
                        </button>

                        <button class="btn btn-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 16 16 12 12 8"></polyline><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                            <span class="btn-text-inner">Send</span>
                        </button>

                    </div>

                    <hr>

                    <ul class="list-group list-group-media">
                        <li class="list-group-item ">
                            <div class="media">
                                <div class="me-3">
                                    <img onerror="this.src='/v3/src/assets/img/avatarprofile.png';" alt="avatar" src="{{url('v3/src/assets/img/netflix.svg')}}" class="img-fluid rounded-circle">
                                </div>
                                <div class="media-body">
                                    <h6 class="tx-inverse">Netflix</h6>
                                    <p class="mg-b-0">June 6, 10:34</p>
                                    <p class="amount">- $18.06</p>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="media">
                                <div class="me-3">
                                    <img onerror="this.src='/v3/src/assets/img/avatarprofile.png';" alt="avatar" src="{{url('v3/src/assets/img/apple-app-store.svg')}}" class="img-fluid rounded-circle">
                                </div>
                                <div class="media-body">
                                    <h6 class="tx-inverse">App Design</h6>
                                    <p class="mg-b-0">June 14, 05:21</p>
                                    <p class="amount">- $90.65</p>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <button class="btn btn-secondary w-100 mt-3">View Transaction History</button>

                </div>
            </div> --}}

            @can('ver-actos-abogados')
                @livewire('abogados-proyectos')
            @endcan

            @can('ver-monitor-server')
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget-four">
                    <div class="widget-heading">
                        <h5 class="">Server</h5>
                    </div>
                    <div class="widget-content">
                        <div class="vistorsBrowser">
                            <div class="browser-list">
                                <div class="w-icon">
                                    <i class="fa-solid fa-hard-drive text-white"></i>
                                </div>
                                <div class="w-browser-details">
                                    <div class="w-browser-info">
                                        <h6>HDD</h6>
                                        @php
                                            $totalhdd = round(disk_total_space("/") / 1024 /1024 / 1024);
                                            $freeSpace = round(disk_free_space("/") / 1024 / 1024 / 1024);
                                            $hddusado = $totalhdd - $freeSpace;
                                            $porcentje = $hddusado * 100 / $totalhdd;
                                            $ramusada = (memory_get_usage() / 1024) / 1024;
                                            $totalRam = 16000;
                                            $procentajeram = $ramusada * 100 / $totalRam;
                                        @endphp
                                        <p class="browser-count">{{$freeSpace}}GB usados de {{$totalhdd}}GB | {{round($porcentje)}}% Usado</p>
                                    </div>
                                    <div class="w-browser-stats">
                                        <div class="progress">
                                            <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: {{round($porcentje)}}%" aria-valuenow="{{round($porcentje)}}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="browser-list">
                                <div class="w-icon">
                                    <i class="fa-solid fa-memory text-white"></i>
                                </div>
                                <div class="w-browser-details">

                                    <div class="w-browser-info">
                                        <h6>RAM</h6>
                                        <p class="browser-count">{{round($ramusada,1)}}Mb usados de 16000Mb - {{round($procentajeram, 4)}}% Usado</p>
                                    </div>

                                    <div class="w-browser-stats">
                                        <div class="progress">
                                            <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: {{round($procentajeram)}}%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endcan


        </div>

    </div>
</div>
@endsection

@section('scripts-content')
    <script src="{{ url("v3/src/plugins/src/apex/apexcharts.min.js") }}"></script>
    <script src="{{url("v3/src/assets/js/dashboard/dash_2.js")}}"></script>
@endsection


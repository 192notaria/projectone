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
                        <h5 class="">Proyectos mensuales</h5>
                        <div class="task-action">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="renvenue" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                </a>
                                <div class="dropdown-menu left" aria-labelledby="renvenue" style="will-change: transform;">
                                    <form action="/reportes" method="POST" target="_blank">
                                        @csrf
                                        {{-- <a type="submit" class="dropdown-item" href="#">Semanal</a> --}}
                                        <button style="border: none !important;" type="submit" class="btn btn-outline-dark">Semanal</button>
                                    </form>
                                    <form action="">
                                        <button style="border: none !important;" class="btn btn-outline-dark">Mensual</button>
                                    </form>
                                    <form action="">
                                        <button style="border: none !important;" class="btn btn-outline-dark">Anual</button>
                                    </form>
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

            @can('ver-actividad-reciente')
                @livewire("bitacora-dashboard")
            @endcan

            @can("ver-transacciones")
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
            @endcan

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


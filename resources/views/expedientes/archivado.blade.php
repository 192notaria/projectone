@extends('layouts.app')
@section('links-content')
    <link href="{{ url('v3/src/assets/css/light/elements/search.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('v3/src/assets/css/dark/elements/search.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ url('v3/src/assets/css/light/forms/switches.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('v3/src/assets/css/dark/forms/switches.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/dark/users/user-profile.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/light/elements/custom-pagination.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/dark/elements/custom-pagination.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/light/components/timeline.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/dark/components/timeline.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{url('v3/src/assets/css/dark/components/list-group.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('v3/src/assets/css/light/components/list-group.css')}}" rel="stylesheet" type="text/css">

    <link href="{{url('v3/src/plugins/src/filepond/filepond.min.css')}}" rel="stylesheet">
    <link href="{{url('v3/src/plugins/src/filepond/FilePondPluginImagePreview.min.css')}}" rel="stylesheet">
    <link href="{{url('v3/src/plugins/css/light/filepond/custom-filepond.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/assets/css/dark/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('v3/src/plugins/css/dark/filepond/custom-filepond.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="layout-px-spacing mt-5">
        <div class="middle-content container-xxl p-0">
            {{-- <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <h2>Archivados</h2>
                </nav>
            </div> --}}
            <div class="row invoice layout-top-spacing layout-spacing">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="doc-container">
                        <div class="row">
                            <div class="col-xl-12">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-dark mb-3"><i class="fa-solid fa-arrow-left"></i></a>
                            </div>
                            <div class="col-xl-9">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row gx-5 gy-5">
                                            <div class="col-lg-12">
                                                <h5 class="card-title">Observaciones</h5>
                                                <p>{{$proyecto->recibos_archivo->observaciones == '' ? "Sin observaciones..." : $proyecto->recibos_archivo->observaciones}}</p>
                                            </div>
                                            <div class="col-lg-12">
                                                <h5 class="card-title">Cotización</h5>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Concepto</th>
                                                                <th>Subtotal</th>
                                                                <th>Gestoria</th>
                                                                <th>Impuestos</th>
                                                                <th>Total</th>
                                                                <th>Observaciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($proyecto->costos_cotizacion as $costo)
                                                                <tr>
                                                                    <td>{{$costo->concepto_pago->descripcion}}</td>
                                                                    <td>${{number_format($costo->subtotal, 2)}}</td>
                                                                    <td>${{number_format($costo->gestoria, 2)}}</td>
                                                                    <td>
                                                                        ${{number_format($costo->subtotal * $costo->impuestos / 100, 2)}}
                                                                        <span class="text-primary">({{$costo->impuestos}}%)</span>
                                                                    </td>
                                                                    <td>
                                                                        ${{number_format($costo->subtotal + $costo->gestoria + $costo->subtotal * $costo->impuestos / 100, 2)}}
                                                                    </td>
                                                                    <td>{{$costo->observaciones == '' ? "Sin observaciones..." : $costo->observaciones}}</td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td class="text-center" colspan="6">Sin registros...</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <h5 class="card-title">Partes</h5>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Parte</th>
                                                                <th>Tipo de persona</th>
                                                                <th>Tipo de parte</th>
                                                                <th>Curp</th>
                                                                <th>Rfc</th>
                                                                <th>Copropietario</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($proyecto->partes as $parte)
                                                                <tr>
                                                                    <td>
                                                                        @if ($parte->cliente->tipo_cliente == 'Persona Moral')
                                                                            {{$parte->cliente->razon_social}}
                                                                        @else
                                                                            {{$parte->cliente->nombre}} {{$parte->cliente->apaterno}} {{$parte->cliente->amaterno}}
                                                                        @endif
                                                                    </td>
                                                                    <td>{{$parte->tipo_persona}}</td>
                                                                    <td>{{$parte->tipo}}</td>
                                                                    <td>
                                                                        {!!$parte->cliente->curp == '' ? "<span class='text-danger'>S/N</span>" : $parte->cliente->curp!!}
                                                                    </td>
                                                                    <td>
                                                                        {!!$parte->cliente->rfc == '' ? "<span class='text-danger'>S/N</span>" : $parte->cliente->rfc!!}
                                                                    </td>
                                                                    <td>
                                                                        {!!$parte->porcentaje != 0 ?  $parte->porcentaje . "%" : "<span class='text-danger'>S/N</span>"!!}
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td class="text-center" colspan="6">Sin registros...</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <h5 class="card-title">Bitacora</h5>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Fecha</th>
                                                                <th>Proceso</th>
                                                                <th>Registro</th>
                                                                <th>Abogado</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($proyecto->bitacora as $bitacora)
                                                                <tr>
                                                                    <td>{{$bitacora->created_at}}</td>
                                                                    <td>{{$bitacora->proceso->nombre}}</td>
                                                                    <td>{{$bitacora->subproceso->nombre}}</td>
                                                                    <td>
                                                                        @if (isset($bitacora->proyecto->abogado->name))
                                                                            {{$bitacora->proyecto->abogado->name}} {{$bitacora->proyecto->abogado->apaterno}} {{$bitacora->proyecto->abogado->amaterno}}
                                                                        @else
                                                                            Abogado eliminado de usuarios
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="4" class="text-center">Sin registros...</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <h5 class="card-title">Documentos</h5>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Nombre</th>
                                                                <th>Tipo</th>
                                                                <th>Fecha de registro</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($proyecto->documentos as $document_data)
                                                                <tr>
                                                                    <td style="max-width: 250px; overflow: hidden; text-overflow: ellipsis;">
                                                                        <a class="text-info" target="_blank" href="{{url($document_data->storage)}}">
                                                                            {{$document_data->nombre}}
                                                                        </a>
                                                                    </td>
                                                                    <td>{{$document_data->tipoDoc->nombre ?? ""}}</td>
                                                                    <td>{{$document_data->created_at}}</td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="3" class="text-center">Sin registros</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Expediente</h5>
                                        <p class="mb-0"><strong class="font-weight-bold">Escritura:</strong> {{$proyecto->numero_escritura}}</p>
                                        <p class="mb-0"><strong class="font-weight-bold">Folios:</strong> {{$proyecto->folio_inicio}} - {{$proyecto->folio_fin}}</p>
                                        <p class="mb-0"><strong class="font-weight-bold">Volumen:</strong> {{$proyecto->volumen}}</p>
                                        <p class="mb-0"><strong class="font-weight-bold">Cliente:</strong> {{$proyecto->cliente->nombre}} {{$proyecto->cliente->apaterno}} {{$proyecto->cliente->amaterno}}</p>
                                        <p class="mb-0"><strong class="font-weight-bold">Abogado:</strong> {{$proyecto->abogado->name}} {{$proyecto->abogado->apaterno}} {{$proyecto->abogado->amaterno}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="row layout-top-spacing">
                <div class="col-lg-12">
                    @livewire("expedientes-archivados")
                </div>
            </div> --}}
        </div>
    </div>
@endsection

@section('scripts-content')
<script src="{{ url("v3/src/plugins/src/highlight/highlight.pack.js") }}"></script>
<script src="{{ url('v3/src/assets/js/elements/custom-search.js') }}"></script>
{{-- <script src="{{url('v3/src/assets/js/scrollspyNav.js')}}"></script> --}}

<script src="{{url('v3/src/plugins/src/filepond/filepond.min.js')}}"></script>
<script src="{{url('v3/src/plugins/src/filepond/FilePondPluginFileValidateType.min.js')}}"></script>
<script src="{{url('v3/src/plugins/src/filepond/FilePondPluginImageExifOrientation.min.js')}}"></script>
<script src="{{url('v3/src/plugins/src/filepond/FilePondPluginImagePreview.min.js')}}"></script>
<script src="{{url('v3/src/plugins/src/filepond/FilePondPluginImageCrop.min.js')}}"></script>
<script src="{{url('v3/src/plugins/src/filepond/FilePondPluginImageResize.min.js')}}"></script>
<script src="{{url('v3/src/plugins/src/filepond/FilePondPluginImageTransform.min.js')}}"></script>
<script src="{{url('v3/src/plugins/src/filepond/filepondPluginFileValidateSize.min.js')}}"></script>
<script src="{{url('v3/src/plugins/src/filepond/custom-filepond.js')}}"></script>

@endsection


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Table</title>
    <link rel="icon" type="image/x-icon" href="../src/assets/img/favicon.ico"/>
    <link href="v3/layouts/vertical-dark-menu/css/light/loader.css" rel="stylesheet" type="text/css" />
    <link href="v3/layouts/vertical-dark-menu/css/dark/loader.css" rel="stylesheet" type="text/css" />
    <script src="v3/layouts/vertical-dark-menu/loader.js"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="v3/src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="v3/layouts/vertical-dark-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="v3/layouts/vertical-dark-menu/css/dark/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="v3/src/assets/css/light/components/media_object.css" rel="stylesheet" type="text/css">
    <link href="v3/src/assets/css/dark/components/media_object.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="main-container" id="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{$tittle}}</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Acto</th>
                                <th scope="col">Numero</th>
                                <th scope="col">Cliente</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($projects_data as $project)
                                <tr>
                                    <td>{{$project->id}}</td>
                                    <td>{{$project->servicio_id}}</td>
                                    <td>{{$project->numero_escritura}}</td>
                                    <td>{{$project->cliente_id}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="4">Sin registros...</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="v3/src/plugins/src/global/vendors.min.js"></script>
    <script src="v3/src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="v3/src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="v3/src/plugins/src/mousetrap/mousetrap.min.js"></script>
    <script src="v3/src/plugins/src/waves/waves.min.js"></script>
    <script src="v3/layouts/vertical-dark-menu/app.js"></script>
    <script src="v3/src/plugins/src/highlight/highlight.pack.js"></script>
    <script src="v3/src/assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL CUSTOM SCRIPTS -->
     <script src="v3/src/assets/js/scrollspyNav.js"></script>
</body>
</html>

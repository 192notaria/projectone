<?php

use App\Events\NotificationEvent;
use App\Http\Controllers\ChartsController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ColoniasController;
use App\Http\Controllers\Contabilidad;
use App\Http\Controllers\ContactosController;
use App\Http\Controllers\EscriturasApoyo;
use App\Http\Controllers\EstadosController;
use App\Http\Controllers\FilesData;
use App\Http\Controllers\FirebaseAuthController;
use App\Http\Controllers\GuardiasController;
use App\Http\Controllers\MunicipiosController;
use App\Http\Controllers\OcupacionesController;
use App\Http\Controllers\PaisesController;
use App\Http\Controllers\ProcesosServicios;
use App\Http\Controllers\ProyectosController;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\RolController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\SubprocesosController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UsuariosController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('home');

Route::get('/user/profile', function () {
    return view('user.profile');
})->middleware(['auth'])->name('user_profile');

require __DIR__.'/auth.php';
Route::post('/administracion/servicios/uploadFile/{user_id}', [ServiciosController::class, "uploadFiles"])->name("upload-files");

Route::group(['middleware' => ['auth']], function(){
    // ADMINISTRACION
    Route::get('/administracion/roles', [RolController::class, 'index'])->name('admin-roles');
    Route::get('/administracion/usuarios', [UsuariosController::class, 'index'])->name('admin-usuarios');
    // Route::get('/administracion/escrituras_proceso', [ProyectosController::class, 'index'])->name('escrituras-proceso');
    Route::get('/administracion/escrituras_proceso', [ProyectosController::class, 'index2'])->name('escrituras-proceso');
    Route::get('/administracion/escrituras', [ProyectosController::class, 'escrituras'])->name('escrituras-escrituras');
    Route::get('/administracion/escrituras_general', [ProyectosController::class, 'escrituras_general'])->name('escrituras-general');

    Route::get('/administracion/escrituras_apoyo', [EscriturasApoyo::class, 'index'])->name('escrituras-apoyo');
    Route::get('/administracion/ocupaciones', [OcupacionesController::class, 'index'])->name('admin-ocupaciones');
    Route::get('/administracion/cotizaciones', [ProyectosController::class, 'cotizaciones'])->name('admin-cotizaciones');
    Route::get('/catalogos/documentos_generales', [ProyectosController::class, 'documentos_generales'])->name('catalogos-documentos_generales');

    Route::get('/recibo/{id}', [UsuariosController::class, 'generatePdf'])->name('recibo-pago');

    // Clientes
    Route::get('/administracion/clientes', [ClientesController::class, 'index'])->name('admin-clientes');
    Route::get('/contactos/lista_contactos', [ContactosController::class, 'index'])->name('lista-contactos');

    // PROCESOS Y SERVICIOS
    Route::get('/administracion/servicios', [ServiciosController::class, 'index'])->name('admin-servicios');
    Route::get('/administracion/procesos_servicios', [ProcesosServicios::class, 'index'])->name('admin-procesos_servicios');
    Route::get('/administracion/subprocesos', [SubprocesosController::class, 'index'])->name('admin-subprocesos');

    // CATALOGOS
    Route::get('/catalogos/paises', [PaisesController::class, 'index'])->name('catalogos-paises');
    Route::get('/catalogos/estados', [EstadosController::class, 'index'])->name('catalogos-estados');
    Route::get('/catalogos/municipios', [MunicipiosController::class, 'index'])->name('catalogos-municipios');
    Route::get('/catalogos/colonias', [ColoniasController::class, 'index'])->name('catalogos-colonias');

    Route::get('/chartsData/{type}', [ChartsController::class, 'index'])->name('charts');
    Route::get('/chartsData/{type}', [ChartsController::class, 'index'])->name('charts');
    // Route::resource('/user/profile', UserProfileController::class);
    Route::get('/file_system/{filename}', [FilesData::class, 'file_preview'])->name('file-preview');

    Route::post('/intefone', [FilesData::class, 'interphone'])->name('interphone-comunication');

    Route::get('/firebase_data', [FirebaseAuthController::class, 'index'])->name('firebase.index');
    Route::get('/email', [FirebaseAuthController::class, 'sendemail'])->name('email.test');
    Route::get('/usuarios/guardias', [GuardiasController::class, 'index'])->name('usuarios.guardias');
    Route::get('/usuarios/getGuardias', [GuardiasController::class, 'getGuardias'])->name('usuarios.getGuardias');

    Route::get('/contabilidad', [Contabilidad::class, 'index'])->name('contabilidad.index');
    Route::get('/contabilidad/pagos', [Contabilidad::class, 'pagos'])->name('contabilidad.pagos');
    Route::get('/contabilidad/facturas', [Contabilidad::class, 'facturas'])->name('contabilidad.facturas');
    Route::get('/contabilidad/declaranot', [Contabilidad::class, 'declaranot'])->name('contabilidad.declaranot');
});

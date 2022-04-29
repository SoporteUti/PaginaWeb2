<?php
/**Importaciones por default */
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\indexController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [indexController::class, 'index'])->name('index');

//Ruta para el admin
Route::get('admin', function () {
    return view('Admin.home');})
    ->middleware('auth')
    ->name('admin');

Route::get('admin/bitacora', 'App\Http\Controllers\BitacoraController@index')->name('admin.bitacora');

Route::get('admin/notificaciones', 'App\Http\Controllers\NotificacionesController@index')->name('admin.notificaciones');
Route::get('admin/notificaciones/check/{id}', 'App\Http\Controllers\NotificacionesController@check')->name('admin.notificaciones.check');

require __DIR__.'/transparencia.php';
require __DIR__.'/auth.php';
require __DIR__.'/pagina.php';
require __DIR__.'/licencias.php';
require __DIR__.'/horarios.php';
require __DIR__.'/jornadas.php';
require __DIR__.'/roles_usuarios.php';
require __DIR__.'/general.php';

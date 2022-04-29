<?php

use App\Models\Transparencia;
use Illuminate\Support\Facades\Route;

/** RUTAS DE TRANSPARENCIA **/

Route::get('admin/transparencia/{categoria}', 'App\Http\Controllers\Transparencia\TransparenciaController@index')->name('admin.transparencia.index');
Route::get('admin/transparencia/{categoria}/create', 'App\Http\Controllers\Transparencia\TransparenciaController@create')->name('admin.transparencia.create');
Route::get('admin/transparencia/{categoria}/edit/{id}', 'App\Http\Controllers\Transparencia\TransparenciaController@edit')->name('admin.transparencia.edit');

Route::post('admin/transparencia/{categoria}/store', 'App\Http\Controllers\Transparencia\TransparenciaController@store')->name('admin.transparencia.store');
Route::patch('admin/transparencia/{categoria}/{id}', 'App\Http\Controllers\Transparencia\TransparenciaController@update')->name('admin.transparencia.update');
Route::post('admin/transparencia/{categoria}/publicar/{id}', 'App\Http\Controllers\Transparencia\TransparenciaController@publicar')->name('admin.transparencia.publicar');
Route::get('admin/transparencia/{categoria}/file/{id}', 'App\Http\Controllers\Transparencia\TransparenciaController@file')->name('admin.transparencia.file');

Route::resource('admin/transparencia-directorios', 'App\Http\Controllers\Transparencia\DirectoriosController')->except(['show'])->names('admin.transparencia.directorios');


Route::get( 'transparencia', 'App\Http\Controllers\Transparencia\TransparenciaWebController@index');
Route::get('transparencia/{categoria}', 'App\Http\Controllers\Transparencia\TransparenciaWebController@categoria')->name('transparencia.categoria');
Route::get('transparencia-sub/{categoria}/{subcategoria}', 'App\Http\Controllers\Transparencia\TransparenciaWebController@subcategoria')->name('transparencia.subcategoria');
Route::get('transparencia/{categoria}/{id}', 'App\Http\Controllers\Transparencia\TransparenciaWebController@documento')->name('transparencia.documento');
Route::get('transparencia-busqueda', 'App\Http\Controllers\Transparencia\TransparenciaWebController@busqueda')->name( 'transparencia.busqueda');
Route::get('transparencia-datatable/{categoria}', 'App\Http\Controllers\Transparencia\TransparenciaWebController@datatable')->name('transparencia.datatable');
Route::get('transparencia-directorios', 'App\Http\Controllers\Transparencia\TransparenciaWebController@directorios')->name('transparencia.directorios');


//RUTAS DESCARGA ARCHIVOS
Route::get('/transparencia-download/{id}', 'App\Http\Controllers\Transparencia\TransparenciaWebController@download')->name('transparencia.download');

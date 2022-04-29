<?php

use App\Models\Jornada\Jornada;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth','role:super-admin|Docente|Jefe-Administrativo|Jefe-Academico|Recurso-Humano|Administrativo']], function () {
    //RUTAS JORNADA
    Route::resource('admin/jornada', 'App\Http\Controllers\JornadaController')->only(['index','show','store','destroy'])->names('admin.jornada');
    Route::post('admin/jornada-export', 'App\Http\Controllers\JornadaController@export')->name('admin.jornada.export');

    //modal
    Route::get("admin/jornada/detalle/{id}", "App\Http\Controllers\JornadaController@getDetalle");
    Route::get("admin/jornada/detalleCarga/{id}", "App\Http\Controllers\JornadaController@fnCargaSegunEmpleado");
    Route::get('admin/jornada/jornadaEmpleado/{id}', 'App\Http\Controllers\JornadaController@getEmpleadoJornada')->name('admin.jornada.empleado');
    Route::get('admin/jornada/periodoEmpleados/{id}', 'App\Http\Controllers\JornadaController@getEmpleadoPeriodo')->name('admin.jornada.periodo.empleados');
    Route::post("admin/jornada-procedimiento", "App\Http\Controllers\JornadaController@procedimiento")->name('admin.jornada.procedimiento');
    Route::get("admin/jornada-seguimiento-opciones/{id}", "App\Http\Controllers\JornadaController@getOpcionesSeguimiento")->name('admin.jornada.seguimiento.opciones');
    Route::post("admin/jornada-check-dia", "App\Http\Controllers\JornadaController@checkDia")->name('admin.jornada.check-dia');

    //obtener departamentos
    Route::post('admin/jornada/select{id}', 'App\Http\Controllers\JornadaController@getDepto')->name('admin.jornada.select');
});

Route::group(['middleware' => ['auth', 'role:Jefe-Administrativo|Jefe-Academico']], function () {
    Route::post('admin/jornada/notificacion/mail', 'App\Http\Controllers\JornadaController@email')->name('admin.jornada.notificacion');
});



Route::group(['middleware' => ['auth','role:super-admin|Recurso-Humano']], function () {
    //RUTAS PERIODO
    Route::resource('admin/periodo', 'App\Http\Controllers\PeriodoController')->only(['index', 'store', 'show', 'destroy'])->names('admin.periodo');
    Route::get('admin/periodo/finalizar/{id}', 'App\Http\Controllers\PeriodoController@finalizar')->name('admin.periodo.finalizar');
    Route::get('admin/periodo/jornadasFinalizar/{id}', 'App\Http\Controllers\PeriodoController@jornadasFinalizar');
    Route::get('admin/periodo/jornadasEliminar/{id}', 'App\Http\Controllers\PeriodoController@jornadasEliminar');
    Route::get('admin/periodo/reactivar/{id}', 'App\Http\Controllers\PeriodoController@reactivar')->name('admin.periodo.reactivar');
    //RUTAS CICLO
    Route::resource('admin/ciclo', 'App\Http\Controllers\CicloController')->only(['index', 'store', 'show', 'destroy'])->names('admin.ciclo');
    Route::get('admin/ciclo/finalizar/{id}', 'App\Http\Controllers\CicloController@finalizar')->name('admin.ciclo.finalizar');
    Route::get('admin/ciclo/reactivar/{id}', 'App\Http\Controllers\CicloController@reactivar')->name('admin.ciclo.reactivar');
    //RUTAS TIPO CONTRATO
    Route::resource('admin/tcontrato', 'App\Http\Controllers\Tipo_ContratoController')->only(['index', 'store', 'show', 'destroy'])->names('admin.tcontrato');
    //RUTAS TIPO JORNADA
    Route::resource('admin/tjornada', 'App\Http\Controllers\Tipo_JornadaController')->only(['index', 'store', 'show', 'destroy'])->names('admin.tjornada');
});

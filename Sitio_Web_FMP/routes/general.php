<?php

use App\Http\Controllers\General\EmpleadoController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['role:super-admin|Recurso-Humano','auth']], function () {

    /**Metodos Get */
    Route::get('admin/Empleado',[EmpleadoController::class, 'index'])->name('empleado');
    Route::get('admin/Empleado/{id}', [EmpleadoController::class, 'empleado']);

    Route::get('admin/Empleado/Categoria/Get',[EmpleadoController::class, 'categoriaGet'])->name('empleadoCat');
    Route::get('admin/Empleado/categoriaGetObjeto/{id}',[EmpleadoController::class, 'categoriaGetObjeto']);

    /**Metodos Post */
    Route::post('admin/Empleado/Registrar', [EmpleadoController::class, 'store'])->name('EmpleadoReg');
    Route::post('admin/Empleado/Categoria/Registrar',[EmpleadoController::class, 'categoriaStore'])->name('empleadoCatReg');
    Route::post('admin/Empleado/Categoria/Borrar',[EmpleadoController::class, 'categoriaDestroy'])->name('empleadoCatDest');
    Route::post('admin/Empleado/DarAltaBaja', [EmpleadoController::class, 'empleadoEstado'])->name('empEstado');


});

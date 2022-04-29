<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesUsuarios\UsuariosController;

Route::group(['middleware' => ['role:super-admin','auth']], function () {
    
    /**Rutas Get */
    Route::get('admin/Usuarios',[UsuariosController::class,'index'])->name('usuarios');
    Route::get('admin/Usuarios/Usuario/{usuario}',[UsuariosController::class,'usuario']);
    Route::get('admin/Usuarios/UsuarioRol/{usuario}',[UsuariosController::class,'usuarioRol']);

    /**Rutas Post */
    Route::post('admin/usuarios/guardar', [UsuariosController::class,'store'])->name('guardarUser');
    Route::post('admin/usuarios/estado', [UsuariosController::class,'estado'])->name('usuarioEstado');

});
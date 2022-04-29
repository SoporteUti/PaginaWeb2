<?php

use App\Http\Controllers\Horarios\AsignacionCargaController;
use App\Http\Controllers\Horarios\AulaController;
use App\Http\Controllers\Horarios\CargaController;
use App\Http\Controllers\Horarios\CarrerasController;
use App\Http\Controllers\Horarios\DepartamentoController;
use App\Http\Controllers\Horarios\HoraController;
use App\Http\Controllers\Horarios\HorarioController;
use App\Http\Controllers\Horarios\MateriaController;
use Illuminate\Support\Facades\Route;

//para las aulas
Route::get('Aulas',[AulaController::class,'index'])->name('aulas');
Route::post('Aulas/create',[AulaController::class,'store'])->name('aulas.store');
Route::post('Aulas/estado', [AulaController::class,'estado'])->name('estadoAula');
//fin de para las aulas

//para departamentos
Route::get('Departamentos',[DepartamentoController::class,'index'])->name('depto');
Route::post('Departamentos/create',[DepartamentoController::class,'store'])->name('depto.store');
Route::post('Departamentos/estado', [DepartamentoController::class,'estado'])->name('estadoDept');
//fin de departamentos

//para carreras
Route::get('Carreras',[CarrerasController::class,'index'])->name('carreras');
Route::post('Carreras/create',[CarrerasController::class,'create'])->name('carreras.create');
Route::post('Carreras/estado', [CarrerasController::class,'estado'])->name('estadoCarrera');
//fin de para carreras

//para materias
Route::get('Materias',[MateriaController::class,'index'])->name('materias');
Route::post('Materias/create',[MateriaController::class,'administrar'])->name('materias/create');
Route::post('Materia/estado', [MateriaController::class,'estado'])->name('estadoMateria');
//fin de para materia

Route::get('Horarios',[HorarioController::class,'index'])->name('horarios');
//para ingresar la carga administrativa
Route::get('Administrativa/Carga',[CargaController::class,'index'])->name('crear-carga');
Route::post('Administrativa/create',[CargaController::class,'create'])->name('carga.create');
Route::post('Administrativa/estado', [CargaController::class,'estado'])->name('estadoCarga');
Route::get('Administrativa/Empleado',[CargaController::class,'EmpleadoCombobox']);
//fin de ingresar la carga administrativa
Route::get('Asigar/Carga',[AsignacionCargaController::class,'index'])->name('asignar-carga');
Route::get('Asigar/ver',[AsignacionCargaController::class,'cargaCombobox']);
Route::get('Asigar/Empleado',[AsignacionCargaController::class,'EmpleadoCombobox']);
Route::get('/Administrativa/Carga/{id}',[CargaController::class,'cargaModal']);
//asignacion de carga
Route::post('Asignar/create', [AsignacionCargaController::class,'create'])->name('create/asignacion');
Route::get('/Asignar/Carga/{id}',[AsignacionCargaController::class,'cargaModal']);

//para las horas
Route::get('Horas',[HoraController::class,'index'])->name('horas');
Route::post('Horas/create',[HoraController::class,'create'])->name('horas/create');
Route::post('Horas/estado', [HoraController::class,'estado'])->name('estadoHora');
//para las horas fin
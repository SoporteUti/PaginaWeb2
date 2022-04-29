<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pagina\ImagenesCarruselController;
use App\Http\Controllers\Pagina\NoticiaController;
use App\Http\Controllers\Pagina\PDFImageController;
use App\Http\Controllers\Pagina\EstructuraOrganizativaController;
use App\Http\Controllers\Pagina\JuntaJefaturaController;
use App\Http\Controllers\Pagina\DirectorioController;
use App\Http\Controllers\Pagina\ProyeccionSocialController;
use App\Http\Controllers\Pagina\MaestriaController;
use App\Http\Controllers\Pagina\PostgradoController;
use App\Http\Controllers\Pagina\InvestigacionController;
use App\Http\Controllers\Pagina\Academicos;
use App\Http\Controllers\Pagina\ContenidoHtmlController;
use App\Http\Controllers\Pagina\PlaComplementarioController;
use App\Http\Controllers\Pagina\AudioVisualController;
use App\Http\Controllers\Pagina\SondeoController;
use App\Http\Controllers\Pagina\HorariosColecturiaController;

/**PDF ------------------------------------------------------------------*/

Route::post('PDFS/{localizacion}',[PDFImageController::class,'storeAll'])->middleware(['auth'])->name('subirPdf');

Route::post('PDF/{localizacion}',[PDFImageController::class,'store'])->middleware(['auth'])->name('PDF');

/**Carrusel 
Route::post('/subirCarrusel/{tipo}', [ImagenesCarruselController::class, 'store'])
->middleware(['auth','role:super-admin'])->name('ImagenCarrusel');*/
Route::post('/subirCarrusel/{tipo}', [ImagenesCarruselController::class, 'store'])
->middleware(['auth'])->name('ImagenCarrusel');

/**ContenidoHTML 
Route::post('contenidoHTML/{localizacion}',[ContenidoHtmlController::class,'store'])
->middleware(['auth','role:super-admin|Pagina-Admin|Pagina-Depto-CDE|Pagina-Depto-CA|Pagina-Depto-CE|Pagina-Depto-I|Pagina-Depto-PC'])->name('contenido');
*/
Route::post('contenidoHTML/{localizacion}',[ContenidoHtmlController::class,'store'])
->middleware(['auth'])->name('contenido');

/**Index ----------------------------------------------------------------*/

Route::post('/subirCarruselInicio/{tipo}', [ImagenesCarruselController::class, 'store'])
->middleware(['auth'])->name('ImagenFacultad.subir');

Route::post('Carrusel/Imagen/borrar/{url}', [ImagenesCarruselController::class, 'destroy'])
->middleware(['auth'])->name('imagenCAborrar');

Route::post('/noticias/nueva', [NoticiaController::class, 'store'])
->middleware(['auth'])->name('NoticiaFacultad.nueva');

Route::post('/noticias/nuevaurl', [NoticiaController::class, 'storeurl'])
->middleware(['auth'])->name('NoticiaFacultad.nuevaurl');

Route::post('/noticias/borrar', [NoticiaController::class, 'destroy'])
->middleware(['auth'])->name('NoticiaBorrar');

Route::get('/noticias/{titulo}/{id}',[NoticiaController::class, 'index'])
->name('NoticiaFacultad.ver');

/**Nosotros----------------------------------------------------------------------*/

Route::post('/nosotros/organigrama/image/{localizacion}', [PDFImageController::class, 'store1'])
->middleware(['auth'])->name('Nosotros.organigrama');

Route::get('EstructuraOrganizativa', [EstructuraOrganizativaController::class, 'index'])->name('EstructOrga');

Route::post('EstructuraOrganizativa/Junta', [JuntaJefaturaController::class, 'store1'])
->middleware(['auth'])->name('EstructuraOrganizativa.Junta');

Route::post('EstructuraOrganizativa/Jefatura', [JuntaJefaturaController::class, 'store2'])
->middleware(['auth'])->name('EstructuraOrganizativa.Jefatura');

Route::post('/EstructuraOrganizativa/JefaturaJunta', [JuntaJefaturaController::class, 'destroy'])
->middleware(['auth'])->name('JefaturaJuntaBorrar');

Route::post('/Directorio/Nuevo', [DirectorioController::class, 'store'])
->middleware(['auth'])->name('Nosotros.directorio');

Route::post('/Directorio/borrar', [DirectorioController::class, 'destroy'])
->middleware(['auth'])->name('directorio.borrar');

Route::get('/Directorio', [DirectorioController::class, 'index'])
->name('directorio');

Route::get('MisionVision', function () {
    return view('Nosotros.misionVision');
});

Route::post('/EstructuraOrganizativa/PeriodoJunta',[JuntaJefaturaController::class, 'periodoJunta'])
->middleware(['auth'])->name('Periodo.junta');

Route::post('/EstructuraOrganizativa/PeriodoJefatura',[JuntaJefaturaController::class, 'periodoJefatura'])
->middleware(['auth'])->name('Periodo.jefatura');

/**Academicos-------------------------------------------------------------------------------- */

Route::post('/AdministracionAcademica/imagen/{localizacion}', [PDFImageController::class, 'store1'])
->middleware(['auth'])->name('academicaImagen');

Route::get('Administracion Academica', [Academicos::class,'indexAdmonAcademica'])->name('admonAcademica');

Route::post('Administracion Academica/eliminarvideo', [AudioVisualController::class,'destroy'])
->middleware(['auth'])->name('admonEliminarV');

Route::post('Administracion Academica/agregarVideo', [AudioVisualController::class,'store'])
->middleware(['auth'])->name('admonAgregarV');

Route::get('Informatica',[Academicos::class,'indexInfor'])->name('Departamento.Inform');

Route::get('CienciasAgronomicas', [Academicos::class,'indexAgro'])->name('Departamento.CienciasAgr');

Route::get('CienciasEconomicas', [Academicos::class,'indexEcono'])->name('Departamento.CienciasEcon');

Route::get('CienciasEducacion', [Academicos::class,'indexEdu'])->name('Departamento.CienciasEdu');

Route::get('PlanComplementario', [PlaComplementarioController::class,'index'])->name('planComp');

Route::post('PlanCOmplementario/Licenciaturas',[PlaComplementarioController::class,'store'])
->middleware(['auth','role:super-admin|Pagina-Depto-PC|Pagina-Admin'])
->name('Plan.registro');//para actualizar e registrar

Route::post('PlanComplementario/destroy', [PlaComplementarioController::class,'destroy'])
->middleware(['auth','role:super-admin|Pagina-Depto-PC|Pagina-Admin'])->name('EliminarPlan');//para eliminar

Route::post('PlanComplementario/estado', [PlaComplementarioController::class,'estado'])
->middleware(['auth','role:super-admin|Pagina-Depto-PC|Pagina-Admin'])->name('estadoPlan');

/**---------------------------------------------------------------------------------------- */

Route::get('Investigacion',[InvestigacionController::class, 'index'])->name('investigacion');

Route::post('Sondeo',[SondeoController::class, 'store'])
->name('sondeo.guardar');

Route::post('Sondeo/borrar',[SondeoController::class, 'destroy'])
->name('sondeo.borrar');

Route::get('ProyeccionSocial',[ProyeccionSocialController::class, 'index'])
->name('proyeccionSocial');

Route::post('ProyeccionSocial/borrar',[ProyeccionSocialController::class, 'destroy'])
->name('proyeccionSocial.borrar');

Route::post('ProyeccionSocial/Jefe/',[ProyeccionSocialController::class, 'jefaturaProyeccionSocial'])
->name('JefeProyeccionSocial')->middleware(['auth']);

Route::post('ProyeccionSocial/Coordinadores/',[ProyeccionSocialController::class, 'storeProyeccionSocial'])
->name('nuevoCoordinador')->middleware(['auth']);

Route::post('ProyeccionSocial/EliminarPDF',[ProyeccionSocialController::class, 'eliminarPDF'])
->middleware(['auth'])->name('EliminarProyeccionPDF');

Route::get('Postgrado',[PostgradoController::class,'index'])->name('postgrado');

Route::post('Postgrado/Maestria/Registro',[MaestriaController::class,'store'])
->middleware(['auth'])
->name('Postgrado.registro');

Route::post('Postgrado/Maestria/EliminarPDF',[MaestriaController::class,'eliminarPDF'])
->middleware(['auth'])
->name('eliminarpdfmaestri');

Route::post('/subirCarruselPostgrado/{tipo}', [ImagenesCarruselController::class, 'store'])
->middleware(['auth'])->name('ConvocatoriaPostgrado');

Route::post('/Postgrado/Maestrias/estado', [MaestriaController::class,'estado'])
->middleware(['auth'])->name('estadoMaestria');

Route::post('/Postgrado/Maestria/Eliminar', [MaestriaController::class,'destroy'])
->middleware(['auth'])->name('EliminarMaestria');

Route::post('/Postgrado/pdf/{localizacion}',[PDFImageController::class,'storeFolder'])->middleware(['auth'])->name('Mpdf');

/**Administrativo */
Route::get('/AdministracionFinanciera', function () {
    return view('Administrativo.administracionFinanciera');
})->name('administracionFinanciera');

Route::get('/UnidadDeTegnologiaDeLaInformacion', function () {
    return view('Administrativo.unidadTegnologiaInformacion');
})->name('uti');

Route::get('/HorariosColecturiaJson',[HorariosColecturiaController::class,'horariosColecturia'])
->name('HorarioCole');

Route::post('/HorariosColecturiaRegistro',[HorariosColecturiaController::class,'store'])
->name('HorarioColeR')->middleware(['auth']);

Route::post('/HorariosColecturiaBorrar',[HorariosColecturiaController::class,'destroy'])
->name('HorarioBorrar')->middleware(['auth']);


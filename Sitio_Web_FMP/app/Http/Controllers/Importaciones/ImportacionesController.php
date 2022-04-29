<?php

namespace App\Http\Controllers\Importaciones;

use App\Http\Controllers\Controller;
use App\Imports\DatosImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ImportacionesController extends Controller
{
    //

    public function index(){
        
        return view('Importaciones.Importaciones');
    }

    //FUNCION DE IMPORTACION DE DATOS
    public function import():RedirectResponse //(Request $request) 

    {

   /* $this->validate(request(), [
        'file' => 'required|mimetypes::'.'  Ejemplo: Documento.xlsx',
    ]);*/
    

    try {
        set_time_limit(0);// ademas de tener insercciones por lotes y por segmento tenemos tiempo
        //de ejecucion se ilimitado para que no genere errores en el momento de realizar la transaccion
        DB::beginTransaction();
        Excel::import(new DatosImport(), request("file"));
        DB::commit();
       // return back()->with('notification', ['type' => 'success', 'title' => 'Usuarios importados']);
       return back()->withStatus('DATOS CARGADOS CORRECTAMENTE');
       //return back()->json(['mensaje'=>'Modificación exitosa']);
    } catch (\Exception $exception) {
        DB::rollBack();
      // return back()->json(['mensaje'=>'error']);
     // echo dd($exception);
       return back()->withStatus('ERROR AL CARGAR LOS DATOS');

       // return back()->with('notification', ['type' => 'danger', 'title' => 'Error importando usuarios']);
    }
  }
    //FIN DE FUNCION DE IMPORTACION DE DATOS


}

<?php

namespace App\Http\Controllers\Importaciones;

use App\Http\Controllers\Controller;
use App\Imports\DatosImport;
use App\Models\Reloj\Reloj_dato;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ImportacionesController extends Controller
{
    //

    public function cambio(Request $request){

      if($request->mond==1){
      $actualizar = "UPDATE reloj_datos
      SET entrada = '-'
      WHERE id_persona=" . $request->dui . ";";

      $actualizar = trim($actualizar);
      DB::select($actualizar);
      }

      if($request->mond==2){
        $actualizar = "UPDATE reloj_datos
        SET salida = '-'
        WHERE id_persona=" . $request->dui . ";";
  
        $actualizar = trim($actualizar);
        DB::select($actualizar);
        }


      return back()->withStatus('DATOS CARGADOS CORRECTAMENTE');
    }

    public function mostrarVistaModificaciones(){
      $años = Reloj_dato::selectRaw('distinct to_char(reloj_datos.fecha::date, \'YYYY\') as año')->get();
      return view('Importaciones.Modificacion',compact('años'));

    }

    //PARA MOSTRAR EN LA TABLA DE ASISTENCIA
    public function mostrarTabla($mes, $anio)
    {

        $datos = Reloj_dato::selectRaw('id_persona, nombre_personal,fecha,entrada,salida');

        if ($anio != 'selected' && $mes != 'selected') {
 
            $datos = $datos->whereRaw('to_char(fecha::date,\'YYYY\')::int=' . $anio)
            ->whereRaw('to_char(fecha::date,\'MM\')::int=' . $mes);
        }

      

        $datos = $datos->get();

        

        foreach ($datos as $item) {
          $botones =
        '<div class="row">
        <div class="col text-center">
            <div class="btn-group" role="group">
            
                <button title="Ver Impuntualidad" class="btn btn-outline-primary btn-sm"
                    value="' . $item->id_persona . '" onclick="Asis(this)">
                    <i class="fa fa-edit font-16 my-1" aria-hidden="true"></i>
                </button>
                
            </div>
        </div>
        </div>';
            

            $data[] = array(
                "col0" => $item->nombre_personal,
                "col1" => $item->id_persona,
                "col2" => \Carbon\Carbon::parse($item->fecha)->format('d/M/Y'),
                "col3" => $item->entrada,
                "col4" => $item->salida,
                "col5" => $botones,
            );
        }
        return isset($data) ? response()->json($data, 200, []) : response()->json([], 200, []);
    }
    //FIN DE MOSTRAR EN LA TABLA DE ASISTENCIA

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

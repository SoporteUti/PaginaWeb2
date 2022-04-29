<?php

namespace App\Http\Controllers\Horarios;

use App\Http\Controllers\Controller;
use App\Models\Horarios\Asig_admin;
use App\Models\Horarios\CargaAdmin;
use App\Models\Horarios\Ciclo;
use App\Models\Horarios\Proyectosociale;
use App\Models\Horarios\Trabajogrado;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AsignacionCargaController extends Controller
{
    //
    public function index(){
        if(Auth::user()->hasRole('super-admin')){
        $empleados = DB::table('empleado')->where('tipo_empleado','Académico')->get();
        $ciclos    = DB::table('ciclos')->where('estado','activo')->get();
        //solo para mostrar la carga admin
        $tablaA = DB::table('empleado')
        ->join('asig_admins', 'asig_admins.id_empleado', '=', 'empleado.id')
        ->join('ciclos', 'ciclos.id', '=', 'asig_admins.id_ciclo')
        ->join('carga_admins', 'carga_admins.id', '=', 'asig_admins.id_carga')
        ->select('empleado.id','empleado.nombre as E_nombre','empleado.apellido',
        'asig_admins.dias','asig_admins.id','asig_admins.sociales','asig_admins.tg','carga_admins.nombre_carga','ciclos.nombre','ciclos.año')
        ->where('ciclos.estado','activo')
        ->get();

        //para marcar el usuario ya asignado
        $asig = DB::table('empleado')
        ->join('asig_admins', 'asig_admins.id_empleado', '=', 'empleado.id')
        ->select('empleado.id')
        ->get();
        //fin de marcar los usuarios ya registrados

          // echo dd($tablaA);
        return view('Admin.horarios.asignarCarga',compact('empleados','ciclos','tablaA','asig'));
      }else{
        return response()->json(['error'=>['ACCESO DENEGADO']]);
      }
    }

    public function cargaCombobox(){         
        return CargaAdmin::select('*')->get()
        ->toJson();
    }

    
    //vamos a insertar los datos a la base de datos
    public function create(Request $request){
    ///************PARA INGRESAR CARGA ADMIN********* */
        try{
           // echo dd($request);
            $validator = Validator::make($request->all(),[
                'id_empleado'   =>'required|integer|unique:asig_admins,id_empleado'.(!is_null($request->_id) ? ','.$request->_id : null),
                'carga'         =>'required|unique:asig_admins,id_carga'.(!is_null($request->_id) ? ','.$request->_id : null),
                'id_ciclo'      =>'required',
                'dias'          =>'required'
            ]);         

            if($validator->fails())
            {            
                return response()->json(['error'=>$validator->errors()->all()]);                
            }
          //echo dd($request);
            $asig = $request->_id ==null ? new Asig_admin():Asig_admin::findOrFail($request->_id);
            $asig -> id_empleado   = $request->id_empleado;
            $asig -> id_carga      = $request->carga;
            $asig -> id_ciclo      = $request->id_ciclo;
            $asig -> dias          = $request->dias;
            $asig -> sociales      = $request->sociales;
            $asig -> tg            = $request->tg;
            $asig -> save();         
        
            return $request->_id != null?response()->json(['mensaje'=>'Modificación exitosa.']):response()->json(['mensaje'=>'Registro exitoso.']);
        
        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    
    /***FIN PARA INGRESAR CARGA ADMIN */

    }//fin create
    //fin de insertar los datos
    public function cargaModal($id){         
        $data = Asig_admin::select('*')
        ->findOrFail($id);
        return $data->toJson();
    }
}

<?php

namespace App\Http\Controllers\Licencias;

use App\Http\Controllers\Controller;
use App\Models\General\Empleado;
use App\Models\Licencias\Permiso;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Echo_;

class LicenciasAcuerdoController extends Controller
{
    public function index(){
      
      //  echo dd ($data);
        $empleados = Empleado::all();
        //$empleado = Empleado::findOrFail(auth()->user()->empleado);  
        return view('Licencias.LicenciaAcuerdo',compact('empleados'));
    }

      //CODIGO PARA INSERTAR, MODIFICAR
      public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'empleado'     => 'required',
                'tipo_de_permiso' => 'required|string',
                'fecha_de_inicio' => 'required|date|date_format:Y-m-d',
                'fecha_final' => 'required|date|date_format:Y-m-d',
                'justificación' => 'required|min:5|string',
            ]);         

            if($validator->fails())
            {            
                return response()->json(['error'=>$validator->errors()->all()]);                
            }

            $p = $request->_id == null ? new Permiso():Permiso::findOrFail($request->_id);
          //  $carga = $request->_id ==null ? new CargaAdmin():CargaAdmin::findOrFail($request->_id);
            $p -> tipo_permiso = $request-> tipo_de_permiso;
            $p -> fecha_uso = $request-> fecha_de_inicio;//fecha_uso
            $p -> fecha_presentacion = $request-> fecha_final;//fecha presentacion
            $p -> hora_inicio = '00:00:00';//como es licencia por acuerdo
            $p -> hora_final = '00:00:00';//como es licencia por acuerdo
            $p -> justificacion = $request-> justificación;
            $p -> empleado = $request->empleado;
            $p -> estado = 'Guardado RRHH';
            $p ->save();      

            return $request->_id != null?
            response()->json(['mensaje'=>'Modificación exitosa']):
            response()->json(['mensaje'=>'Registro exitoso']);
        
        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }//fin create

    public function Data(){
        $data =  Permiso::selectRaw('permisos.id,permisos.empleado, CONCAT(empleado.nombre,\' \',empleado.apellido) e_nombre, to_char(permisos.fecha_uso, \'DD/MM/YYYY\') inicio,
        to_char(permisos.fecha_presentacion,\'DD/MM/YYYY\') fin, permisos.justificacion, permisos.tipo_permiso')
        ->join('empleado','empleado.id','=','permisos.empleado')
        ->whereRaw('tipo_permiso=\'INCAPACIDAD/A\' or
                    tipo_permiso=\'ESTUDIO\' or
                    tipo_permiso=\'FUMIGACIÓN\' or
                    tipo_permiso=\'L.OFICIAL/A\' or
                    tipo_permiso=\'OTROS\'')
        ->get()->toJson();
        return $data;
        //echo dd($data);
    }
    public function cargaModal($id){         
        $data = Permiso::select('*')
        ->findOrFail($id);
        return $data->toJson();
    }

}

<?php

namespace App\Http\Controllers\Horarios;

use App\Http\Controllers\Controller;
use App\Models\General\Empleado;
use App\Models\Horarios\CargaAdmin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CargaController extends Controller
{
    public function index(){
        $carga = DB::table('carga_admins')
        ->where('id_jefe','=',null)
        ->get();
        //para el combobox
        $empleadosC=DB::table('empleado')
        ->join('asig_admins', 'empleado.id', '=', 'asig_admins.id_empleado')
        ->join('carga_admins','asig_admins.id_carga','=','carga_admins.id')
        ->select('empleado.id','empleado.nombre','empleado.apellido','carga_admins.nombre_carga')
        ->where('carga_admins.nombre_carga','=','Vicedecanato')->orWhere('carga_admins.nombre_carga','=','Decanato')
        ->get();
        //fin para el combobox
        $empleados = DB::table('carga_admins')
        ->leftJoin('empleado', 'carga_admins.id_jefe', '=', 'empleado.id')
        ->select('carga_admins.*','empleado.nombre','empleado.apellido')
        ->where('carga_admins.id_jefe','!=',null)
        ->get();
        //para validadr que ya aya sido asignado decanato y vicedecanato
        $decanato= DB::table('asig_admins')
        ->join('carga_admins', 'carga_admins.id', '=', 'asig_admins.id_carga')
        ->join('ciclos', 'ciclos.id', '=', 'asig_admins.id_ciclo')
        ->select('*')
        ->where([
            ['carga_admins.nombre_carga','=','Decanato'],
            ['ciclos.estado','=','activo']])
        ->first();

        $vicedecanato= DB::table('asig_admins')
        ->join('carga_admins', 'carga_admins.id', '=', 'asig_admins.id_carga')
        ->join('ciclos', 'ciclos.id', '=', 'asig_admins.id_ciclo')
        ->select('*')
        ->where([
            ['carga_admins.nombre_carga','=','Vicedecanato'],
            ['ciclos.estado','=','activo']])
        ->first();

        //fin de validad que ya ya sido validado decanato y vicedecanato
        //echo dd($empleados);
       //echo dd($empleadosC);
        return view('Admin.horarios.carga',compact('carga','empleados','empleadosC','decanato','vicedecanato'));
    }

    public function create(Request $request){
        try{

            $validator = Validator::make($request->all(),[
                'nombre_carga'      => 'required|max:255'
            ]);         

            if($validator->fails())
            {            
                return response()->json(['error'=>$validator->errors()->all()]);                
            }
        //echo dd($request);
            $carga = $request->_id ==null ? new CargaAdmin():CargaAdmin::findOrFail($request->_id);
            $carga -> nombre_carga   = $request->nombre_carga;
            $carga -> categoria        = 'ad';
            $carga -> id_jefe        = $request->jefe;
            $carga -> save();         
        
            return $request->_id != null?response()->json(['mensaje'=>'Modificación exitosa.']):response()->json(['mensaje'=>'Registro exitoso.']);
        
        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }//fin create

    public function estado(Request $request){
        $carga = CargaAdmin::findOrFail($request->_id);
        $carga -> estado = !$carga -> estado;
        $estado = $carga -> save();
        if ($estado) {
            return response()->json(['mensaje'=>'Modificacion exitosa']);
        }else{
            return response()->json(['error'=>'Error']);
        }
    }
    //servicio que me carga la GS depende del id
    public function cargaModal($id){         
        $data = CargaAdmin::select('*')
        ->findOrFail($id);
        return $data->toJson();
    }
    //fin del servicio que me carga la Gs

}

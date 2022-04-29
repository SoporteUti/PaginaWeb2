<?php

namespace App\Http\Controllers\Horarios;

use App\Http\Controllers\Controller;
use App\Models\Horarios\Carrera;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CarrerasController extends Controller
{
    public function index(){
        $deptosC = DB::table('departamentos')->get();
        //cargar datos en la table
        $ver =DB::table('carreras')
            ->join('departamentos', 'carreras.id_depto', '=', 'departamentos.id')
            ->select('carreras.*', 'departamentos.nombre_departamento')
            ->where('departamentos.estado',true)
            ->get();
        //echo dd($ver);
        //fin de cargar datos en la table
        

        return view('Admin.horarios.carreras',compact('deptosC','ver'));
    }

    public function create(Request $request){
        try{

            $validator = Validator::make($request->all(),[
                'codigo_carrera'      => 'required|max:255',
                'nombre_carrera'      => 'required|max:255',
                'modalidad_carrera'   => 'required',
                'id_depto'            => 'required'
            ]);         

            if($validator->fails())
            {            
                return response()->json(['error'=>$validator->errors()->all()]);                
            }

            $car = $request->_id ==null ? new Carrera():Carrera::findOrFail($request->_id);
            $car -> codigo_carrera   = $request->codigo_carrera;
            $car -> nombre_carrera   = $request->nombre_carrera;
            $car -> modalidad_carrera   = $request->modalidad_carrera;
            $car -> id_depto   = $request->id_depto;
            $car-> estado = true;  
            $car -> save();         
        
            return $request->_id != null?response()->json(['mensaje'=>'Modificación exitosa.']):response()->json(['mensaje'=>'Registro exitoso.']);
        
        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }//fin create

    public function estado(Request $request){
       $c  = Carrera::findOrFail($request->_id);
       $c-> estado = !$c -> estado;
        $estado = $c-> save();
        if ($estado) {
            return response()->json(['mensaje'=>'Modificacion exitosa']);
        }else{
            return response()->json(['error'=>'Error']);
        }
    }
   
}

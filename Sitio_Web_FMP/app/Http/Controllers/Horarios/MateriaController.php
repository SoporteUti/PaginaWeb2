<?php

namespace App\Http\Controllers\Horarios;

use App\Http\Controllers\Controller;
use App\Models\Horarios\Materia;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MateriaController extends Controller
{
    //
    public function index(){
        //datos para el combobox de carreras
        $carreers = DB::table('carreras')
                    ->where('estado',true)
                    ->get();
        //fin para datos de combobox
        //para las materias
        $subjects = DB::table('materias')
                    ->join('carreras','materias.id_carrera','=','carreras.id')
                    ->select('materias.*', 'carreras.nombre_carrera')
                    ->where('carreras.estado',true)
                    ->get();
      // echo dd($subjects);
        //fin de para mostrar las materias
        return view('Admin.horarios.materias',compact('carreers','subjects'));
    }

    public function administrar(Request $request){

        try{

            $validator = Validator::make($request->all(),[
                'codigo_materia' => 'required|max:255',
                'nombre_materia' => 'required|max:255',
                'id_carrera' => 'required',
                'uv_materia' => 'required',
                'nivel' => 'required',
            ]);         

            if($validator->fails())
            {            
                return response()->json(['error'=>$validator->errors()->all()]);                
            }
         // echo dd($request);
            $materias = $request->_id ==null ? new Materia():Materia::findOrFail($request->_id);
            $materias -> codigo_materia   = $request->codigo_materia;
            $materias -> nombre_materia   = $request->nombre_materia;
            $materias -> id_carrera       = $request->id_carrera;
            $materias -> uv_materia       = $request->uv_materia;
            $materias -> nivel            = $request->nivel;  
            $materias -> estado = true;  
            $materias -> save();         
        
            return $request->_id != null?response()->json(['mensaje'=>'Modificación exitosa.']):response()->json(['mensaje'=>'Registro exitoso.']);
        
        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }//para crear y modificar la materia

    public function estado(Request $request){
        $m = Materia::findOrFail($request->_id);
        $m -> estado = !$m -> estado;
        $estado = $m -> save();
        if ($estado) {
            return response()->json(['mensaje'=>'Modificacion exitosa']);
        }else{
            return response()->json(['error'=>'Error']);
        }
    }
}

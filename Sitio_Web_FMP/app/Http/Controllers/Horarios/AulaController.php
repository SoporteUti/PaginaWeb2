<?php

namespace App\Http\Controllers\Horarios;

use App\Http\Controllers\Controller;
use App\Models\Horarios\Aula;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AulaController extends Controller
{
    public function index(){
        $aulas = DB::table('aulas')->get();
        return view('Admin.horarios.aula',compact('aulas'));
    }
    //para registrar, modificar
    public function store(Request $request){
        try{

            $validator = Validator::make($request->all(),[
                'codigo_aula' => 'required|max:255',
                'nombre_aula' => 'required|max:255',
                'ubicacion_aula' => 'required|max:255',
                'capacidad_aula' => 'required|max:100|numeric',
                
            ]);         

            if($validator->fails())
            {            
                return response()->json(['error'=>$validator->errors()->all()]);                
            }

            $aula = $request->_id ==null ? new Aula():Aula::findOrFail($request->_id);
            $aula -> codigo_aula   = $request->codigo_aula; 
            $aula -> nombre_aula   = $request->nombre_aula;
            $aula -> ubicacion_aula   = $request->ubicacion_aula;
            $aula -> capacidad_aula   = $request->capacidad_aula;
            $aula-> estado = true;  
            $aula -> save();         
        
            return $request->_id != null?response()->json(['mensaje'=>'Modificación exitosa.']):response()->json(['mensaje'=>'Registro exitoso.']);
        
        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
    //fin de función para registrar, modificar

    //para dar de baja a la aula
    public function estado(Request $request){
        $a = Aula::findOrFail($request->_id);
        $a -> estado = !$a -> estado;
        $estado = $a -> save();
        if ($estado) {
            return response()->json(['mensaje'=>'Modificacion exitosa']);
        }else{
            return response()->json(['error'=>'Error']);
        }
    }
    //fin de para dar de baja aula
    //para dar de alta a la aula
    
}

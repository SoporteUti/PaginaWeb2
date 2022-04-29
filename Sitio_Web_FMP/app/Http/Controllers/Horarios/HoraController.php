<?php

namespace App\Http\Controllers\Horarios;

use App\Http\Controllers\Controller;
use App\Models\Horarios\Hora;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HoraController extends Controller
{
    //
    public function index(){
        $horas = DB::table('horas')->get();
        return view('Admin.horarios.horas',compact('horas'));
    }

    public function create(Request $request){
        try{

            $validator = Validator::make($request->all(),[
                'hora_inicio'      => 'required|unique:horas,inicio',
                'hora_final'      => 'required|unique:horas,fin'
            ]);         

            if($validator->fails())
            {            
                return response()->json(['error'=>$validator->errors()->all()]);                
            }

            $hora = $request->_id ==null ? new Hora():Hora::findOrFail($request->_id);
            $hora -> inicio   = $request->hora_inicio;
            $hora -> fin   = $request->hora_final; 
            $hora -> save();         
        
            return $request->_id != null?response()->json(['mensaje'=>'Modificación exitosa.']):response()->json(['mensaje'=>'Registro exitoso.']);
        
        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }//fin create

    public function estado(Request $request){
        $ho = Hora::findOrFail($request->_id);
        $borrar = $ho -> delete();
        if ($borrar) {
            return response()->json(['mensaje'=>'Eliminación exitosa']);
        }else{
            return response()->json(['error'=>'Error']);
        }
    }
}

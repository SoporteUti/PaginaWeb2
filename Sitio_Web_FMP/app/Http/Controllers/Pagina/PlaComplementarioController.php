<?php

namespace App\Http\Controllers\Pagina;

use App\Http\Controllers\Controller;
use App\Models\Pagina\Complementario;
use App\Models\Pagina\ContenidoHtml;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlaComplementarioController extends Controller
{
    //

    public function index(){

        $complementario = (Auth::guest()) ? 
        DB::table('complementarios')
        ->where('estado',true)
        ->get(): 
        DB::table('complementarios')
        ->select('complementarios.*')
        ->get();

        $contenido = ContenidoHtml::where('localizacion','complementarioIndex')->first();
        return view('Academicos.planComplementario',compact('complementario','contenido'));
    }

    public function store(Request $request){
        try{

            $validator = validator::make($request->all(),[
                'nombre' => 'required|max:255',
                'titulo' => 'required|max:255',
                'modalidad' => 'required|max:255',
                'asignaturas' => 'required|max:255|numeric',
                'duracion' => 'required|max:255',
                'unidades' =>'required|numeric|max:255',
                'dirigido'=>'required|max:255',
                'precio' =>'required|max:255'
            ]);         

            if($validator->fails())
            {            
                return response()->json(['error'=>$validator->errors()->all()]);                
            }

            $co = $request->_id ==null ? new Complementario():Complementario::findOrFail($request->_id);
            $co -> nombre               = $request->nombre;
            $co -> titulo               = $request->titulo;
            $co -> modalidad            = $request->modalidad;
            $co -> numero_asignatura    = $request->asignaturas;
            $co -> duracion             = $request->duracion;
            $co -> unidades_valorativas = $request->unidades;
            $co-> precio               = $request->precio;
            $co-> dirigido             = $request->dirigido;
            $co-> contenido             = $request->contenido;
            $co -> estado               = true;
            $co -> user                 = auth()->id();   
            $co -> save();         
        
            return $request->_id != null?response()->json(['mensaje'=>'Modificación exitosa.']):response()->json(['mensaje'=>'Registro exitoso.']);
        
        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
    public function destroy(Request $request)
    {
        $complementario = Complementario::findorFail(base64_decode($request->complementario),['id']);
        $complementario-> delete();
        return redirect()->route('planComp');
    }

    public function estado(Request $request)
    {
        $comple = Complementario::where('id',base64_decode($request->_id))->first();
        $comple -> estado = $comple -> estado ? false:true;
        $comple -> save();        
        return response()->json(['boton'=>$comple -> estado ? '<i class="mdi mdi-eye-off"></i> Desactivar':'<i class="mdi mdi-eye"></i> Activar']);
    }
}

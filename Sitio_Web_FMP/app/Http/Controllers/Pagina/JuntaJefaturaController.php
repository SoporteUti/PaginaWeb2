<?php

namespace App\Http\Controllers\Pagina;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Pagina\JuntaJefatura;
use Illuminate\Http\Request;

class JuntaJefaturaController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store1(Request $request){
        $validator = Validator::make($request->all(),[
            'nombre' => 'required|max:255',
            'sector' => 'required|max:255',
        ]);         

        if($validator->fails())
        {            
            return response()->json(['error'=>$validator->errors()->all()]);                
        }

        /**Guardo en base de datos */
        $juntaJefatura = $request->_id==null ? new JuntaJefatura : JuntaJefatura::findOrFail($request->_id);
        $juntaJefatura -> nombre          =  $request->nombre;        
        $juntaJefatura -> sector_dep_unid =  $request->sector; 
        $juntaJefatura -> tipo            =  0; 
        $juntaJefatura -> user            =  auth()->id();
        $juntaJefatura -> save();

        return $request->_id !=null ?response()->json(['mensaje'=>'Modificación exitosa']):response()->json(['mensaje'=>'Registro exitoso']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store2(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nombre' => 'required|max:255',
            'jefatura' => 'required|max:255',
        ]);       

        if($validator->fails())
        {            
            return response()->json(['error'=>$validator->errors()->all()]);                
        }

        
        /**Guardo en base de datos */
        $juntaJefatura = $request->_id==null ? new JuntaJefatura : JuntaJefatura::findOrFail($request->_id);
        $juntaJefatura -> nombre          =  $request->nombre;        
        $juntaJefatura -> sector_dep_unid =  $request->jefatura; 
        $juntaJefatura -> tipo            =  1; 
        $juntaJefatura -> user            =  auth()->id();
        $juntaJefatura -> save();

        return $request->_id !=null ?response()->json(['mensaje'=>'Modificación exitosa']):response()->json(['mensaje'=>'Registro exitoso']);
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function periodoJunta(Request $request){

        $periodo  = JuntaJefatura::where('nombre','periodo') -> where('tipo',2) -> get();
        
        if(count($periodo) == 0){
            $_periodo                =  new JuntaJefatura;

        }else{
            $_periodo                =  $periodo[0];           
        }
        $_periodo  -> nombre          =  'periodo';
        $_periodo -> sector_dep_unid =  nl2br($request->periodo); 
        $_periodo -> tipo            =  2; 
        $_periodo -> user            =  auth()->id();
        $_periodo -> save();
        
        return redirect('/EstructuraOrganizativa#junta');
    }
                    
    public function periodoJefatura(Request $request){

        $periodo  = JuntaJefatura::where('nombre','periodo') -> where('tipo',3) -> get();
        
        if(count($periodo) == 0){
            $_periodo                =  new JuntaJefatura;

        }else{
            $_periodo                =  $periodo[0];           
        }
        $_periodo  -> nombre          =  'periodo';
        $_periodo -> sector_dep_unid =  nl2br($request->periodo); 
        $_periodo -> tipo            =  3; 
        $_periodo -> user            =  auth()->id();
        $_periodo -> save();
        
        return redirect('/EstructuraOrganizativa#jefatura');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pagina\JuntaJefatura  $juntaJefatura
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        /**Elimino de la base de datos */        
        $juntaJefatura =  JuntaJefatura::destroy($request->_id);        
        return redirect()->route('EstructOrga');
    }
    
}

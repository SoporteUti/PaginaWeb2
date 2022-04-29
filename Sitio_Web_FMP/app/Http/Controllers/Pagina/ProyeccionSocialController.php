<?php

namespace App\Http\Controllers\Pagina;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pagina\JuntaJefatura;
use App\Models\Pagina\PDF;
use File;
use Illuminate\Support\Facades\Validator;

class ProyeccionSocialController extends Controller
{
    public function index()
    { 
        $pdfs = PDF::where('localizacion','ProyeccionSocial')->get();
        $coordinadores = JuntaJefatura::where('tipo',4)->get();
        $jefaturas  = JuntaJefatura::where('nombre','jefatura') -> where('tipo',5) -> get();
        return view('Academicos.proyeccionSocial',compact('coordinadores','pdfs','jefaturas'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeProyeccionSocial(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'coordinador' => ['required','min:3'],
            'departamento' => ['required','min:3'],
        ]); 
        if($validator->fails())
        {            
            return response()->json(['error'=>$validator->errors()->all()]);                
        }

        /**Guardo en base de datos */
        $proyeccionSocial = $request->_id == null ? new JuntaJefatura() : JuntaJefatura::findOrFail($request->_id);
       // $proyeccionSocial = new JuntaJefatura;
        $proyeccionSocial -> nombre          =  $request->coordinador;        
        $proyeccionSocial -> sector_dep_unid =  $request->departamento; 
        $proyeccionSocial -> tipo            =  4; 
        $proyeccionSocial -> user            =  auth()->id();
        $proyeccionSocial -> save();

        return $request->id !=null ?response()->json(['mensaje'=>'Modificación exitosa.']):response()->json(['mensaje'=>'Registro exitoso.']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function jefaturaProyeccionSocial(Request $request){
        $tipojefatura = 5;
        $jefatura  = JuntaJefatura::where('nombre','jefatura') -> where('tipo',$tipojefatura) -> get();
        
        if(count($jefatura) == 0){
            $_jefatura                =  new JuntaJefatura;

        }else{
            $_jefatura               =  $jefatura[0];           
        }
        $_jefatura  -> nombre          =  'jefatura';
        $_jefatura -> sector_dep_unid =  nl2br($request->jefatura); 
        $_jefatura -> tipo            =  $tipojefatura; 
        $_jefatura -> user            =  auth()->id();
        $_jefatura -> save();
        
        return redirect()->route('proyeccionSocial');
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
        JuntaJefatura::destroy($request->_id);        
        return redirect()->route('proyeccionSocial');
        
    }

    public function eliminarPDF(Request $request){
        /**busco en la base de datos */
        $_pdf = PDF::find($request->_id);

        if($_pdf != null){

            /**Elimino del servidor el pdf */
            File::delete(public_path() . '/files/pdfs/'.$_pdf->file); 

            /**Elimino de la base de datos */
            $_pdf -> delete();
        }

        /**Redirecciono a la vista de proyeccion */
        return redirect(route('proyeccionSocial').'#listaPDF');
    }
}

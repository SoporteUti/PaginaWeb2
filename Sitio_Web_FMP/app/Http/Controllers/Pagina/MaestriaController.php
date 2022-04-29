<?php

namespace App\Http\Controllers\Pagina;

use App\Http\Controllers\Controller;
use App\Models\Pagina\Maestria;
use App\Models\Pagina\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;

class MaestriaController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{

            $validator = Validator::make($request->all(),[
                'nombre' => 'required|max:255',
                'titulo' => 'required|max:255',
                'modalidad' => 'required|max:255',
                'asignaturas' => 'required|max:255|numeric',
                'duracion' => 'required|max:255',
                'unidades' =>'required|numeric|max:255',
                'precio' =>'required|max:255',
                'contenido' =>'required'
            ]);         

            if($validator->fails())
            {            
                return response()->json(['error'=>$validator->errors()->all()]);                
            }

            $ma = $request->_id ==null ? new Maestria():Maestria::findOrFail($request->_id);
            $ma -> nombre               = $request->nombre;
            $ma -> titulo               = $request->titulo;
            $ma -> modalidad            = $request->modalidad;
            $ma -> numero_asignatura    = $request->asignaturas;
            $ma -> duracion             = $request->duracion;
            $ma -> unidades_valorativas = $request->unidades;
            $ma -> precio               = $request->precio;
            $ma -> contenido            = $request->contenido;
            $ma -> estado               = true;
            $ma -> user                 = auth()->id();   
            $ma -> save();         
        
            return $request->_id != null?response()->json(['mensaje'=>'Modificación exitosa.']):response()->json(['mensaje'=>'Registro exitoso.']);
        
        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }

    /**
     * Disable the specified resource.
     *
     * @param  \App\Models\Pagina\Maestria  $maestria
     * @return \Illuminate\Http\Response
     */

    public function estado(Request $request)
    {
        $maestria = Maestria::where('id',base64_decode($request->_id))->first();
        $maestria -> estado = $maestria -> estado ? false:true;
        $maestria -> save();        
        return response()->json(['boton'=>$maestria -> estado ? '<i class="mdi mdi-eye-off"></i> Desactivar':'<i class="mdi mdi-eye"></i> Activar']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pagina\Maestria  $maestria
     * @return \Illuminate\Http\Response
     */
    public function edit(Maestria $maestria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pagina\Maestria  $maestria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Maestria $maestria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pagina\Maestria  $maestria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $maestria = Maestria::findorFail(base64_decode($request->maestria),['id']);
        $maestria -> delete();
        return redirect()->route('postgrado');
    }

    public function eliminarPDF(Request $request){
        /**busco en la base de datos */
        $_pdf = PDF::find($request->_id);

        if($_pdf != null){

            /**Elimino del servidor el pdf */
            File::delete(public_path() . '/files/pdfs/'.$request->localizacion.'/'.$_pdf->file); 

            /**Elimino de la base de datos */
            $_pdf -> delete();
        }

        /**Redirecciono a la vista de proyeccion */
        if($request->vista!=null){
            return redirect()->route($request->vista);
        }else{
            return redirect()->route('postgrado');
        }
    }
}

<?php

namespace App\Http\Controllers\Pagina;

use App\Http\Controllers\Controller;
use App\Models\Pagina\Sondeo;
use Exception;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Validator;

class SondeoController extends Controller
{
    
    public function index()
    {
        $sondeos = Sondeo::all();
        return view('Academicos.investigacion',compact('sondeos'));
    }

    public function store(Request $request)
    {
        try{        //echo dd($request->imagen);
        $validator = Validator::make($request->all(),[
            'titulo' => 'required|max:255',
            'descripcion' => 'required|max:255',
            'imagen' => 'required'
        ]);  

        if($validator->fails())
        {            
            return response()->json(['error'=>$validator->errors()->all()]);                
        }

        $sondeo = $request->_id!=null ? Sondeo::findOrFail($request->_id): new Sondeo;

        /**Guardo en carpeta Noticia */
        $file = $request->file('imagen'); 
        $path = public_path() . '/images/sondeos/';
        $fileName = $request->imagen->getClientOriginalName();
        
        /**Elimino de la carpeta del servidor si se realiza una modificacion*/
        if($request->_id != null && count($request->files)>0){
           
            File::delete(public_path() . '/images/sondeos/'.$sondeo->imagen); 
        
            /**Guardo en base de datos */   
            $sondeo -> imagen    =  $fileName;
            /**Guardo en servidor*/
            $file->move($path, $fileName);
        }else{
            $sondeo -> imagen = $sondeo -> imagen;
            $file->move($path, $fileName);
        }

        /**Guardo en la base de datos */
        $sondeo -> titulo = $request->titulo;
        if($request->imagen !=null){
            $sondeo -> imagen = $fileName;
        }
        $sondeo -> descripcion = $request->descripcion;
        $sondeo->user = auth()->id();   
        $sondeo -> save();

        return $request->_id != null?response()->json(['mensaje'=>'Modificación exitosa.']):response()->json(['mensaje'=>'Registro exitoso.']);
    }catch(Exception $e){
        return response()->json(['error'=>$e->getMessage()]);
    }
    }

    public function destroy(Request $request)
    {
        //echo dd($request);
        File::delete(public_path() . '/images/sondeos/'.Sondeo::findOrFail(base64_decode($request->_id))->imagen);
        Sondeo::destroy(base64_decode($request->_id));
         
       
        return redirect()->route('investigacion');
    }
}

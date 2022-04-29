<?php

namespace App\Http\Controllers\Pagina;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Pagina\Noticia;
use Illuminate\Http\Request;
use File;

class NoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $titulo)
    { 
        $idNoticia = base64_decode($id);
        $noticias  = Noticia::all();
        $noticia   = $noticias -> find($idNoticia);
        if($noticia != null and $noticia -> tipo){   
            return view('Inicio.Noticia', compact('noticia'));
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'titulo' => 'required|max:255',
            'contenido' => 'required',
            'imagen' => 'required|image|mimes:jpeg,png|max:2500',
        ]);         

        if($validator->fails())
        {            
            return response()->json(['error'=>$validator->errors()->all()]);                
        }

        $noticia = $request->_id == null ? new Noticia : Noticia:: findOrFail($request->_id);

        /**Guardo en carpeta Noticia */
        $file = $request->file('imagen'); 
        $path = public_path() . '/images/noticias';
        $fileName = count($request->files)? uniqid():'sin_imagen';

        /**Elimino de la carpeta del servidor si se realiza una modificacion*/
        if($request->_id != null && count($request->files)){
            if($fileName !='sin_imagen'){
                File::delete(public_path() . '/images/noticias/'.$noticia->imagen); 
            }
            /**Guardo en base de datos */   
            $noticia -> imagen    =  $fileName;
            /**Guardo en servidor*/
            $file->move($path, $fileName);
        }
        
        if($request->_id == null && count($request->files)){   
            /**Guardo en base de datos */   
            $noticia -> imagen    =  $fileName;
            /**Guardo en servidor*/
            $file->move($path, $fileName);
        } else{
            /**Guardo en base de datos */   
            $noticia -> imagen    =  $fileName;
        }

        /**Guardo en base de datos */
        $noticia -> titulo    =  $request->titulo;       
        $noticia -> tipo      =  'true'; 
        $noticia -> contenido =  $request->contenido;
        $noticia -> fuente    =  $request->fuente;        
        $noticia -> urlfuente =  $request->urlfuente;
        $noticia -> user      =  auth()->id();
        $exito = $noticia -> save();

        return $request->_id !=null ?response()->json(['mensaje'=>'Modificación exitosa.']):response()->json(['mensaje'=>'Registro exitoso.']);
    }

    public function storeurl(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'titulo' => 'required|max:200',
            'imagen' => 'required|image|mimes:jpeg,png|max:2500',
            'urlfuente' => 'required',
        ]);         

        if($validator->fails())
        {            
            return response()->json(['error'=>$validator->errors()->all()]);                
        }

        /**Guardo en carpeta Noticia */
        $file = $request->file('imagen'); 
        $path = public_path() . '/images/noticias';
        $fileName = count($request->files)? uniqid():'sin_imagen';

        $noticia = $request->_id == null ? new Noticia : Noticia:: findOrFail($request->_id);

        /**Elimino de la carpeta del servidor si se realiza una modificacion*/
        if($request->_id != null && count($request->files)){
            if($fileName !='sin_imagen')
            File::delete(public_path() . '/images/noticias/'.$noticia->imagen); 
            /**Guardo en base de datos */   
            $noticia -> imagen    =  $fileName;
            /**Guardo en servidor*/
            $file->move($path, $fileName);
        }
        
        if($request->_id == null && count($request->files)){   
            /**Guardo en base de datos */   
            $noticia -> imagen    =  $fileName;
            /**Guardo en servidor*/
            $file->move($path, $fileName);
        } else{
            /**Guardo en base de datos */   
            $noticia -> imagen    =  $fileName;
        }
        
        /**Guardo en base de datos */
        
        $noticia -> titulo    =  $request->titulo;        
        $noticia -> subtitulo =  $request->subtitulo;        
        $noticia -> imagen    =  $fileName;
        $noticia -> tipo      =  'false';  
        $noticia -> urlfuente =  $request->urlfuente;
        $noticia -> user      =  auth()->id();
        $noticia -> save();

        return $request->_id !=null ?response()->json(['mensaje'=>'Modificación exitosa.']):response()->json(['mensaje'=>'Registro exitoso.']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        /**Elimino de la carpeta del servidor */
        if(Noticia::findOrFail(base64_decode($request->_id))->imagen !='sin_imagen')
        File::delete(public_path() . '/images/noticias/'.Noticia::findOrFail(base64_decode($request->_id))->imagen); 

        /**Elimino de la base de datos */
        $noticia = Noticia::destroy(base64_decode($request->_id));

        return redirect('/#noticias');
    }
}

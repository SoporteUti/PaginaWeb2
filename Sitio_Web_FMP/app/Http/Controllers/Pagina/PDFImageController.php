<?php

namespace App\Http\Controllers\Pagina;

use App\Models\Pagina\PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use File;

class PDFImageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $localizacion)
    {
        $fileName = $request->pdf.'.pdf';
        $pdfs = PDF::where('localizacion', $localizacion)->where('file',$fileName)->get();   
        $file = $request->file('file');  
        $path = public_path() . '/files/pdfs/'.$localizacion;
        

        if(count($pdfs)==0){       
            
            /**Guardo en base de datos */
            $pdf = new PDF;
            $pdf -> file         = $fileName;
            $pdf -> localizacion = $localizacion;
            $pdf -> user         = auth()->id();
            $pdf -> save();

        }else{
            $_pdf = $pdfs[0];
            
            /**Elimino del servidor el pdf */
            File::delete(public_path() . '/files/pdfs/'.$_pdf->file); 

            /**Guardo en la base de datos */
            $_pdf -> file   =  $fileName;
            $_pdf -> user   =  auth()->id();
            $_pdf -> save();         
        }

        /**Guardo en carpeta Pdfs */
        $file->move($path, $fileName);

        return response()->json( ['boton'=>'#'.$request->pdf,'archivo'=> route('index').'/files/pdfs/'.$localizacion.'/'.$request->pdf.'.pdf']);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAll(Request $request, $localizacion)
    {
        
        $file = $request->file('file');  
        $pdfs = PDF::where('localizacion',$localizacion)->where('file', $file->getClientOriginalName())->get();   
        
        if(count($pdfs)==0){ 
            
            /**Guardo en carpeta Pdfs */
            $path = public_path() . '/files/pdfs';
            $fileName = $file->getClientOriginalName();
            $file->move($path, $fileName);
            
            /**Guardo en base de datos */
            $pdf = new PDF;
            $pdf -> file         = $fileName;
            $pdf -> localizacion = $localizacion;
            $pdf -> user         = auth()->id();
            $pdf -> save();

        }else{
            $_pdf = $pdfs[0];
            
            /**Elimino del servidor el pdf */
            File::delete(public_path() . '/files/pdfs/'.$_pdf->file); 

            /**Guardo en carpeta Pdfs */
            $path = public_path() . '/files/pdfs';
            $fileName = $file->getClientOriginalName();
            $file->move($path, $fileName);

            /**Guardo en la base de datos */
            $_pdf -> file   =  $fileName;
            $_pdf -> user   =  auth()->id();
            $_pdf -> save();         
        }

    }

    public function store1(Request $request, $localizacion)
    {
        $localizacion = base64_decode($localizacion);

        $pdfs = PDF::where('localizacion', $localizacion)->get();   
        $file = $request->file('file'); 
        if(count($pdfs)==0){ 
            
            /**Guardo en carpeta */
            $path = public_path() . '/files/image';
            $fileName = uniqid();
            $file->move($path, $fileName);
            
            /**Guardo en base de datos */
            $_img = new PDF;
            $_img -> file         = $fileName;
            $_img -> localizacion = $localizacion;
            $_img -> user         = auth()->id();
            $_img -> save();

        }else{
            $_img = $pdfs[0];
            
            /**Elimino del servidor  */
            File::delete(public_path() . '/files/image/'.$_img->file); 

            /**Guardo en carpeta */
            $path = public_path() . '/files/image';
            $fileName = uniqid();
            $file->move($path, $fileName);

            /**Guardo en la base de datos */
            $_img -> file   =  $fileName;
            $_img -> user   =  auth()->id();
            $_img -> save();         
        }

    }
    public function storeFolder(Request $request, $localizacion)
    {
        
        $file = $request->file('file');  
        $pdfs = PDF::where('localizacion',$localizacion)->where('file', $file->getClientOriginalName())->get();   
        
        if(count($pdfs)==0){ 
            
            /**Guardo en carpeta Pdfs */
            $path = public_path() . '/files/pdfs/'.$localizacion;
            $fileName = $file->getClientOriginalName();
            $file->move($path, $fileName);
            
            /**Guardo en base de datos */
            $pdf = new PDF;
            $pdf -> file         = $fileName;
            $pdf -> localizacion = $localizacion;
            $pdf -> user         = auth()->id();
            $pdf -> save();

        }else{
            $_pdf = $pdfs[0];
            
            /**Elimino del servidor el pdf */
            File::delete(public_path() . '/files/pdfs/'.$_pdf->file); 

            /**Guardo en carpeta Pdfs */
            $path = public_path() . '/files/pdfs/'.$localizacion;
            $fileName = $file->getClientOriginalName();
            $file->move($path, $fileName);

            /**Guardo en la base de datos */
            $_pdf -> file   =  $fileName;
            $_pdf -> user   =  auth()->id();
            $_pdf -> save();         
        }

    }
}

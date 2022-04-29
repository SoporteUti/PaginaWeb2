<?php

namespace App\Http\Controllers\Pagina;

use App\Http\Controllers\Controller;
use App\Models\Pagina\AudioVisual;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AudioVisualController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        $validator = Validator::make($request->all(),[
            'titulo' => 'required|max:255',
            'codigo' => 'required|max:255'
        ]);         

        if($validator->fails())
        {            
            return response()->json(['error'=>$validator->errors()->all()]);                
        }

        $av = new AudioVisual;
        $av->titulo = $request->titulo;
        $av->link = $request->codigo;
        $av -> user  =  auth()->id();
        $av->save();
        return response()->json(['mensaje'=>'Registro exitoso']);
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pagina\AudioVisual  $audioVisual
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        AudioVisual::destroy($request->_id);
        return redirect()->route('admonAcademica');
    }
}

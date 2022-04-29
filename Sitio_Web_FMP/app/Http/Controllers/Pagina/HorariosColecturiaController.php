<?php

namespace App\Http\Controllers\Pagina;

use App\Http\Controllers\Controller;
use App\Models\Pagina\HorariosColecturia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HorariosColecturiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function horariosColecturia()
    {   
        return (Auth::guest()) ?  
            DB::select("select hc.title ,hc.inicio as start , hc.final as end, '#AA0000' as color from horarios_colecturias hc"):
            DB::select("select hc.id, hc.title ,hc.inicio as start , hc.final as end, '#AA0000' as color, hc.final from horarios_colecturias hc");
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
            'hora_inicio' => 'required',
            'fecha_inicio' =>'required',
            'fecha_final' =>'required|after_or_equal:fecha_inicio',
        ]);         

        if($validator->fails())
        {            
            return response()->json(['error'=>$validator->errors()->all()]);                
        }
         
        $hc = $request->_id == null ? new horariosColecturia : horariosColecturia::findOrFail($request->_id);
        $hc->title = $request->titulo;
        $hc->inicio = $request->fecha_inicio.' '.$request->hora_inicio;
        $hc->final = $request->fecha_final.' '.$request->hora_inicio;
        $hc->user = auth()->id();
        $hc->save();

        return  
            $request->_id !=null ? 
            response()->json(['mensaje'=>'Modificación exitosa']):
            response()->json(['mensaje'=>'Registro exitoso']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pagina\HorariosColecturia  $horariosColecturia
     * @return \Illuminate\Http\Response
     */
    public function show(HorariosColecturia $horariosColecturia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pagina\HorariosColecturia  $horariosColecturia
     * @return \Illuminate\Http\Response
     */
    public function edit(HorariosColecturia $horariosColecturia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pagina\HorariosColecturia  $horariosColecturia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HorariosColecturia $horariosColecturia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pagina\HorariosColecturia  $horariosColecturia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        HorariosColecturia::destroy($request->_id);
    }
}

<?php

namespace App\Http\Controllers\Pagina;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Pagina\ImagenesCarrusel;
use App\Models\Pagina\ContenidoHtml;

class PostgradoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $imagenConvocatoria = ImagenesCarrusel::where('tipo',2)->get();
        $maestrias = (Auth::guest()) ? 
        DB::table('maestrias')
        ->select('maestrias.*')
        ->where('estado',true)
        ->get(): 
        DB::table('maestrias')
        ->select('maestrias.*')
        ->get();
        $contenido = ContenidoHtml::where('localizacion','postgradoIndex')->first();
        return view('Academicos.postgrado',compact('maestrias','imagenConvocatoria','contenido'));

    }

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pagina\Maestria  $maestria
     * @return \Illuminate\Http\Response
     */
    public function show(Maestria $maestria)
    {
        //
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
    public function destroy(Maestria $maestria)
    {
        //
    }
}

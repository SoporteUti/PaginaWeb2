<?php

namespace App\Http\Controllers\Pagina;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pagina\PDF;
use App\Models\Pagina\JuntaJefatura;

class EstructuraOrganizativaController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $junta         = JuntaJefatura::where('tipo',0)->orderBy("created_at",'asc')->get();
        $jefaturas     = JuntaJefatura::where('tipo',1)->orderBy("created_at",'asc')->get();

        $periodoJunta     = JuntaJefatura::where('nombre','periodo') -> where('tipo',2) -> get();
        $periodoJefatura  = JuntaJefatura::where('nombre','periodo') -> where('tipo',3) -> get();

        $organigrama   = PDF::where('localizacion','organigrama')->get();

        return view('Nosotros.estructuraOrganizativa', 
            compact('organigrama','junta','jefaturas','periodoJunta','periodoJefatura'));     
    }
}

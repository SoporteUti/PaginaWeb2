<?php

namespace App\Http\Controllers\Pagina;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pagina\PDF;
use App\Models\Pagina\ImagenesCarrusel;
use App\Models\Pagina\ContenidoHtml;

class Academicos extends Controller
{
    public function indexAgro()
    {
        $pdfs = PDF::where('localizacion','ccAgro')->get();
        return view('Academicos.cienciasAgronomicas',compact('pdfs'));
    }

    public function indexEcono()
    {
        $pdfs = PDF::where('localizacion','ccEco')->get();
        return view('Academicos.cienciasEconomicas',compact('pdfs'));
    }

    public function indexEdu()
    {
        $pdfs = PDF::where('localizacion','ccEdu')->get();
        return view('Academicos.cienciasEducacion',compact('pdfs'));
    }

    public function indexInfor()
    {
        $pdfs = PDF::where('localizacion','info')->get();
        return view('Academicos.informatica',compact('pdfs'));
    }
    
    public function indexAdmonAcademica(){
        $calendarioAcaIMG = PDF::where('localizacion','calendarioAca')->first();
        $imagenAcademica = PDF::where('localizacion','imagenAcademica')->first();
        $carrusel = ImagenesCarrusel::where('tipo',10)->get();
        return view('Academicos.administracionAcademica',compact('imagenAcademica','calendarioAcaIMG','carrusel'));
    }
    
}

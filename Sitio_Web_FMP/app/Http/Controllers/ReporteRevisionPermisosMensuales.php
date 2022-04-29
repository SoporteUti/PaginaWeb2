<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class ReporteRevisionPermisosMensuales extends Controller
{
    //
    public function PDF(){

        $pdf = \PDF::loadView('revisionMensual');
       return $pdf->download('RevisionMensual.pdf');
    }

  
}

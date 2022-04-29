<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BitacoraController extends Controller{

    public function index(Request $request){
        if ($request->ajax()) {
            $data = Bitacora::latest('created_at')->get();

            return DataTables::of($data)
                ->editColumn('created_at', function ($item) {
                    return date('d/m/Y h:i:s a', strtotime($item->created_at));
                })
                ->make(true);
        }
        return view('Seguridad.Bitacora.index');
    }

}

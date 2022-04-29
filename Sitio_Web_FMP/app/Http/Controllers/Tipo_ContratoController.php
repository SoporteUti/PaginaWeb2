<?php

namespace App\Http\Controllers;

use App\Models\_UTILS\Utilidades;
use App\Models\Tipo_Contrato;
use App\Models\Tipo_Jornada;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class Tipo_ContratoController extends Controller{
    public $modulo = 'Tipo de Contratos';

    public $rules = [
        'tipo' => 'required|string',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $tcontrato = Tipo_Contrato::where('estado', 'activo')->get();
        return view('Tipo_Contrato.index', compact('tcontrato'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('Tipo_Contrato.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        /**Guardo en base de datos */
        try {
            $validator = Validator::make($request->all(), $this->rules);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->all()]);
            }
            $requestData = $request->except(['_id']);
            if (strcmp($request->_id, '') == 0) {
                $msg = 'Registro exitoso.';
                $tipo = Tipo_Contrato::create($requestData);
                Utilidades::fnSaveBitacora('Nuevo Tipo #: ' . $tipo->id, 'Registro', $this->modulo);
            } else {
                $msg = 'Modificación exitoso.';
                $tipo = Tipo_Contrato::findOrFail($request->_id);
                $tipo->update($requestData);
                Utilidades::fnSaveBitacora('Tipo #: ' . $tipo->id, 'Modificación', $this->modulo);
            }
            return response()->json(['mensaje' => $msg]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tipo_Contrato  $tipo_Contrato
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        return Tipo_Contrato::findOrFail($id);
    }

    public function destroy($id){
        $tipo = Tipo_Contrato::findOrFail($id);
        $tipo->update([
            'estado' => 'inactivo'
        ]);
        Utilidades::fnSaveBitacora('Tipo #: ' . $tipo->id, 'Eliminación', $this->modulo);
        return redirect('admin/tcontrato')->with('bandera', 'Registro eliminado con éxito');
    }
}

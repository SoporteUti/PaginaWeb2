<?php

namespace App\Http\Controllers;

use App\Models\Horarios\Ciclo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\_UTILS\Utilidades;

class CicloController extends Controller
{

    public $modulo = 'Ciclos';

    public $rules = [
        'nombre' => 'required|string',
        'año' => 'required|string',
    ];

    public function index(Request $request)
    {
        $ciclo = Ciclo::orderBy('id', 'DESC')->get();
        return view('Ciclo.index', compact(['ciclo']));

    }

    public function store(Request $request)
    {
        /**Guardo en base de datos */
        try {
            $validator = Validator::make($request->all(), $this->rules);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->all()]);
            }
            $requestData = $request->except(['_id']);
            if( strcmp($request->_id, '')==0){
                $msg = 'Registro exitoso.';
                $ciclo = Ciclo::create($requestData);
                Utilidades::fnSaveBitacora('Nuevo Ciclo #: ' . $ciclo->id.' Título: '.$ciclo->nombre, 'Registro', $this->modulo);
            }else{
                $msg = 'Modificación exitoso.';
                $ciclo = Ciclo::findOrFail($request->_id);
                $ciclo->update($requestData);
                Utilidades::fnSaveBitacora('Ciclo #: ' . $ciclo->id.' Título: '.$ciclo->nombre, 'Modificación', $this->modulo);
            }
            return response()->json(['mensaje' => $msg]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        return Ciclo::findOrFail($id);

    }

    public function destroy($id)
    {
        $tipo = Ciclo::findOrFail($id);
        $tipo->update([
            'estado' => 'inactivo'
        ]);
        Utilidades::fnSaveBitacora('Ciclo #: ' . $tipo->id, 'Eliminación', $this->modulo);
        return redirect('admin/ciclo')->with('bandera', 'Registro eliminado con éxito');

    }

    public function finalizar($id){
        $tipo = Ciclo::findOrFail($id);
        $tipo->update([
            'estado' => 'finalizado'
        ]);
        Utilidades::fnSaveBitacora('Ciclo #: ' . $tipo->id, 'Finalización', $this->modulo);
        return redirect('admin/ciclo')->with('bandera', 'Ciclo Finalizado con éxito');
    }

    public function reactivar($id){
        $tipo = Ciclo::findOrFail($id);
        $tipo->update([
            'estado' => 'activo'
        ]);
        Utilidades::fnSaveBitacora('Ciclo #: ' . $tipo->id, 'Reactivado', $this->modulo);
        return redirect('admin/ciclo')->with('bandera', 'Ciclo Reactivado con éxito');
    }
}

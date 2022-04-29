<?php

namespace App\Http\Controllers\Pagina;

use App\Http\Controllers\Controller;
use App\Models\Pagina\Directorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DirectorioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $directorio = Directorio::all();
        return view('Nosotros.directorio',compact('directorio'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'nombre' => 'required',
            'contacto' => 'required',
        ]);         
        if($validator->fails())
        {            
            return response()->json(['error'=>$validator->errors()->all()]);                
        }
        
        $directorio = $request->_id == null ? new Directorio() : Directorio::findOrFail($request->_id);
        $directorio -> nombre = $request->nombre;
        $directorio -> contacto = $request->contacto;
        $directorio -> user =  auth()->id();
        $exito = $directorio->save();

        return $request->_id !=null ?response()->json(['mensaje'=>'Modificación exitosa.']):response()->json(['mensaje'=>'Registro exitoso.']);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pagina\Directorio  $directorio
     * @return \Illuminate\Http\Response
     */
    public function show(Directorio $directorio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pagina\Directorio  $directorio
     * @return \Illuminate\Http\Response
     */
    public function edit(Directorio $directorio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pagina\Directorio  $directorio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Directorio $directorio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pagina\Directorio  $directorio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request){
        Directorio::destroy($request->_id);
        return redirect()->route('directorio');
    }
}

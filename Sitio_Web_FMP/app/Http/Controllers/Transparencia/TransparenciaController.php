<?php

namespace App\Http\Controllers\Transparencia;

use App\Http\Controllers\Controller;
use App\Models\_UTILS\Utilidades;
use App\Models\Transparencia\Transparencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class TransparenciaController extends Controller{
    public $modulo = 'Transparencia';
    public $categorias = array(
        'Marco Normativo' => 'marco-normativo',
        'Marco de Gestión' => 'marco-gestion',
        'Marco Presupuestario' => 'marco-presupuestario',
        'Repositorios' => 'repositorios',
        'Documentos de Junta Directiva' => 'documentos-JD'
    );

    public $subcategorias = ['acuerdos', 'agendas', 'actas'];

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('transparencia-roles');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $categoria){
        $titulo = array_search($categoria, $this->categorias, true);

        //para validar que existe la categoria en el listado y no genere error
        if($titulo!=false){
            if ($request->ajax()) {
                $data = Transparencia::where('estado','activo')
                                    ->where('categoria', $categoria)
                                    ->latest('created_at')
                                    ->get();

                return DataTables::of($data)
                    ->addColumn('descripcion', 'Transparencia.dataTable.descripcion')
                    ->addColumn('publicar', 'Transparencia.dataTable.publicar')
                    ->addColumn('action', 'Transparencia.dataTable.actions')
                    ->editColumn('created_at', function ($data_rem) {
                        return date('d/m/Y h:i:s a', strtotime($data_rem->created_at));
                    })
                    ->rawColumns(['action', 'publicar', 'descripcion'])
                    ->make(true);
            }
            return view('Transparencia.index', compact(['categoria', 'titulo']));
        }else{
            return abort(404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($categoria){
        $titulo = array_search($categoria, $this->categorias, true);

        if($titulo!=false){
            $subcategorias = $this->subcategorias;
            return view('Transparencia.create', compact('categoria', 'titulo', 'subcategorias'));
        }else{
            return abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($categoria, Request $request){
        $campos = [
            'titulo' => 'required',
            "documento" => "required|mimes:pdf",
        ];
        $this->validate($request, $campos);
        $requestData = $request->all();
        if ($request->hasFile('documento'))
            $requestData['documento'] = $request->file('documento')->store('uploads/transparencia', 'public');

        $doc = Transparencia::create($requestData);
        Utilidades::fnSaveBitacora('Nuevo documento Titulo: ' . $doc->titulo , 'Registro', $this->modulo);
        return redirect('admin/transparencia/' . $request->categoria)->with('flash_message', 'Documento almacenado con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id){
    //     $transparencia = Transparencia::findOrFail($id);
    //     return view('Transparencia.show', compact('transparencia'));
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($categoria, $id){
        $transparencia = Transparencia::findOrFail($id);
        $titulo = array_search($categoria, $this->categorias, true);
        $subcategorias = $this->subcategorias;

        return $titulo!=false
                ? view('Transparencia.edit', compact(['transparencia', 'categoria','titulo', 'subcategorias']))
                : abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($categoria, Request $request, $id){
        $transparencia = Transparencia::findOrFail($id);

        $campos = [
            'titulo' => 'required',
        ];
        //Comprobar si el usuario desea modificar el documento
        if (isset($request->modificar_doc) && $request->modificar_doc==true)
            $campos['documento'] = "required|mimes:pdf";

        // validar los campos
        $this->validate($request, $campos);
        $requestData = $request->all();
        if ($request->hasFile('documento')) {
            //Verificar si tiene un documento para eliminarlo
            $doc = $transparencia->documento;
            $path = public_path('storage').'/'.$doc;
            if(!is_null($doc) && !empty($doc)){
                if(File::exists($path)){
                    File::delete($path);
                }
            }
            $requestData['documento'] = $request->file('documento')->store('uploads/transparencia', 'public');
        }

        $transparencia->update($requestData);
        Utilidades::fnSaveBitacora('Documento Titulo: ' . $transparencia->titulo, 'Modificación', $this->modulo);
        return redirect('admin/transparencia/' . $request->categoria)->with('flash_message', 'Documento modificado con éxito!');
    }

    public function publicar($categoria, $id, Request $request){
        $transparencia = Transparencia::findOrFail($id);
        $publicar = (isset($request->publicar)) ? 'publicado' : 'sin publicar';
        $transparencia->update([
            'publicar' => $publicar
        ]);
        $categoria = $transparencia->categoria;

        Utilidades::fnSaveBitacora('Cambio de estado público al documento del Titulo: ' . $transparencia->titulo. ' nuevo estado: '.$publicar, 'Modificación', $this->modulo);
        return redirect('admin/transparencia/' . $categoria)->with('flash_message', 'Documento modificado con éxito!');
    }


    public function file($categoria, $id){
        $transparencia = Transparencia::findOrFail($id);
        $exist = false;
        $doc = $transparencia->documento;
        $path = public_path('storage') . '/' . $doc;
        if (!is_null($doc) && !empty($doc)) {
            if (File::exists($path)) {
                $exist = true;
                $path = asset('storage').'/'.$doc;
            }else{
                $path = false;
            }
        }

        return response()->json([
            'existe' => $exist,
            'path' => $path
        ]);

    }


}

<?php

namespace App\Http\Controllers\Transparencia;

use App\Http\Controllers\Controller;
use App\Models\Transparencia\Directorio;
use App\Models\Transparencia\Transparencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FacadesFile;
use Yajra\DataTables\DataTables;

class TransparenciaWebController extends Controller{

    public $categorias = array(
        'Marco Normativo' => ['ruta' => 'marco-normativo', 'subcategorias' => []],
        'Marco de Gestión' => ['ruta' => 'marco-gestion', 'subcategorias' => ['Directorios' => ['ruta_personalizada' =>'transparencia-directorios']]],
        'Marco Presupuestario' => ['ruta' => 'marco-presupuestario', 'subcategorias' => []],
        'Repositorios' => ['ruta' => 'repositorios', 'subcategorias' => []],
        'Documentos de Junta Directiva' => ['ruta'=> 'documentos-JD', 'subcategorias' => ['acuerdos' => ['ruta_personalizada' => null ] , 'agendas' => ['ruta_personalizada' => null], 'actas' => ['ruta_personalizada' => null]]]
    );

    public function titulos(){
        $categorias = $this->categorias;
        $rutas = array_column($categorias, 'ruta');
        $titulos = array_keys($categorias);
        $combinados = array_combine($titulos, $rutas);
        return $combinados;
    }

    public function index(){
        $categorias = $this->categorias;
        return view('index-transparencia', compact(['categorias']));
    }

    public function categoria($categoria, Request $request){
        $categorias = $this->categorias;
        $titulos = $this->titulos();
        $titulo = array_search($categoria, $titulos, true);

        if($titulo!=false){
            $perPage = 5;
            $query = Transparencia::where('estado', 'activo')
                ->where('publicar', 'publicado')
                ->where('categoria', $categoria);

            $resultados = $query->count();
            $documentos = $query->latest()->paginate($perPage);
            return view('Transparencia-web.documentos', compact(['documentos', 'categoria', 'titulo', 'resultados', 'categorias']));
        } else {
            return abort(404);
        }
    }

    public function subcategoria($categoria, $subcategoria, Request $request){
        $categorias = $this->categorias;
        $titulos = $this->titulos();
        $titulo = array_search($categoria, $titulos, true);

        if($titulo!=false){
            $perPage = 5;
            $query = Transparencia::where('estado', 'activo')
                ->where('publicar', 'publicado')
                ->where('subcategoria', $subcategoria)
                ->where('categoria', $categoria);

            $resultados = $query->count();
            $documentos = $query->latest()->paginate($perPage);
            return view('Transparencia-web.documentos', compact(['documentos', 'subcategoria' , 'categoria', 'titulo', 'resultados', 'categorias']));
        } else {
            return abort(404);
        }
    }


    public function documento($categoria, $id){
        $categorias = $this->categorias;
        $titulos = $this->titulos();
        $titulo = array_search($categoria, $titulos, true);

        if($titulo!=false){
            $documento = Transparencia::findOrFail($id);
            $documentos = Transparencia::where('estado', 'activo')
                ->where('categoria', $categoria)
                ->where('id', '!=', $documento->id)
                ->take(10)
                ->latest()
                ->get();
            return view('Transparencia-web.documento', compact(['documentos', 'categoria', 'documento', 'titulo']));
        } else {
            return abort(404);
        }
    }

    public function download($id){
        $msg = 'Fallo al descargar el archivo, no se encontro...!';
        $registro = Transparencia::findOrFail($id);
        $headers = array('Content-Type: application/pdf');
        $name = strtolower(preg_replace('([^A-Za-z0-9])', '', $registro->titulo));
        $pdf = public_path('storage').'/'.$registro->documento;
        return (FacadesFile::exists($pdf))
            ? response()->download($pdf, $name, $headers)
            : back()->with(['mensaje'=>$msg, 'tipo'=>'warning']);
    }

    public function busqueda(Request $request){
        $categorias = $this->categorias;
        $categoria = $request->category;
        $subcategoria = $request->subcategory;
        $busqueda = $request->search;
        $start = $request->start;
        $end = $request->end;
        $perPage = 5;

        $query = Transparencia::where('estado', 'activo');

        //Filtrar por categoria
        if(!empty($categoria) && strcmp('categoria',strtolower($categoria))!==0)
            $query->where('categoria', $categoria);
        //Filtrar por subcategoria siempre y cuando sea categoria Documentos-JD
        if(!empty($subcategoria) && strcmp('sub categoria',strtolower($subcategoria))!==0 && strcmp('documentos-jd', strtolower($categoria)) == 0)
            $query->where('subcategoria', $subcategoria);

        //filtrar por cuadro de texto
        if (!empty($busqueda)){
            $query->where('titulo', 'LIKE', "%$busqueda%")
                ->orwhere('descripcion', 'LIKE', "%$busqueda%");
        }

        //Filtrar por rango de fechas
        if(!empty($start) && !empty($end))
            $query->WhereBetween('created_at', [$start, $end]);


        $resultados = $query->count();
        $documentos = $query->latest()->paginate($perPage);

        return view('Transparencia-web.busqueda', compact(['documentos', 'resultados', 'categoria', 'categorias', 'subcategoria', 'busqueda' ,'start', 'end']));
    }

    public function datatable($categoria, Request $request){
        if ($request->ajax()) {
            $data = Transparencia::where('estado', 'activo')
                ->where('publicar','publicado')
                ->where('categoria', $categoria)
                ->latest('created_at')
                ->get();
            return DataTables::of($data)
                ->addColumn('action', 'Transparencia-web.dataTable.download')
                ->addColumn('titulo', 'Transparencia-web.dataTable.link')
                ->addColumn('descripcion', 'Transparencia-web.dataTable.description')
                ->editColumn('created_at', function ($data_rem) {
                    return date('d/m/Y h:i:s a', strtotime($data_rem->created_at));
                })
                ->rawColumns(['action','titulo', 'descripcion'])
                ->make(true);
        }
    }

    public function directorios(){
        $directorios = Directorio::where('estado', 'activo')->get();
        return view('Transparencia-web.directorio', compact(['directorios']));
    }

}

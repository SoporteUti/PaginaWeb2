<?php

namespace App\Http\Controllers\General;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tipo_Contrato;
use App\Models\Tipo_Jornada;
use App\Models\General\Empleado;
use App\Models\General\CategoriaEmpleado;
use App\Models\Horarios\Departamento;
use Illuminate\Support\Facades\Validator;
use File;
class EmpleadoController extends Controller
{
    function index(){

        $categorias=CategoriaEmpleado::orderBy('id')->get();
        $departamentos=Departamento::orderBy('id')->get();
        $tcontrato=Tipo_Contrato::orderBy('id')->get();
        $tjornada=Tipo_Jornada::orderBy('id')->get();

        $empleados = Empleado::orderBy('id')
        ->join('categoria_empleados','categoria_empleados.id','=','empleado.categoria')
        ->join('tipo_contrato','tipo_contrato.id','=','empleado.id_tipo_contrato')
        ->join('tipo_jornada','tipo_jornada.id','=','empleado.id_tipo_jornada')
        ->join('departamentos','departamentos.id','=','empleado.id_depto')
        ->select('empleado.*', 'categoria_empleados.categoria as categoria','tipo_contrato.tipo as contrato'
                ,'tipo_jornada.tipo as jornada','departamentos.nombre_departamento as departamento')
        ->get();

        //$jefesEmpleados = Empleado::join 
        
        return view('General.Empleado',compact(
            'empleados','departamentos','tjornada','tcontrato','categorias'));
    }

    public function store (Request $request){

       
        $validator = Validator::make($request->all(),[
            'nombre' => 'required|max:25',
            'apellido' => 'required|max:20',
            'dui' => 'required|max:10',
            'foto' => 'image|mimes:jpeg,jpg,png|max:3000',
            'telefono' => 'max:9',
            'categoria' => 'required',
            'tipo_contrato' => 'required',
            'tipo_jornada' => 'required',
            'salario' => 'required',
            'departamento' => 'required',
            'tipo_empleado'=>'required',
        ]);


        if($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()->all()]);

        }
        $foto = $request->file('foto'); 

        $empleado = Empleado::updateOrCreate(
            ['id'=>$request->_id],
            ['nombre'=>$request->nombre,
            'apellido'=>$request->apellido,
            'dui'=>$request->dui,
            'salario'=>str_replace('',',',$request->salario),
            'nit'=>$request->nit,
            'telefono'=>$request->telefono,
            'categoria'=>$request->categoria,
            'id_tipo_contrato'=>$request->tipo_contrato,
            'id_tipo_jornada'=>$request->tipo_jornada,
            'jefe'=>$request->jefe,
            'id_depto'=>$request->departamento,
            'tipo_empleado'=>$request->tipo_empleado,]
        );
    
        if(!is_null($foto)){
            $ruta=public_path() . '/images/fotos';
            $nombreUnico = uniqid().$request->file('foto')->getClientOriginalName();
            File::delete($ruta.'/'.$empleado->urlfoto);
            $request->file('foto')->move($ruta,$nombreUnico);
            $empleado->urlfoto = $nombreUnico;
            $empleado->save();
        }

        return $request->_id != null ?
        response()->json(['mensaje'=>'Modificación exitosa.']):
        response()->json(['mensaje'=>'Registro exitoso.']);
 
    }

    public function empleado($id){
        $e = Empleado::select('nombre','apellido','dui','nit','telefono as tel',
        'urlfoto','tipo_empleado as tipo','jefe','salario',
        'id_depto as depto','categoria','id_tipo_jornada as jornada','id_tipo_contrato as contrato')
        ->findOrFail($id);
        if($e->urlfoto!=null)
            $e->urlfoto = asset('/images/fotos/'.$e->urlfoto);
        return $e->toJSON();
    }

    public function empleadoEstado(Request $request){
        $u = Empleado::findOrFail($request->_id);
        $u -> estado = !$u -> estado;
        $estado = $u -> save();
        if ($estado) {
            return response()->json(['mensaje'=>'Modificacion exitosa']);
        }else{
            return response()->json(['error'=>'Error']);
        }
    }

    public function categoriaStore(Request $request){
        $validator = Validator::make($request->all(),[
            'categoria' => 'required|min:2',
        ]);

        if($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()->all()]);

        }

        $cat = $request->_id != null ? CategoriaEmpleado::findOrFail($request->_id):new CategoriaEmpleado;
        $cat -> categoria = $request->categoria;
        $cat -> save();
        return $request->_id != null ?
        response()->json(['code'=>200, 'mensaje'=>'Categoria Modificada','data' => $cat], 200):
        response()->json(['code'=>200, 'mensaje'=>'Categoria registrada','data' => $cat], 200);
    }

    public function categoriaDestroy(Request $request){
        $emp = Empleado::where('categoria',$request->_id)->get();
        if(count($emp)>0){
            return response()->json(['error'=>['No se puede eliminar esta categoria']]);
        }else{
            $cat = CategoriaEmpleado::destroy($request->_id);
            return response()->json(['code'=>200, 'mensaje'=>'Categoria eliminada ']);
        }
    }

    public function categoriaGet(){
        return CategoriaEmpleado::select('id','categoria')->get()->toJSON();
    }

    public function categoriaGetObjeto($id){
        return CategoriaEmpleado::select('id','categoria')->where('id',$id)->first()->toJSON();
    }

}

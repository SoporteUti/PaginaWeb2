<?php

namespace App\Http\Controllers\Licencias;

use App\Http\Controllers\Controller;
use App\Models\General\Empleado;
use App\Models\Licencias\Permiso;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ConstanciaOlvidoController extends Controller
{
    public function index(){
        $data =  Permiso::selectRaw('md5(permisos.id::text) as identificador,permisos.empleado, CONCAT(empleado.nombre,\' \',empleado.apellido) e_nombre, to_char(permisos.fecha_uso, \'DD/MM/YYYY\') inicio,
        to_char(permisos.fecha_presentacion,\'DD/MM/YYYY\') fin, permisos.justificacion, permisos.tipo_permiso, permisos.hora_inicio,permisos.estado, permisos.fecha_presentacion, permisos.olvido,permisos.fecha_uso')
        ->join('empleado','empleado.id','=','permisos.empleado')
        ->where('empleado.id',auth()->user()->empleado)
        ->whereRaw('tipo_permiso=\'Const. olvido\'')
        ->get();
      //echo dd($data);
        $logueado= Empleado::findOrFail(auth()->user()->empleado);
        return view('Licencias.ConstanciaOlvido', compact('logueado','data'));
    }

    protected function obtenerDia($fecha){
        $dias = array('Lunes','Martes','Miércoles','Jueves','Viernes','Sabado','Domingo');
        $dia = $dias[(date('N', strtotime($fecha))) - 1];
        return $dia;
    }

    public function SalidaEntrada($fecha){
            $query = DB::table('empleado')
            ->join('jornada','empleado.id','=','jornada.id_emp')
            ->join('jornada_items','jornada_items.id_jornada','=','jornada.id')
            ->where([['empleado.estado',true],
                    ['empleado.id',auth()->user()->empleado],
                    ['jornada_items.dia', $this->obtenerDia($fecha)]]);

            return $query->get()->toJson();
    }//onChange modal

       //CODIGO PARA INSERTAR, MODIFICAR
       public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'fecha' => 'required|date|date_format:Y-m-d',
                'hora' => 'required',
                'marcaje' => 'required',
                'justificación' => 'required|min:5|string',
            ]);         

            if($validator->fails())
            {            
                return response()->json(['error'=>$validator->errors()->all()]);                
            }

            $p = $request->_id == null ? new Permiso():Permiso::whereRaw('md5(id::text) = ?',[$request->_id])->first();
            $p -> tipo_permiso = 'Const. olvido';
            $p -> fecha_uso = $request-> fecha;//fecha_uso ocupo para la fecha que se le olvido marcar
            $p -> fecha_presentacion = $request->fecha;//ocupo fecha de uso
            $p -> hora_inicio = $request->hora;//la hora que se olvido marcar ya se de entrada o salida
            $p -> hora_final = '00:00:00';//va en este formato por que para estas constancia solo se ocupa una fecha
            $p -> justificacion = $request-> justificación;
            $p -> empleado = $p -> empleado = auth()->user()->empleado;
            $p -> estado = $request->estadoConstancia;
            $p -> olvido = $request->marcaje;

            $p ->save();      

            return $request->_id != null?
            response()->json(['mensaje'=>'Modificación exitosa']):
            response()->json(['mensaje'=>'Registro exitoso']);
        
        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }//fin create

    public function Table(){
        $data =  Permiso::selectRaw('permisos.id,permisos.empleado, CONCAT(empleado.nombre,\' \',empleado.apellido) e_nombre, to_char(permisos.fecha_uso, \'DD/MM/YYYY\') inicio,
        to_char(permisos.fecha_presentacion,\'DD/MM/YYYY\') fin, permisos.justificacion, permisos.tipo_permiso, permisos.hora_inicio,permisos.estado, permisos.fecha_presentacion')
        ->join('empleado','empleado.id','=','permisos.empleado')
        ->where('empleado.id',auth()->user()->empleado)
        ->whereRaw('tipo_permiso=\'Const. olvido\'')
        ->get()->toJson();
        return $data;
        //echo dd($data);
    }//para mostrar en la tabla

    public function modal($id){     
        if(Auth::check() and !is_null($id)){
            return Permiso::selectRaw('md5(id::text) as permiso, tipo_representante, tipo_permiso, fecha_uso,
                    fecha_presentacion,to_char(hora_inicio,\'HH24:MI\') as hora_inicio
                    ,to_char(hora_final,\'HH24:MI\') as hora_final,justificacion,observaciones,estado,olvido')
            ->whereRaw('empleado = ? and md5(permisos.id::text) = ? and tipo_permiso = ?',[auth()->user()->empleado, $id,'Const. olvido'])
            ->first()->toJSON();
        }else {
            return redirect()->route('index');
        }
        
    }

    public function cancelar(Request $request){
        if(Auth::check() and isset($request)){
            Permiso::select('estado','id')
                ->whereRaw('md5(id::text) = ?',[$request->_id])
                ->first()
                ->delete();
            return redirect()->route('olvido');
        }else {
            return redirect()->route('index');
        }
    }

}

<?php

namespace App\Http\Controllers\Licencias;

use App\Models\General\Empleado;
use App\Models\Licencias\Permiso;
use App\Models\Licencias\Permiso_seguimiento;
use App\Http\Controllers\Controller;
use App\Exports\LicenciaExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;


class LicenciasJefeRRHHController extends Controller
{
    public function isJefe(){
        return DB::table('permisos')->where('jefatura',auth()->user()->empleado)->exists();
    }

    public function indexJefe(){
        if(Auth::check() && ($this->isJefe() || @Auth::user()->hasRole('super-admin'))){
            $permisos = Permiso::selectRaw('
            md5(permisos.id::text) as permiso, 
            permisos.tipo_permiso, 
            permisos.fecha_uso,
            permisos.fecha_presentacion,
            permisos.hora_inicio,
            permisos.hora_final,
            permisos.justificacion,
            permisos.observaciones,
            permisos.olvido,
            empleado.nombre,
            permisos.estado,
            empleado.apellido')
            ->join('empleado','empleado.id','=','permisos.empleado')
            ->where('jefatura',auth()->user()->empleado)
            ->where(
                function($query){
                    $query->where('permisos.estado','!=','Aceptado')
                    ->orWhere('permisos.estado','like','Enviado a Jefatura')
                    ->orWhere('permisos.estado','like','Enviado a RRHH');
            })->get();
           // echo dd($permisos);
            return view('Licencias.LicenciaJefe', compact('permisos'));
        }else {
            return redirect()->route('index');
        }
    }

    public function indexRRHH(){
        if(Auth::check() && (@Auth::user()->hasRole('Recurso-Humano')|| @Auth::user()->hasRole('super-admin'))){
            $tipo_contrato = DB::table('tipo_contrato')->select('id','tipo')->get();
            $años = Permiso::selectRaw('distinct to_char(permisos.fecha_uso, \'YYYY\') as año')->get();
            $departamentos = DB::table('departamentos')->select('id','nombre_departamento')->get();
            /*$permisos = Permiso::selectRaw('md5(permisos.id::text) as permiso, 
                tipo_permiso, fecha_uso,fecha_presentacion,hora_inicio,hora_final,justificacion,
                observaciones,olvido,empleado.nombre,empleado.apellido')
                ->join('empleado','empleado.id','=','permisos.empleado')
                ->where(function($query)
                    {$query->where('permisos.estado','like','Enviado a RRHH')
                        ->orWhere('permisos.estado','like','Aceptado');}
                )->get();*/
            return view('Licencias.LicenciaRRHH',compact('años','tipo_contrato','departamentos'));
        }else {
            return redirect()->route('index');
        }
    }

    public function datableRRHHJson($depto, $mes, $anio){

        $permisos = Permiso::selectRaw('md5(permisos.id::text) as permiso, 
                tipo_permiso, fecha_uso,fecha_presentacion,hora_inicio,hora_final,justificacion,permisos.estado,
                observaciones,olvido,empleado.nombre,empleado.apellido')
        ->join('empleado','empleado.id','=','permisos.empleado')
        ->where(function($query)
            {$query->where('permisos.estado','like','Enviado a RRHH')
                ->orWhere('permisos.estado','like','Aceptado');}
        );

        if($depto!='todos'){
            $permisos = $permisos->where('empleado.id_depto',$depto);
        }

        if($anio!='todos'){
            $permisos = $permisos->whereRaw('to_char(permisos.fecha_uso,\'YYYY\')::int='.$anio);
        }

        if($mes!='todos'){
            $permisos = $permisos->whereRaw('to_char(permisos.fecha_uso,\'MM\')::int='.$mes);
        }

        $permisos = $permisos->orderBy('permisos.fecha_uso')->get();

        foreach ($permisos as $item) {
            # code...
            $col3 = $col4 = $col5 = null;
            if ($item->olvido == 'Entrada' || $item->olvido =='Salida') {
                $col3 = date('H:i', strtotime($item->olvido == 'Entrada'?$item->hora_inicio:$item->hora_final));
                $col4 = date('H:i', strtotime(!$item->olvido == 'Entrada'?$item->hora_inicio:$item->hora_final));
                $col5 = date('H:i', strtotime($item->hora_final));
            }else{
                $col3 = date('H:i', strtotime($item->hora_inicio));
                $col4 = date('H:i', strtotime($item->hora_final)) ;
                $col5 = ''.\Carbon\Carbon::parse($item->fecha_uso . 'T' . $item->hora_inicio)->diffAsCarbonInterval(\Carbon\Carbon::parse($item->fecha_uso . 'T' . $item->hora_final));
            }

            $botones = 
            '<div class="row">
                <div class="col text-center">
                    <div class="btn-group" role="group">
                        <button title="Ver Seguimiento" class="btn btn-outline-primary btn-sm"
                            value="'.$item->permiso .'" onclick="observaciones(this)">
                            <i class="fa fa-eye font-16 my-1" aria-hidden="true"></i>
                        </button>
                        <button title="Agregar Observacion"
                            class="btn btn-outline-primary btn-sm"
                            value="'.$item->permiso.'" onclick="'.($item->olvido == 'Entrada' || $item->olvido =='Salida' ?'verDatosConst(this)':'verDatos(this)').'">
                            <i class="fa fa-file-alt font-16 my-1 mx-0"
                                aria-hidden="true"></i>
                        </button>
                        <button title="Aceptar"
                            class="btn btn-outline-success btn-sm"
                            '.($item->estado==='Enviado a RRHH' ? 'value="'. $item->permiso.'"
                                 onclick="'.($item->olvido == 'Entrada' || $item->olvido =='Salida' ?'aceptarConst(this)':'aceptar(this)'): 'disabled').' ">
                            <i class="fa fa-check font-16 my-1" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>';

            $data[] = array(
                "col0" => \Carbon\Carbon::parse($item->fecha_uso)->format('d/M/Y'),
                "col1" => $item->nombre.' '.$item->apellido,
                "col2" => '<span class="badge badge-primary">'.$item->tipo_permiso.'</span>',
                "col3" => $col3,
                "col4" => $col4,
                "col5" => $col5,
                "col6" => ($item->estado=='Aceptado'?'<span class="badge badge-success">'.$item->estado.'</span>':'<span class="badge badge-secondary">'.$item->estado.'</span>'),
                "col7" => $botones,
            );
        }
        return isset($data)?response()->json($data,200,[]):response()->json([],200,[]);
    }

    /**En construccion query */
    public function datableJson($tipo,$departamento,$anio,$mes){
        $query = $tipo=='Jefatura' ? Permiso::selectRaw('
            md5(permisos.id::text) as permiso, 
            permisos.tipo_permiso, 
            permisos.fecha_uso,
            permisos.fecha_presentacion,
            permisos.hora_inicio,
            permisos.hora_final,
            permisos.justificacion,
            permisos.observaciones,
            empleado.nombre,
            permisos.estado,
            empleado.apellido')
            ->join('empleado','empleado.id','=','permisos.empleado')
            ->where('jefatura',auth()->user()->empleado)
            ->where(
                function($query){
                    $query->where('permisos.estado','like','Aceptado')
                    ->orWhere('permisos.estado','like','Enviado a Jefatura')
                    ->orWhere('permisos.estado','like','Enviado a RRHH');
            })->where('olvido',null):
        Permiso::selectRaw('md5(permisos.id::text) as permiso, 
                tipo_permiso, fecha_uso,fecha_presentacion,hora_inicio,hora_final,justificacion,permisos.estado,
                observaciones,olvido,empleado.nombre,empleado.apellido')
            ->join('empleado','empleado.id','=','permisos.empleado')
            ->where(function($query)
                {
                    $query->where('permisos.estado','like','Aceptado')
                    ->orWhere('permisos.estado','like','Enviado a Jefatura')
                    ->orWhere('permisos.estado','like','Enviado a RRHH');
            });

        $permisos = $query ->get();

        foreach ($permisos as $item) {
            # code...
            $col3 = $col4 = $col5 = null;
            if ($item->olvido == 'Entrada' || $item->olvido =='Salida') {
                $col3 = date('H:i', strtotime($item->olvido == 'Entrada'?$item->hora_inicio:$item->hora_final));
                $col4 = date('H:i', strtotime($item->olvido == 'Salida'?$item->hora_inicio:$item->hora_final));
                $col5 = date('H:i', strtotime($item->hora_final));
            }else{
                $col3 = date('H:i', strtotime($item->hora_inicio));
                $col4 = date('H:i', strtotime($item->hora_final)) ;
                $col5 = ''.\Carbon\Carbon::parse($item->fecha_uso . 'T' . $item->hora_inicio)->diffAsCarbonInterval(\Carbon\Carbon::parse($item->fecha_uso . 'T' . $item->hora_final));
            }

            $botones = 
            '<div class="row">
                <div class="col text-center">
                    <div class="btn-group" role="group">
                        <button title="Ver Seguimiento" class="btn btn-outline-primary btn-sm"
                            value="'.$item->permiso .'" onclick="observaciones(this)">
                            <i class="fa fa-eye font-16 my-1" aria-hidden="true"></i>
                        </button>
                        <button title="Agregar Observacion"
                            class="btn btn-outline-primary btn-sm"
                            value="'.$item->permiso.'" onclick="'.($item->olvido == 'Entrada' || $item->olvido =='Salida' ?'verDatosConst(this)':'verDatos(this)').'">
                            <i class="fa fa-file-alt font-16 my-1 mx-0"
                                aria-hidden="true"></i>
                        </button>
                        <button title="Aceptar"
                            class="btn btn-outline-success btn-sm"
                            '.($item->estado===('Enviado a '.$tipo) ? 'value="'. $item->permiso.'"
                                 onclick="'.($item->olvido == 'Entrada' || $item->olvido =='Salida' ?'aceptarConst(this)':'aceptar(this)'): 'disabled').' ">
                            <i class="fa fa-check font-16 my-1" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>';

            $data[] = array(
                "col0" => \Carbon\Carbon::parse($item->fecha_uso)->format('d/M/Y'),
                "col1" => $item->nombre.' '.$item->apellido,
                "col2" => '<span class="badge badge-primary">'.$item->tipo_permiso.'</span>',
                "col3" => $col3,
                "col4" => $col4,
                "col5" => $col5,
                "col6" => $botones,
            );
        }
        return isset($data)?response()->json($data,200,[]):response()->json([],200,[]);
    }

    public function aceptarRRHH(Request $request){
        if (Auth::check() and (@Auth::user()->hasRole('Recurso-Humano') or @Auth::user()->hasRole('super-admin'))) {
            # code...        
            $permiso = Permiso::select('estado','id')->whereRaw('md5(id::text) = ?',[$request->_id])->first();
            $permiso -> estado = 'Aceptado';
            $permiso -> gestor_rrhh = auth()->user()->empleado;
            DB::update('update permiso_seguimiento set estado = false where estado = ? and permiso_id=?', [true,$permiso->id]);

            $seguimiento = new Permiso_seguimiento;
            $seguimiento -> permiso_id = $permiso->id;
            $seguimiento -> estado = true;
            $seguimiento -> proceso = 'Aceptado';
            $seguimiento -> save();

            $permiso->save();
            return redirect()->route('indexRRHH');
        }else {
            return redirect()->route('index');
        }
    }

    public function aceptarJefatura(Request $request){
        if (Auth::check() && ($this->isJefe() || @Auth::user()->hasRole('super-admin'))) {
            # code...        
            $permiso = Permiso::select('estado','id')->whereRaw('md5(id::text) = ?',[$request->_id])->first();
            $permiso -> estado = 'Enviado a RRHH';
            DB::update('update permiso_seguimiento set estado = false where estado = ? and permiso_id=?', [true,$permiso->id]);

            $seguimiento = new Permiso_seguimiento;
            $seguimiento -> permiso_id = $permiso->id;
            $seguimiento -> estado = false;
            $seguimiento -> proceso = 'Aceptado por Jefatura';
            $seguimiento -> save();
            
            $seguimiento = new Permiso_seguimiento;
            $seguimiento -> permiso_id = $permiso->id;
            $seguimiento -> estado = true;
            $seguimiento -> proceso = 'Enviado a RRHH';
            $seguimiento -> save();

            $permiso->save();
            return redirect()->route('indexJefatura');
        }else {
            return redirect()->route('index');
        }
    }

    //PARA LAS OBSERVACIONES DE CONSTANCIA
    public function observacionJefaturaConst(Request $request){
        if(Auth::check() and ($this->isJefe() or @Auth::user()->hasRole('super-admin'))){
            $validator = Validator::make($request->all(),[
                'observaciones_jefatura_constancia' => 'required|string|min:3',
            ]);         

            if($validator->fails())
            {            
                return response()->json(['error'=>$validator->errors()->all()]);                
            }

            $permiso = Permiso::select('estado','id')->whereRaw('md5(id::text) = ?',[$request->_id])->first();
            $permiso -> estado = 'Observaciones de Jefatura';
            DB::update('update permiso_seguimiento set estado = false where estado = ? and permiso_id=?', [true,$permiso->id]);
            
            $seguimiento = new Permiso_seguimiento;
            $seguimiento -> permiso_id = $permiso->id;
            $seguimiento -> estado = true;
            $seguimiento -> observaciones = $request->observaciones_jefatura_constancia;
            $seguimiento -> proceso = 'Observaciones de Jefatura';
            $seguimiento -> save();

            $permiso->save();
            return $request->_id != null?
            response()->json(['mensaje'=>'Observacion Registrada']):
            response()->json(['error'=>'Error no se capturo id de permiso']);
        }else {
            return redirect()->route('index');
        }

    }
    //FIN DE LAS OBSERVACIONES DE CONSTANCIA

    public function observacionJefatura(Request $request){
        if(Auth::check() and ($this->isJefe() or @Auth::user()->hasRole('super-admin'))){
            $validator = Validator::make($request->all(),[
                'observaciones_jefatura' => 'required|string|min:3',
            ]);         

            if($validator->fails())
            {            
                return response()->json(['error'=>$validator->errors()->all()]);                
            }

            $permiso = Permiso::select('estado','id')->whereRaw('md5(id::text) = ?',[$request->_id])->first();
            $permiso -> estado = 'Observaciones de Jefatura';
            DB::update('update permiso_seguimiento set estado = false where estado = ? and permiso_id=?', [true,$permiso->id]);
            
            $seguimiento = new Permiso_seguimiento;
            $seguimiento -> permiso_id = $permiso->id;
            $seguimiento -> estado = true;
            $seguimiento -> observaciones = $request->observaciones_jefatura;
            $seguimiento -> proceso = 'Observaciones de Jefatura';
            $seguimiento -> save();

            $permiso->save();
            return $request->_id != null?
            response()->json(['mensaje'=>'Observacion Registrada']):
            response()->json(['error'=>'Error no se capturo id de permiso']);
        }else {
            return redirect()->route('index');
        }

    }

    public function observacionRRHH(Request $request){
        if(Auth::check() and ($this->isJefe() or @Auth::user()->hasRole('super-admin') or @Auth::user()->hasRole('Recurso-Humano'))){
            $validator = Validator::make($request->all(),[
                'observaciones_recursos_humanos' => 'required|string|min:3',
            ]);         

            if($validator->fails())
            {            
                return response()->json(['error'=>$validator->errors()->all()]);                
            }

            $permiso = Permiso::select('estado','id')->whereRaw('md5(id::text) = ?',[$request->_id])->first();
            $permiso -> estado = 'Observaciones de RRHH';
            DB::update('update permiso_seguimiento set estado = false where estado = ? and permiso_id=?', [true,$permiso->id]);
            
            $seguimiento = new Permiso_seguimiento;
            $seguimiento -> permiso_id = $permiso->id;
            $seguimiento -> estado = true;
            $seguimiento -> observaciones = $request->observaciones_recursos_humanos;
            $seguimiento -> proceso = 'Observaciones de RRHH';
            $seguimiento -> save();

            $permiso->save();
            return $request->_id != null?
            response()->json(['mensaje'=>'Observacion Registrada']):
            response()->json(['error'=>'Error no se capturo id de permiso']);
        }else {
            return redirect()->route('index');
        }

    }

    //PARA LAS OBSERVACIONES DE RRHH
    public function observacionRRHHconst(Request $request){
        if(Auth::check() and ($this->isJefe() or @Auth::user()->hasRole('super-admin') or @Auth::user()->hasRole('Recurso-Humano'))){
            $validator = Validator::make($request->all(),[
                'observaciones_recursos_humanos_constancia' => 'required|string|min:3',
            ]);         

            if($validator->fails())
            {            
                return response()->json(['error'=>$validator->errors()->all()]);                
            }

            $permiso = Permiso::select('estado','id')->whereRaw('md5(id::text) = ?',[$request->_id])->first();
            $permiso -> estado = 'Observaciones de RRHH';
            DB::update('update permiso_seguimiento set estado = false where estado = ? and permiso_id=?', [true,$permiso->id]);
            
            $seguimiento = new Permiso_seguimiento;
            $seguimiento -> permiso_id = $permiso->id;
            $seguimiento -> estado = true;
            $seguimiento -> observaciones = $request->observaciones_recursos_humanos_constancia;
            $seguimiento -> proceso = 'Observaciones de RRHH';
            $seguimiento -> save();

            $permiso->save();
            return $request->_id != null?
            response()->json(['mensaje'=>'Observacion Registrada']):
            response()->json(['error'=>'Error no se capturo id de permiso']);
        }else {
            return redirect()->route('index');
        }

    }
    //FIN DE LAS OBSERVACIONES DE RRHH
    public function permiso($permiso){
        if(Auth::check() &&
        !is_null($permiso) &&
        ($this->isJefe() ||
        @Auth::user()->hasRole('super-admin') || 
        @Auth::user()->hasRole('Recurso-Humano') )){
            return Permiso::selectRaw(
                'md5(permisos.id::text) as permiso, tipo_representante, tipo_permiso, fecha_uso,
                    fecha_presentacion,
                    olvido,
                    to_char(hora_inicio,\'HH24:MI\') as hora_inicio,
                    to_char(hora_final,\'HH24:MI\') as hora_final,
                    justificacion,
                    observaciones,
                    permisos.estado like \'Enviado a Jefatura\' as jf,
                    permisos.estado like \'Enviado a RRHH\' as rrhh,
                    nombre,
                    apellido'
            )->join('empleado','empleado.id','=','permisos.empleado')
            ->whereRaw('md5(permisos.id::text) = ?',[$permiso])
            ->first()->toJSON();  
        }else {
            return redirect()->route('index');
        }
    }

    public function exportExcel(Request $request){
        
        $validator = Validator::make($request->all(),[
            //'tipo' => 'required',
            'anio' => 'required',
            'mes' => 'required',
            'depto' => 'required',
        ]); 

        $depto = DB::table('departamentos')->select('nombre_departamento')->where('id',$request->depto)->first();
        $titulo = 'Licencias_'.$depto->nombre_departamento.'_'.$request->mes.'_'.$request->anio;
        return Excel::download(new LicenciaExport(/*$request->tipo,*/$request->anio, $request->mes, $request->depto, $request->comentario), $titulo.'.xlsx');
    }

}
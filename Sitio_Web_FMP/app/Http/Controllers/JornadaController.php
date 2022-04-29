<?php

namespace App\Http\Controllers;

use Auth;
use App\Exports\JornadaExport;
use App\Mail\JornadaEmail;
use App\Models\_UTILS\Utilidades;
use App\Models\Jornada\Jornada;
use App\Models\Jornada\JornadaItem;
use App\Models\Jornada\Periodo;
use App\Models\User;
use App\Models\General\Empleado;
use App\Models\Horarios\Departamento;
use App\Models\Jornada\Seguimiento;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class JornadaController extends Controller{
    public $modulo = 'Jornadas';

    public $rules = [
        'id_emp' => 'required|integer',
        'id_periodo' => 'required|integer',
        'items' => 'required'
        // 'items' => 'required|array',
    ];

    public $messages = [
        'id_emp.required' => 'Seleccione un empleado',
        'id_periodo.required' => 'Seleccione un periodo',
        'items.array' => 'La Jornada no puede ir vacia'
    ];

    public $rulesMod = [
        'observaciones' => 'required|String',
    ];

    public $messagesMod = [
        'observaciones.required' => 'La nota es obligatoria',
    ];

    public $estado_procedimiento = [
        0 => ['value' => 'guardado', 'text' => 'Guardado'],
        1 => ['value' => 'enviado a jefatura', 'text' => 'Enviar a Jefatura'],
        2 => ['value' => 'la jefatura lo ha regresado por problemas', 'text' => 'Retornar con observaciones (Jefatura)'],
        3 => ['value' => 'enviado a recursos humanos', 'text' => 'Enviar a recursos humanos'],
        4 => ['value' => 'recursos humanos lo ha regresado a jefatura', 'text' => 'Retornar con observaciones (Recursos Humanos)'],
        5 => ['value' => 'aceptado', 'text' => 'Aceptado'],
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        DB::enableQueryLog();
        $user = Auth::user();
        $estados = $this->estado_procedimiento;
        $cargar = true;
        $emp = null; //para terminar que es solo un empleado y poder determinar el tipo
        $add_jornada = false;
        $empleado = $user->empleado_rf;//determinamos si tiene un empleado relacionado;


        //para determinar si existe un periodo y determinar el tipo de periodo dependiendo del usuario
        if(isset($request->periodo)){
            $periodo = Periodo::findOrFail($request->periodo);
        }else{
            $periodo = null;
            if (!$user->hasRole('super-admin') && !$user->hasRole('Recurso-Humano')) { // si no es jefe filtramos la informacion dependiendo de si es jefe o empleado normal
                $tipo = ($user->hasRole('Jefe-Administrativo') || $user->hasRole('Administrativo')) ? 'Administrativo' : 'Académico';
                $periodo = Periodo::select('id')->where('estado', '!=', 'inactivo')->where('tipo', $tipo)->OrderBy('id', 'DESC')->first();
            }else{
                $periodo = Periodo::select('id')->where('estado', '!=', 'inactivo')->OrderBy('id', 'DESC')->first();
            }
        }

        //dd($periodo);

        $depto = (isset($request->depto) && strcmp($request->depto, 'all')!=0) ? $request->depto : false;


        //verificamos si existe un periodo regitrado
        $query = null;
        if(!is_null($periodo) && !is_null($empleado)){
            $query = Jornada::join('periodos','jornada.id_periodo','periodos.id')
                ->join('empleado','jornada.id_emp','empleado.id')
                ->select('jornada.*',Periodo::raw("concat(to_char(periodos.fecha_inicio, 'dd/TMMonth/yy') , ' - ', to_char(periodos.fecha_fin, 'dd/TMMonth/yy')) as periodo"), 'periodos.tipo as tipo_periodo')
                ->where('jornada.id_periodo', $periodo->id);

            //para filtrar por los tipos de procedimiento a los que tiene acceso
            if(!$user->hasRole('super-admin') && !$user->hasRole('Recurso-Humano')){ // si no es RRHH filtramos la informacion dependiendo de si es jefe o empleado normal
                if($user->hasRole('Jefe-Academico') || $user->hasRole('Jefe-Administrativo')){ //para filtrar por tipo de departamento
                    $query->where('empleado.jefe', $empleado->id)->whereIn('jornada.procedimiento', [$estados[1]['value'], $estados[2]['value'], $estados[3]['value'], $estados[4]['value'], $estados[5]['value']]);
                }else if($user->hasRole('Docente') || $user->hasrole('Administrativo')){ // con esto determinamos que es un empleado sin cargos de jefatura por lo cual solo se mostrara ese empleado
                    $query->where('empleado.id', $empleado->id);
                    $emp = $empleado;
                }
            } else if ($user->hasRole('Recurso-Humano')) {
                $query->whereIn('jornada.procedimiento', [$estados[3]['value'], $estados[4]['value'], $estados[5]['value']]);
            }


            //PARA AGREGAR LA FILA DE LA JORNADA DEL JEFES Y DE RECURSO HUMANO
            $jornada = null;
            if($this->fnCheckAddCurrentData()){
                if(
                    ($depto!=false && $depto==$empleado->id_depto)
                    || (isset($request->depto) && strcmp($request->depto, 'all') == 0)
                    || (!isset($request->depto))
                    ){

                    $add_jornada = true;
                    $jornada = Jornada::join('periodos', 'jornada.id_periodo', 'periodos.id')
                        ->join('empleado', 'jornada.id_emp', 'empleado.id')
                        ->select('jornada.*', Periodo::raw("concat(to_char(periodos.fecha_inicio, 'dd/TMMonth/yy') , ' - ', to_char(periodos.fecha_fin, 'dd/TMMonth/yy')) as periodo"), 'periodos.tipo as tipo_periodo')
                        ->where('jornada.id_periodo', $periodo->id)
                        ->where('empleado.id', $empleado->id)
                        ->first();
                }
            }
        }

        if(is_null($query) || is_null($empleado)){
            $cargar = false;
            $jornadas = [];
            $deptos = [];
            $periodos = [];
        }else{

            $deptos = $this->fnDeptosSegunRol();


            //para filtrar por departamento
            if($depto != false){
                $query->where('empleado.id_depto', $depto);
            }else{
                $q = $this->filterDeptosEmpleado($deptos, $query);
                $query = !is_null($q) ? $q : $query;
            }

            $jornadas = $query->get();

            //filtrar periodos por tipo de usuarios
            $periodos_query = Periodo::select('periodos.*', 'ciclos.nombre')
                                ->join('ciclos', 'ciclos.id', 'periodos.ciclo_id');

            if (!$user->hasRole('super-admin') && !$user->hasRole('Recurso-Humano')) {
                if (
                    ($user->hasRole('Jefe-Administrativo') && $user->hasRole('Jefe-Academico'))
                    || ($user->hasRole('Jefe-Administrativo') && $user->hasRole('Docente'))
                    || ($user->hasRole('Jefe-Academico') && strcmp($empleado->tipo_empleado, 'Administrativo')==0)
                    ) {
                    $periodos_query->whereIn('periodos.tipo', ['Administrativo','Académico']);
                }else if( ($user->hasRole('Administrativo')) ){
                    $periodos_query->where('periodos.tipo', 'Administrativo');
                }
                else{
                    $tipo = ($user->hasRole('Jefe-Administrativo')) ? 'Administrativo' : 'Académico';
                    $periodos_query->where('periodos.tipo', $tipo);
                }
            }

            $periodos = $periodos_query->where('periodos.estado', '!=', 'inactivo')->orderBy('periodos.id', 'DESC')->get();

            //agregar la jornada del usuario activo
            if($add_jornada && !is_null($jornada)){
                if(!$jornadas->contains($jornada))
                    $jornadas->prepend($jornada);
            }

        }

        return view('Jornada.index', compact('emp','cargar','periodos','jornadas', 'deptos',  'periodos', 'periodo', 'depto'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $user = Auth::user();
        $id_log = Auth::user()->empleado;
        try {
            $validator = Validator::make($request->all(), $this->rules, $this->messages);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->all()]);
            }

            $items = json_decode($request->items);
            $requestData = $request->except(['_id', 'items']);

            if (strcmp(trim($request->_id), '') == 0 ) {
                $msg = 'Registro exitoso.';
                // $id_log;
                // $request->id_emp

                //para determinar el estado del proceso dependiendo del usuario que hace el registro
                $procedimiento = 'guardado';
                if ($user->hasRole('super-admin') || $user->hasRole('Recurso-Humano')) {
                    $procedimiento = 'enviado a recursos humanos';
                } else if ($user->hasRole('Jefe-Academico') || $user->hasRole('Jefe-Administrativo') && !$user->hasRole('Docente')) {
                    $procedimiento = 'enviado a jefatura';
                }else if ($user->hasRole('Jefe-Administrativo') && $user->hasRole('Docente') && $request->id_emp != $id_log) {
                    $procedimiento = 'enviado a jefatura';    
                } else if ($user->hasRole('Jefe-Academico') || $user->hasRole('Jefe-Administrativo') && $user->hasRole('Docente') && $request->id_emp === $id_log) {
                    $procedimiento = 'guardado';
                } 

                $requestData['procedimiento'] = $procedimiento;


                $jornada = Jornada::create($requestData);
                if (is_array($items) || is_object($items)) {
                    foreach ($items as $key => $value) { //para guardar los items del jornada
                        JornadaItem::create([
                            'id_jornada' => $jornada->id,
                            'dia' => $value->dia,
                            'hora_inicio' => $value->hora_inicio,
                            'hora_fin' => $value->hora_fin,
                        ]);
                    }
                }
                Utilidades::fnSaveBitacora('Nueva Jornada #: ' . $jornada->id. ' Ciclo: '. $jornada->periodo_rf->ciclo_rf->nombre, 'Registro', $this->modulo);
            } else {

                $validator = Validator::make($request->all(), $this->rulesMod, $this->messagesMod);
                if ($user->hasRole('Recurso-Humano') && $validator->fails()) {
                    return response()->json(['error' => $validator->errors()->all()]);
                }
                
                $id = $request->_id;
                $jornada = Jornada::findOrFail($id);
                $msg = 'Modificación exitosa.';

                $jornada->update($requestData);
                $jornada->items()->delete();
                if (is_array($items) || is_object($items)) {
                    foreach ($items as $key => $value) { //para guardar los items del jornada
                        JornadaItem::create([
                            'id_jornada' => $jornada->id,
                            'dia' => $value->dia,
                            'hora_inicio' => $value->hora_inicio,
                            'hora_fin' => $value->hora_fin,
                        ]);
                    }
                }
                Utilidades::fnSaveBitacora('Jornada #: ' . $jornada->id . ' Ciclo: ' . $jornada->periodo_rf->ciclo_rf->nombre, 'Modificación', $this->modulo);
            }
            return response()->json(['mensaje' => $msg . $id_log . $request->id_emp]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jornada  $jornada
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $user = Auth::user();

        $jornada = Jornada::select('jornada.id', 'jornada.id_emp', 'jornada.id_periodo', 'jornada.created_at', 'jornada.observaciones')
                        ->where('jornada.id', $id)
                        ->first();
        $items = $jornada->items;
        $jornadas = [];
        foreach ($items as $key => $value) {
            $fechaUno = new DateTime($value->hora_fin);
            $fechaDos = new DateTime($value->hora_inicio);
            $dateInterval = $fechaUno->diff($fechaDos);
            $jornadas[$key]['option'] = '<button type="button" class="btn btn-sm btn-secondary" title="Eliminar Fila"> <i class="fa fa-times"></i> </button>';
            $jornadas[$key]['dia'] = $value->dia;
            $jornadas[$key]['hora_inicio'] = $value->hora_inicio;
            $jornadas[$key]['hora_fin'] = $value->hora_fin;
            $jornadas[$key]['jornada'] = $dateInterval->format('%H:%I');
        }
        $seguimiento = $jornada->seguimiento;

        return array('jornada' => $jornada, 'items' => $jornadas, 'seguimiento' => $seguimiento);
    }

    public function getEmpleadoJornada($id){
        $user = Auth::user();
        $empleado = Empleado::join('tipo_jornada as tj', 'tj.id', 'empleado.id_tipo_jornada')
                            ->where('empleado.id', $id)
                            ->first();
        $permiso = ($user->hasRole('super-admin') || $user->hasRole('Recurso-Humano') || $user->hasRole('Jefe-Administrativo') || $user->hasRole('Jefe-Academico') || strcmp($empleado->tipo_empleado, 'Académico') == 0);
        return array('empleado' => $empleado, 'permiso' => $permiso);
    }

    public function getEmpleadoPeriodo($id, Request $request){
        $is_edit = $request->updateEmpleado;
        $empleados = $this->fnEmpleadosSegunPeriodo($id, $is_edit);
        return $empleados;
    }

    public function export(Request $request){
        $user = Auth::user();
        $depto = null;
        if (!$user->hasRole('super-admin') && !$user->hasRole('Recurso-Humano')) { // si no es jefe filtramos la informacion dependiendo de si es jefe o empleado normal
            //determinamos si tiene un empleado relacionado
            $empleado = $user->empleado_rf;
            if (!is_null($empleado)) { //para que muestre una alerta de que no existe un empleado relacionado con el usuario
                if ($user->hasRole('Jefe-Academico') || $user->hasRole('Jefe-Administrativo')) { //para filtrar por tipo de departamento
                    $depto = $empleado->id_depto; // id que servira para filtrar los empleados por departemento
                }
            }
        } else if ($user->hasRole('super-admin') || $user->hasRole('Recurso-Humano')) {
            if(isset($request->depto)){
                $depto = $request->depto; // id que servira para filtrar los empleados por departemento
            }
        }
        $periodo = Periodo::findOrFail($request->periodo);
        $titulo = 'jornada_'. preg_replace('/\s+/', '', ($periodo->ciclo_rf->nombre).'_generado_'.date('d_m_Y_H_m_s'));
        return Excel::download(new JornadaExport($periodo->id, $depto), $titulo.'.xlsx');
    }

    public function procedimiento(Request $request){
        $rules = [
            'jornada_id' => 'required|integer',
            'proceso' => 'required|string',
        ];

        try {
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->all()]);
            }

            $jornada = Jornada::findOrFail($request->jornada_id);
            $jornada->update([
                'procedimiento' => $request->proceso,
            ]);

            $empleado = $jornada->empleado_rf;
            //$periodo = $jornada->periodo_rf;
            //$ciclo = $periodo->ciclo_rf;
            // $jefe = $empleado->jefe_rf;

            // if (!is_null($jefe)) {
            //     $usuario_jefe = $jefe->usuario_rf;
            //     if(!is_null($usuario_jefe)){
            //         Notificaciones::create([
            //             'usuario_id' => $usuario_jefe->id,
            //             'mensaje' => 'NUEVO => Procedimiento: '. ucwords($request->proceso) . ', Empleado: ' . $empleado->nombre . ' ' . $empleado->apellido . ', Periodo: ' . $ciclo->nombre,
            //             'tipo' => 'Jornada',
            //             'observaciones' => $request->observaciones
            //         ]);
            //     }
            // }


            Seguimiento::create($request->all());
            // Notificaciones::create([
            //     'usuario_id' => Auth::user()->id,
            //     'mensaje' => 'NUEVO => Procedimiento: ' . ucwords($request->proceso) . ', Empleado: ' . $empleado->nombre . ' ' . $empleado->apellido . ', Periodo: ' . $ciclo->nombre,
            //     'tipo' => 'Jornada',
            //     'observaciones' => $request->observaciones
            // ]);


            Utilidades::fnSaveBitacora('Seguimiento para la Jornada del Empleado #: ' . $empleado->nombre.' '.$empleado->apellido, 'Registro', $this->modulo);

            return response()->json(['mensaje' => 'Registro exitoso']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function fnEmpleadosSegunPeriodo($periodo, $is_edit){
        $user = Auth::user();
        $periodo = Periodo::findOrFail($periodo);
        $empleado = $user->empleado_rf;

        $query = Empleado::where('estado', true);
        if($is_edit!='true'){
            $query->whereNotExists(function ($query) use ($periodo) {
                $query->select(DB::raw(1))
                    ->from('jornada as j')
                    ->where('j.id_periodo', $periodo->id)
                    ->whereRaw('j.id_emp = empleado.id');
            });
        }
        if (!$user->hasRole('super-admin') && !$user->hasRole('Recurso-Humano')) { // si no es jefe filtramos la informacion dependiendo de si es jefe o empleado normal
            //determinamos si tiene un empleado relacionado
            $deptos = $this->fnDeptosSegunRol();
                //para filtrar por los empleados dependiendo del departamento al que pertenezcan
            if ($user->hasRole('Jefe-Academico') || $user->hasRole('Jefe-Administrativo')) {
                $q = $this->filterDeptosEmpleado($deptos, $query);
                $query = !is_null($q) ? $q : $query;
                $query->where('empleado.jefe', $empleado->id)->where('empleado.tipo_empleado', $periodo->tipo);
            }else {//cuando es docente
                $query->where('empleado.id', $empleado->id);
            }
        }else{
            $query->where('empleado.tipo_empleado', $periodo->tipo);
        }
        $empleados = $query->get();

        //verificar si existe la jornada ya registrada para el empleado
        $existe = Jornada::where('id_periodo', $periodo->id)->where('id_emp', $empleado->id)->where('estado', 'activo')->count();
        //$is_jefe = Empleado::where('jefe', $empleado->id)->where('estado', true)->count();


        //codigo para agregar el empleado jefe de los demas
        if($existe<=0 || $is_edit=='true'){
            if ($this->fnCheckAddCurrentData() && (strcmp($empleado->tipo_empleado, $periodo->tipo)==0)) {
                if (!$empleados->contains($empleado))
                    $empleados->prepend($empleado);
            }
        }

        return $empleados;
    }


    public function fnDeptosSegunRol(){
        $user = Auth::user();
        $empleado = $user->empleado_rf;
        $deptos = [];
        if(!is_null($empleado)){
            $deptos = Departamento::where('estado', true)->orderBy('nombre_departamento', 'ASC')->get();
            if (!$user->hasRole('super-admin') && !$user->hasRole('Recurso-Humano')) {
                    $query = Departamento::select('departamentos.id', 'departamentos.nombre_departamento')
                                ->join('empleado', 'empleado.id_depto', 'departamentos.id')
                                ->where('departamentos.estado', true)
                                ->where('empleado.jefe', $empleado->id);
                    if ($user->hasRole('Jefe-Academico')) { //para filtrar por tipo de empleado en los periodos
                        $deptos = $query->where('empleado.tipo_empleado', 'Académico')
                                ->groupBy('departamentos.id', 'departamentos.nombre_departamento')
                                ->get();
                    } else if ($user->hasRole('Jefe-Administrativo')) {
                        $deptos = $query->where('empleado.tipo_empleado', 'Administrativo')
                            ->groupBy('departamentos.id', 'departamentos.nombre_departamento')
                            ->get();
                    } else if ($user->hasRole('Docente') || $user->hasrole('Administrativo')) { // con esto determinamos que es un empleado sin cargos de jefatura por lo cual solo se mostrara ese empleado
                        $deptos = Departamento::where('estado', true)->where('id', $empleado->id_depto)->get();
                    }
            }
            //para agregar el departamento del jefe si este pertenece a otro departamento y no es academico
            if ($this->fnCheckAddCurrentData()) {
                $depto = $empleado->departamento_rf;
                if (!$deptos->contains($depto))
                    $deptos->prepend($depto);
            }
        }
        return $deptos;
    }

    public function filterDeptosEmpleado($deptos, $query){
        $filter_departamentos = [];
        $q = null;
        foreach ($deptos as $key => $value) {
            array_push($filter_departamentos, $value->id);
        }
        if (count($filter_departamentos) > 0) {
            $q = $query->whereIn('empleado.id_depto', $filter_departamentos);
        }
        return $q;
    }

    public function checkDia(Request $request){
        $empleado = Empleado::findOrFail($request->empleado);
        $periodo = Periodo::findOrFail($request->periodo);
        $ciclo = $periodo->ciclo_rf;
        $horarios = $ciclo->horarios_rf->where('id_empleado', $empleado->id);


        // dd($horarios);
    }

    public function getOpcionesSeguimiento($id){
        $user = Auth::user();
        $jornada = Jornada::findOrFail($id);
        $estados = $this->estado_procedimiento;
        unset($estados[0]);

        if($user->empleado_rf->id == $jornada->empleado_rf->id){
            if ($user->hasRole('super-admin') || $user->hasRole('Recurso-Humano')) {
                unset($estados[1], $estados[2], $estados[3], $estados[4]);
            } else if ($user->hasRole('Jefe-Academico') || $user->hasRole('Jefe-Administrativo') && !$user->hasRole('Docente')) {
                unset($estados[5], $estados[4], $estados[1], $estados[2]);
            } else if ($user->hasRole('Jefe-Academico') || $user->hasRole('Jefe-Administrativo') && $user->hasRole('Docente')) {
                unset($estados[5], $estados[4], $estados[2], $estados[3]);
            }
            else if ($user->hasRole('Docente')) {
                unset($estados[2], $estados[3], $estados[4], $estados[5]);
            }
        }else{

            if ($user->hasRole('super-admin') || $user->hasRole('Recurso-Humano')){
                unset($estados[1], $estados[2], $estados[3]);
                //si el periodo se encuentra finalizado no podra retornarlo a jefatura solamente podra aceptarlo
                if(strcmp($jornada->periodo_rf->estado, 'finalizado')==0){
                    unset($estados[4]);
                }
            }else if ($user->hasRole('Jefe-Academico')){
                unset($estados[5], $estados[4], $estados[1]);
            }else if($user->hasRole('Jefe-Administrativo')){
                unset($estados[5], $estados[4], $estados[1], $estados[2]);
            }else if($user->hasRole('Docente')){
                unset($estados[2], $estados[3], $estados[4], $estados[5]);
            }
        }

        return $estados;
    }

    /*public function fnCargaSegunEmpleado($id){
        $user = Auth::user();
        $query = Horarios::join('horas','horarios.id_hora','horas.id')
        ->join('materias','horarios.id_materia','materias.id')
        ->join('empleado','horarios.id_empleado','empleado.id')
        ->select ('horarios.id_empleado','horarios.dias as dias','materias.nombre_materia as nombre_materia','horas.inicio as inicio','horas.fin as fin');

        if ($user->hasRole('Docente')) {
            $empleado = $user->empleado_rf;
            $query->where('horarios.id_empleado', $empleado->id)
                  ->orderby('horarios.dias');
        }else if ($user->hasRole('Jefe-Academico')  || $user->hasRole('Jefe-Administrativo')) {
            $query->where('horarios.id_empleado', $id)
                ->orderby('horarios.dias');
        } else if ($user->hasRole('super-admin') || $user->hasRole('Recurso-Humano')) {
            $query->where('horarios.id_empleado', $id)
                ->orderby('horarios.dias');
        }

        $horarios = $query->get();
        return $horarios;
    }*/


    public function email(Request $request){
        $user = Auth::user();

        //Empleado jefe
        $empleado = $user->empleado_rf;

        //Periodo
        $periodo = Periodo::findOrFail($request->periodo);

        //Departamentos
        $deptos = $this->fnDeptosSegunRol();

        //Empleados
        $query = Empleado::select('empleado.*', 'departamentos.nombre_departamento')
                            ->where('empleado.estado', true)
                            ->where('departamentos.estado', true)
                            ->join('departamentos', 'departamentos.id', 'empleado.id_depto');

        $q = $this->filterDeptosEmpleado($deptos, $query);
        $query = !is_null($q) ? $q : $query;

        if ($user->hasRole('Jefe-Academico')) { //para filtrar por tipo de empleado en los periodos
            $query->where('empleado.tipo_empleado', 'Académico');
        } else if ($user->hasRole('Jefe-Administrativo')) {
            $query->where('empleado.tipo_empleado', 'Administrativo');
        }

        $empleados = $query->get();

        //jefes de recurso humanos

        $jefes = User::whereHas("roles", function ($q) {
            $q->where("name", "Recurso-Humano");
        })->get();


        //enviado los correos
        foreach ($jefes as $key => $item) {
            if(!is_null($item->email) && !empty($item->email))
                Mail::to($item->email)->send(new JornadaEmail($empleado, $periodo, $deptos, $empleados));
        }

        //Mail::to('mr15058@ues.edu.sv')->send(new JornadaEmail($empleado, $periodo, $deptos, $empleados));

        // return view('Mails.jornada', compact(['empleado', 'periodo', 'deptos', 'empleados']));

        return redirect()->back();
    }

    //funcion para verificar si es necesario agregar la jornada del user actual, con el departamento
    public function fnCheckAddCurrentData(){
        $user = Auth::user();
        $empleado = $user->empleado_rf;
        $add = false;
        if(!$user->hasRole('super-admin') && !$user->hasRole('Recurso-Humano')){
            if (
                ($user->hasRole('Jefe-Administrativo') && $user->hasRole('Jefe-Academico'))
                || ($user->hasRole('Jefe-Administrativo') && $user->hasRole('Docente'))
                || ($user->hasRole('Jefe-Academico') && (strcmp($empleado->tipo_empleado, 'Académico')==0 || strcmp($empleado->tipo_empleado, 'Administrativo') == 0 ))
                || ($user->hasRole('Jefe-Administrativo') && (strcmp($empleado->tipo_empleado, 'Administrativo')==0))
            ) {
                $add = true;
            }
            // if ($user->hasRole('Jefe-Administrativo') && $user->hasRole('Jefe-Academico')) {
            //     $add = true;
            // } else if ($user->hasRole('Jefe-Administrativo') && strcmp('Académico', $empleado->tipo_empleado)==0) {
            //     $add = true;
            // }else if($user->hasRole('Jefe-Academico')){
            //     $add = true;
            // }
        }


        // dd($add);

        return $add;
    }

}

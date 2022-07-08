<?php

namespace App\Http\Controllers\Licencias;

use App\Http\Controllers\Controller;
use App\Models\General\Empleado;
use App\Models\Horarios\Departamento;
use App\Models\Jornada\Jornada;
use App\Models\Licencias\Permiso;
use App\Models\Reloj\Reloj_dato;
use PDF;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ReporteController extends Controller
{
    //PARA GENERAR EL PDF DE LOS DESCUENTOS
    public function DescuentosPDF(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'id_depto'  => 'required',
            'anio'      => 'required',
            'mes'       => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }


        if ($request->mes == '1') {
            $mes = 'Enero';
            $dias = 31;
        } elseif ($request->mes == '2') {
            $mes = 'Febrero';
            //año bisiesto
            if (date('L', strtotime("$request->anio-01-01"))) {
                $dias = 29;
            } else {
                $dias = 28;
            }
            //echo dd($dias);
        } elseif ($request->mes == '3') {
            $mes = 'Marzo';
            $dias = 31;
        } elseif ($request->mes == '4') {
            $mes = 'Abril';
            $dias = 30;
        } elseif ($request->mes == '5') {
            $mes = 'Mayo';
            $dias = 31;
        } elseif ($request->mes == '6') {
            $mes = 'Junio';
            $dias = 30;
        } elseif ($request->mes == '7') {
            $mes = 'Julio';
            $dias = 31;
        } elseif ($request->mes == '8') {
            $mes = 'Agosto';
            $dias = 31;
        } elseif ($request->mes == '9') {
            $mes = 'Septiembre';
            $dias = 30;
        } elseif ($request->mes == '10') {
            $mes = 'Octubre';
            $dias = 31;
        } elseif ($request->mes == '11') {
            $mes = 'Noviembre';
            $dias = 30;
        } elseif ($request->mes == '12') {
            $mes = 'Diciembre';
            $dias = 31;
        }
        $departamento = Departamento::where('id', '=', $request->id_depto)->get();

        //echo dd($departamento);

        $empleados = Empleado::selectRaw('empleado.id, nombre, apellido,departamentos.nombre_departamento')
            ->join('departamentos', 'departamentos.id', '=', 'empleado.id_depto')
            ->where('departamentos.id', $request->id_depto)
            ->get();

        $query = "select des.nombre, des.salario,string_agg(des.fecha,', ') dias, string_agg(des.jornada::varchar,', ' ) jornada, sum(des.minutosSimples) minutosSimples,
        sum(des.descuento) descuentos,string_agg(des.minutosSimples::varchar,', ')minutos,string_agg(des.solvente,', ') solvente
        from (
            select e.id,to_char((r.entrada::time-ji.hora_inicio::time)-r.gracia::time,'HH24:MI') hrs_input,/**/

            (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
            THEN('0') 
            else ( to_char((r.entrada::time-ji.hora_inicio::time),'HH24')::integer *60+(to_char(((r.entrada::time-ji.hora_inicio::time)::time),'MI'))::integer)-
                to_char(r.gracia::time,'MI')::numeric end)::integer  minutosSimples,
         			 
        
             TRIM(e.apellido)||' '||TRIM(e.nombre) as nombre, e.salario,r.entrada,to_char(r.fecha::date,'DD') fecha, 
            to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::numeric + 
              ROUND(to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::numeric/60,2) jornada,
        

         ROUND(( 
        ((e.salario/" . $dias . ")/(to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::numeric + 
        to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::numeric/60)/60)::numeric *
        
        ( ((CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
            THEN('0') 
            else ( to_char((r.entrada::time-ji.hora_inicio::time),'HH24')::integer *60+(to_char(((r.entrada::time-ji.hora_inicio::time)::time),'MI'))::integer)-
                to_char(r.gracia::time,'MI')::numeric end)::integer))
        
            ),2) descuento,
             /*agregando detalle*/
            (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
            THEN('Solventó') 
            else ('Deficit') end) solvente

         /*fin del detalle que corregio*/
        from empleado e 
        inner join jornada ON e.id = jornada.id_emp
        inner join periodos on periodos.id = jornada.id_periodo
        inner join jornada_items ji ON ji.id_jornada = jornada.id
        inner join reloj_datos r on e.dui=r.id_persona
        where e.id_depto=" . $request->id_depto . " and e.dui=r.id_persona
        and jornada.procedimiento='aceptado' and periodos.estado='activo'
        and ji.dia=r.dia_semana and ji.hora_inicio::time+'00:05:59' < r.entrada::time
        and  to_char(r.fecha::date,'YYYY')::int=" . $request->anio . "
        and to_char(r.fecha::date,'MM')::int=" . $request->mes . " and r.entrada !='-'
        GROUP BY  e.nombre,e.id,r.entrada,r.fecha,ji.hora_inicio, r.salida,ji.hora_fin,r.gracia order by r.fecha) des 
        GROUP BY des.nombre,des.salario,des.jornada";

        $query = trim($query);

        $todosDescuentos = DB::select($query);
        //DESCUENTO POR INASISTENCIA
        $query_inasistencia = "select TRIM(pivot.ap)||' '||TRIM(pivot.em) as nombre ,pivot.salario,string_agg(pivot.fecha,', ') dia_mes, string_agg(pivot.jornada::varchar,', ') jornadas,

        (sum(pivot.inas_entrada::time)+ sum(pivot.inas_salida::time)+sum(pivot.inas_entrada_salida::time)+sum(pivot.inas_salida_antes::time)) hrs_inasis,

        (sum(pivot.minutos_entrada)+ sum(pivot.minutos_salida)+sum(pivot.minutos_entrada_salida)+sum(pivot.minutos_salida_antes)) minutos,
        (sum(pivot.descuento_entrada)+ sum(pivot.descuento_salida)+sum(pivot.descuento_entrada_salida)+sum(pivot.descuento_salida_antes)) descuento,
        string_agg(pivot.min_dias, ', ')horas_dias, string_agg(pivot.solvente,', ')solvente
        from(
            select
            /*calculo por horas*/
            (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
                    THEN
                    ((CASE WHEN (r.entrada='-' AND r.salida !='-') THEN 
                    ('00:00') else ('00:00')
                     END)) 
                     else ((CASE WHEN (r.entrada='-' AND r.salida !='-') THEN 
                    (to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24:MI')) else ('00:00')
                     END)) END) inas_entrada,
                 
            (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
                    THEN
                    ((CASE WHEN (r.entrada !='-' AND r.salida ='-') THEN 
                    ('00:00') else ('00:00')
                     END)) 
                     else ((CASE WHEN (r.entrada !='-' AND r.salida ='-') THEN 
                    (to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24:MI')) else ('00:00')
                     END)) END) inas_salida,
                 
            (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
                    THEN
                    ((CASE WHEN (r.entrada ='-' AND r.salida ='-') THEN 
                    ('00:00') else ('00:00')
                     END)) 
                     else ((CASE WHEN (r.entrada ='-' AND r.salida ='-') THEN 
                    (to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24:MI')) else ('00:00')
                     END)) END) inas_entrada_salida,
                 
            (CASE WHEN (r.entrada !='-' AND r.salida !='-' AND r.salida<ji.hora_fin) THEN 
            (to_char(ji.hora_fin::time-r.salida::time,'HH24:MI')) else ('00:00')
             end)inas_salida_antes,
                 
            /*fin calculo por horas*/

            e.nombre as em, e.apellido as ap,r.entrada, r.salida,to_char(r.fecha::date,'DD') fecha,
            /*agregando detalle*/
            (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
            THEN('Solventó') 
            else ('Deficit') end) solvente,
                /*Agregando detalle*/
                
             to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::numeric + 
              ROUND(to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::numeric/60,2) jornada,
            e.salario,
            /*-- calculo de minutos entrada--*/
            (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
                    THEN
                    ((CASE WHEN (r.entrada='-' AND r.salida !='-') THEN 
                    ('0') else ('0')
                     END)) 
                     else ((CASE WHEN (r.entrada='-' AND r.salida !='-') THEN 
                    (to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')) else ('0')
                     END)) END)::integer*60--horas/minutos-- 
            +
            (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
                    THEN
                    ((CASE WHEN (r.entrada='-' AND r.salida !='-') THEN 
                    ('0') else ('0')
                     END)) 
                     else ((CASE WHEN (r.entrada='-' AND r.salida !='-') THEN 
                    (to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')) else ('0')
                     END)) END)::integer--minutos--
                    minutos_entrada,
                 
            /*Descuento entrada*/
                 
            ROUND(( 
                          ((e.salario/".$dias.")/(to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::numeric + 
                          to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::numeric/60)/60)::numeric * --por minutos
                (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
                    THEN
                    ((CASE WHEN (r.entrada='-' AND r.salida !='-') THEN 
                    ('0') else ('0')
                     END)) 
                     else ((CASE WHEN (r.entrada='-' AND r.salida !='-') THEN 
                    (to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')) else ('0')
                     END)) END)::integer*60--horas/minutos-- 
            +
            (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
                    THEN
                    ((CASE WHEN (r.entrada='-' AND r.salida !='-') THEN 
                    ('0') else ('0')
                     END)) 
                     else ((CASE WHEN (r.entrada='-' AND r.salida !='-') THEN 
                    (to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')) else ('0')
                     END)) END)::integer--minutos--
            
                      ),2) descuento_entrada,
            /*fin descuento entrada*/
    
            
             /*minutos salida*/
            (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
                    THEN
                    ((CASE WHEN (r.entrada !='-' AND r.salida ='-') THEN 
                    ('0') else ('0')
                     END)) 
                     else ((CASE WHEN (r.entrada !='-' AND r.salida ='-') THEN 
                    (to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')) else ('0')
                     END)) END)::integer*60 --horas/minutos
            +
            (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
                    THEN
                    ((CASE WHEN (r.entrada !='-' AND r.salida ='-') THEN 
                    ('0') else ('0')
                     END)) 
                     else ((CASE WHEN (r.entrada !='-' AND r.salida ='-') THEN 
                    (to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')) else ('0')
                     END)) END)::integer --minutos
                  minutos_salida,
            
            /*fin minutos salida*/
                 
            /*descuento salida*/
                 
            ROUND(( 
                          ((e.salario/".$dias.")/(to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::numeric + 
                          to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::numeric/60)/60)::numeric  * --por minutos
                (
                     (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
                    THEN
                    ((CASE WHEN (r.entrada !='-' AND r.salida ='-') THEN 
                    ('0') else ('0')
                     END)) 
                     else ((CASE WHEN (r.entrada !='-' AND r.salida ='-') THEN 
                    (to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')) else ('0')
                     END)) END)::integer*60 --horas/minutos
            +
            (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
                    THEN
                    ((CASE WHEN (r.entrada !='-' AND r.salida ='-') THEN 
                    ('0') else ('0')
                     END)) 
                     else ((CASE WHEN (r.entrada !='-' AND r.salida ='-') THEN 
                    (to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')) else ('0')
                     END)) END)::integer --minutos
                            
                )     
                      ),2) descuento_salida,
                 
            /*fin descuento salida*/
    
           
            
            /*minutos entrada-salida*/
            CASE WHEN ((select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and permisos.tipo_permiso='Const. olvido')>=2)
            THEN('0')
            ELSE(
            /*MINUTOS PARA LA LICENCIA CON GOSE*/
            (CASE WHEN(r.entrada ='-' AND r.salida ='-' AND (select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and (permisos.tipo_permiso='LC/GS' OR permisos.tipo_permiso='LS/GS'))>0)
                    THEN
                    (/*MODIFICACION EN EL CASO QUE NO MARQUE BIEN EL RELOJ*/	
                    select (to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::integer*60 +
                     to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::integer)-
                        (to_char((permisos.hora_final-permisos.hora_inicio),'HH24')::integer*60 +
                     to_char((permisos.hora_final-permisos.hora_inicio),'MI')::integer) from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and permisos.tipo_permiso='LC/GS')::varchar
                     else (/*else*/
                    (CASE WHEN (r.entrada ='-' AND r.salida ='-') THEN 
                    ((to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::integer*60 +
                     to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::integer)::varchar)else('0') 
                     END)
                     )/*FIN ELSE*/ END)::integer--minutos
                
            /*FIN DE MINUTOS PARA LA LICENCIA CON GOSE*/
            )END
             minutos_entrada_salida,
                 
            /*fin de minutos entrada-salida*/
            
            /*descuento entrada salida*/
            ROUND(( 
                          ((e.salario/".$dias.")/(to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::numeric + 
                          to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::numeric/60)/60)::numeric * --por minutos
                (CASE WHEN ((select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and permisos.tipo_permiso='Const. olvido')>=2)
            THEN('0')
            ELSE(
            /*MINUTOS PARA LA LICENCIA CON GOSE*/
            (CASE WHEN(r.entrada ='-' AND r.salida ='-' AND (select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and (permisos.tipo_permiso='LC/GS' OR permisos.tipo_permiso='LC/GS'))>0)
                    THEN
                    (/*MODIFICACION EN EL CASO QUE NO MARQUE BIEN EL RELOJ*/	
                    select (to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::integer*60 +
                     to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::integer)-
                        (to_char((permisos.hora_final-permisos.hora_inicio),'HH24')::integer*60 +
                     to_char((permisos.hora_final-permisos.hora_inicio),'MI')::integer) from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and (permisos.tipo_permiso='LC/GS' OR permisos.tipo_permiso='LC/GS'))::varchar
                     else (/*else*/
                    (CASE WHEN (r.entrada ='-' AND r.salida ='-') THEN 
                    ((to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::integer*60 +
                     to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::integer)::varchar)else('0') 
                     END)
                     )/*FIN ELSE*/ END)::integer--minutos
                
            /*FIN DE MINUTOS PARA LA LICENCIA CON GOSE*/
            )END
                )  
                      ),2) descuento_entrada_salida,
                 
            /*fin de descuento entrada salida*/
            
              /*minutos salida antes*/
              
            (CASE WHEN (r.entrada !='-' AND r.salida !='-' AND (select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and (permisos.tipo_permiso='LC/GS' OR permisos.tipo_permiso='LS/GS'))>0) 
             THEN 
            (
            case when ((select (to_char((ji.hora_fin::time-r.salida::time),'HH24')::integer*60 +
                     to_char((ji.hora_fin::time-r.salida::time),'MI')::integer)-
                        (to_char((permisos.hora_final-permisos.hora_inicio),'HH24')::integer*60 +
                     to_char((permisos.hora_final-permisos.hora_inicio),'MI')::integer)from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and (permisos.tipo_permiso='LC/GS' OR permisos.tipo_permiso='LC/GS'))>0)
                then(
                    select (to_char((ji.hora_fin::time-r.salida::time),'HH24')::integer*60 +
                     to_char((ji.hora_fin::time-r.salida::time),'MI')::integer)-
                 (to_char((permisos.hora_final-permisos.hora_inicio),'HH24')::integer*60 +
                     to_char((permisos.hora_final-permisos.hora_inicio),'MI')::integer)from permisos
                        
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and (permisos.tipo_permiso='LC/GS' OR permisos.tipo_permiso='LC/GS')
                    /**/
                )
                else(
                select (to_char((permisos.hora_final-permisos.hora_inicio),'HH24')::integer*60 +
                     to_char((permisos.hora_final-permisos.hora_inicio),'MI')::integer)-
                (to_char((ji.hora_fin::time-r.salida::time),'HH24')::integer*60 +
                     to_char((ji.hora_fin::time-r.salida::time),'MI')::integer)
                    from permisos	
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and (permisos.tipo_permiso='LC/GS' OR permisos.tipo_permiso='LC/GS')
                
                )end
            
            ) ELSE (
            
           ((CASE WHEN (r.entrada !='-' AND r.salida !='-' AND r.salida<ji.hora_fin ) THEN 
            (to_char(ji.hora_fin::time-r.salida::time,'HH24')) else ('0')
             end)::integer*60 --horas/minutos
            +
            (CASE WHEN (r.entrada !='-' AND r.salida !='-' AND r.salida<ji.hora_fin) THEN 
            (to_char(ji.hora_fin::time-r.salida::time,'MI')) else ('0')
             end)::integer --minutos
           )
            ) END )minutos_salida_antes,
            /*fin de minutos salida antes*/
            
            /*descuento por salida antes*/
            ROUND(( 
                          ((e.salario/".$dias.")/(to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::numeric + 
                          to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::numeric/60)/60)::numeric*  --por minutos
            ((CASE WHEN (r.entrada !='-' AND r.salida !='-' AND (select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and (permisos.tipo_permiso='LC/GS' OR permisos.tipo_permiso='LS/GS'))>0) 
             THEN 
            (
            case when ((select (to_char((ji.hora_fin::time-r.salida::time),'HH24')::integer*60 +
                     to_char((ji.hora_fin::time-r.salida::time),'MI')::integer)-
                        (to_char((permisos.hora_final-permisos.hora_inicio),'HH24')::integer*60 +
                     to_char((permisos.hora_final-permisos.hora_inicio),'MI')::integer)from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and (permisos.tipo_permiso='LC/GS' OR permisos.tipo_permiso='LC/GS'))>0)
                then(
                    select (to_char((ji.hora_fin::time-r.salida::time),'HH24')::integer*60 +
                     to_char((ji.hora_fin::time-r.salida::time),'MI')::integer)-
                 (to_char((permisos.hora_final-permisos.hora_inicio),'HH24')::integer*60 +
                     to_char((permisos.hora_final-permisos.hora_inicio),'MI')::integer)from permisos
                        
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and (permisos.tipo_permiso='LC/GS' OR permisos.tipo_permiso='LC/GS')
                    /**/
                )
                else(
                select (to_char((permisos.hora_final-permisos.hora_inicio),'HH24')::integer*60 +
                     to_char((permisos.hora_final-permisos.hora_inicio),'MI')::integer)-
                (to_char((ji.hora_fin::time-r.salida::time),'HH24')::integer*60 +
                     to_char((ji.hora_fin::time-r.salida::time),'MI')::integer)
                    from permisos	
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and (permisos.tipo_permiso='LC/GS' OR permisos.tipo_permiso='LC/GS')
                
                )end
            
            ) ELSE (
            
           ((CASE WHEN (r.entrada !='-' AND r.salida !='-' AND r.salida<ji.hora_fin ) THEN 
            (to_char(ji.hora_fin::time-r.salida::time,'HH24')) else ('0')
             end)::integer*60 --horas/minutos
            +
            (CASE WHEN (r.entrada !='-' AND r.salida !='-' AND r.salida<ji.hora_fin) THEN 
            (to_char(ji.hora_fin::time-r.salida::time,'MI')) else ('0')
             end)::integer --minutos
          )
            ) END ))
                
                           
                      ),2) descuento_salida_antes,
            
            /*fin descuento por salida antes*/

            /*PARA SACAR LOS MINUTOS*/
            (CASE WHEN(r.entrada ='-' OR r.salida ='-' ) 
            THEN((to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24:MI'))::varchar)
            ELSE((to_char((ji.hora_fin::time-r.salida::time),'HH24:MI'))::varchar)
            END)min_dias
            /*PARA SACAR LOS MINUTOS*/
            
            from empleado e 
            inner join jornada ON e.id = jornada.id_emp
            inner join periodos on periodos.id = jornada.id_periodo
            inner join jornada_items ji ON ji.id_jornada = jornada.id
            inner join reloj_datos r on e.dui=r.id_persona
            where e.id_depto=" . $request->id_depto . " and e.dui=r.id_persona
            and jornada.procedimiento='aceptado' and periodos.estado='activo'
            and ji.dia=r.dia_semana 
            and  to_char(r.fecha::date,'YYYY')::int=" . $request->anio . "
            and to_char(r.fecha::date,'MM')::int=" . $request->mes . "
            and (r.salida <= ji.hora_fin or r.entrada='-' or r.salida='-')
            GROUP BY  e.nombre,e.id,r.entrada,r.fecha,ji.hora_inicio, r.salida,ji.hora_fin
            order by e.nombre,r.fecha) pivot GROUP by pivot.em,pivot.ap,pivot.salario";

        $query_inasistencia = trim($query_inasistencia);

        $todosDescuentos_inasistencia = DB::select($query_inasistencia);

        //FIN DE DESCUENTO POR INASISTENCIA

        //PARA GENERAR TODOS LOS DESCUENTOS POR LICENCIA SIN GOSE DE SUELDO
        $licencia_sinGoce = "select TRIM(gs.ap)||' '||TRIM(gs.nombre) as nombre,string_agg(gs.fecha, ', ') fecha,sum(gs.total_minutos) total_minutos, string_agg(gs.jornada::varchar,', ') jornada,
        gs.salario,sum(gs.descuento) descuento
        from(select
        e.nombre as nombre, e.apellido as ap,to_char(r.fecha::date,'DD') fecha ,permisos.hora_inicio,permisos.hora_final,
        r.entrada,r.salida,
        /*tiempo licencia sin gose HORAS*/
        (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and permisos.tipo_permiso='LS/GS')>0)
                THEN
                (to_char((permisos.hora_final-permisos.hora_inicio),'HH24:MI:SS')) 
                 else (('0')) END) total_hora,
        /*fin de tiempo de licencia sin gose HORAS*/
        /*timempo en minutos de licencia sin gose*/
        (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and permisos.tipo_permiso='LS/GS')>0)
                THEN
                (to_char((permisos.hora_final-permisos.hora_inicio),'HH24')::integer*60 +
                 to_char((permisos.hora_final-permisos.hora_inicio),'MI')::integer +
                 Round(to_char((permisos.hora_final-permisos.hora_inicio),'SS')::numeric*60/3600,2)
                ) 
                 else (('0')) END) total_minutos,
        /*JORNADA*/
         to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::numeric + 
          ROUND(to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::numeric/60,2) jornada,
        /*FIN DE JORNADA*/
        e.salario, /*SALARIO*/
        /*fin de tiempo en minutos licencia sin gose*/
        
        /*descuento*/
        ROUND(( 
                      ((e.salario/" . $dias . ")/(to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::numeric + 
                      to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::numeric/60)/60)::numeric * --por minutos
            (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and permisos.tipo_permiso='LS/GS')>0)
                THEN
                (to_char((permisos.hora_final-permisos.hora_inicio),'HH24')::integer*60 +
                 to_char((permisos.hora_final-permisos.hora_inicio),'MI')::integer +
                 Round(to_char((permisos.hora_final-permisos.hora_inicio),'SS')::numeric*60/3600,2)
                ) 
                 else (('0')) END)
        
                       
                  ),2) descuento
        
        /*fin de descuento*/
         
        from empleado e 
        inner join permisos ON permisos.empleado = e.id
        inner join jornada ON e.id = jornada.id_emp
        inner join periodos on periodos.id = jornada.id_periodo
        inner join jornada_items ji ON ji.id_jornada = jornada.id
        inner join reloj_datos r on e.dui=r.id_persona
        where e.id_depto=" . $request->id_depto . " and e.dui=r.id_persona
        and ji.dia=r.dia_semana and r.entrada='-' and r.salida='-'
        and jornada.procedimiento='aceptado' and periodos.estado='activo'
        and permisos.tipo_permiso='LS/GS' and permisos.estado='Aceptado'
        and  to_char(r.fecha::date,'YYYY')::int=" . $request->anio . "
        and to_char(r.fecha::date,'MM')::int=" . $request->mes . "
        and to_char(permisos.fecha_uso,'YYYY')::int=" . $request->anio . "
        and to_char(permisos.fecha_uso,'MM')::int=" . $request->mes . "
        GROUP BY  e.nombre,e.id,r.entrada,r.fecha,ji.hora_inicio, r.salida,ji.hora_fin,permisos.hora_inicio,permisos.hora_final
        order by e.nombre,r.fecha
        )gs GROUP BY gs.ap, gs.nombre,gs.fecha,gs.salario
        ";
        $licencia_sinGoce = trim($licencia_sinGoce);
        $sin_gose = DB::select($licencia_sinGoce);
        //FIN PARA GENERAR TODOS LOS DESCUENTOS POR LICENCIA SIN GOSE DE SUELDO
        //echo dd($todosDescuentos);

        $pdf = PDF::loadView('Reportes.Descuentos.Descuentos', compact('departamento', 'empleados', 'todosDescuentos', 'request', 'mes', 'dias', 'todosDescuentos_inasistencia', 'sin_gose'));
        foreach ($departamento as $r) {
            $nombre = $r->nombre_departamento;
        }
        return $pdf->setPaper('A4', 'Landscape')->download('Descuentos ' . $nombre . ' ' . $mes . ' ' . $request->anio . '.pdf');
    }


    //FIN DE GENERAR EL PDF DE LOS DECUENTOS

    //FUNCTION PARA LA EXONERACION DE MINUTOS DE GRACIA
    public function Gracias(Request $request)
    {
        $minutos_g = '00:30:00';
        [$horas, $minutos, $segundos] = explode(':', $minutos_g);
        $GraciaTotal = $horas * 3600 + $minutos * 60 + $segundos;
        $GraciaSumar = 0;
        $Gracias5 = 300;
        // echo dd($segundos_g);
        //CONSULTA PARA EXTRAER LAS LLEGADAS TARDE
        $query = "        
        select r.id,e.nombre, r.entrada,r.fecha,to_char((r.entrada::time-ji.hora_inicio::time),'HH24:MI:SS') hrs_input
        from empleado e 
        inner join jornada ON e.id = jornada.id_emp
        inner join jornada_items ji ON ji.id_jornada = jornada.id
        inner join reloj_datos r on e.dui=r.id_persona
        where e.id=" . $request->_id_g . "  and e.dui=r.id_persona
        and ji.dia=r.dia_semana and ji.hora_inicio::time < r.entrada::time
        and  to_char(r.fecha::date,'YYYY')::int=" . $request->asis_anio . "
        and to_char(r.fecha::date,'MM')::int=" . $request->asis_mes . " and r.entrada !='-'
        GROUP BY  r.id,e.nombre,r.entrada,r.fecha,r.id_persona,ji.hora_inicio
        order by r.fecha asc;";

        $query = trim($query);

        $datos = DB::select($query);
        //FIN DE CONSULTA PARA DETERMINAR LAS LLEGADAS TARDES

        foreach ($datos as $item) {

            //VAMOS A COVERTIR A SEGUNDOS LOS MINUTOS DE DIFERENCIA DE ENTRADA DE JORNADA Y MARCAJE
            [$horas, $minutos, $segundos] = explode(':', $item->hrs_input);
            $segundos_aplicar = $horas * 3600 + $minutos * 60 + $segundos;

            //if para que no se pase de los 30 minutos

            if ($GraciaSumar < $GraciaTotal) {

                if ($segundos_aplicar < $Gracias5) {

                    if ($GraciaSumar < $item->hrs_input) {
                        $aplicar = $GraciaTotal - $GraciaSumar;

                        $minutos = $aplicar / 60;
                        $horas = floor($minutos / 60);
                        $minutos2 = $minutos % 60;
                        $segundos_2 = (($aplicar % 60) % 60) % 60;

                        if ($minutos2 < 10) {
                            $minutos2 = '0' . $minutos2;
                        }

                        if ($segundos_2 < 10) {
                            $segundos_2 = '0' . $segundos_2;
                        }

                        if ($aplicar < 60) {
                            /* segundos */
                            $resultado = round($segundos);
                        } elseif ($aplicar > 60 && $aplicar < 3600) {
                            /* minutos */
                            $resultado = $horas . ':' . $minutos2 . ':' . $segundos_2;
                        } else {
                            /* horas */
                            $resultado = $horas . ':' . $minutos2 . ':' . $segundos_2;
                        }


                        $actualizar = "UPDATE reloj_datos
                    SET gracia = " . $resultado . "
                   WHERE id=" . $item->id . ";";

                        $actualizar = trim($actualizar);
                        DB::select($actualizar);

                        $GraciaSumar = $GraciaSumar + $aplicar;
                    } else {

                        $actualizar = "UPDATE reloj_datos
                SET gracia = '" . $item->hrs_input . "'
                 WHERE id=" . $item->id . ";";

                        $actualizar = trim($actualizar);
                        DB::select($actualizar);

                        $GraciaSumar = $GraciaSumar + $segundos_aplicar;
                    }
                } else if ($segundos_aplicar >= $Gracias5) {

                    if (($GraciaTotal - $GraciaSumar) <= $Gracias5) {
                        //CONVERTIR DE SEGUNDOS A HORAS MINUTOS Y SEGUNDOS
                        $suma = ($GraciaTotal - $GraciaSumar);
                        $minutos = $suma / 60;
                        $horas = floor($minutos / 60);
                        $minutos2 = $minutos % 60;
                        $segundos_2 = (($suma % 60) % 60) % 60;

                        if ($minutos2 < 10) {
                            $minutos2 = '0' . $minutos2;
                        }

                        if ($segundos_2 < 10) {
                            $segundos_2 = '0' . $segundos_2;
                        }

                        if ($suma < 60) {
                            /* segundos */
                            $resultado2 = round($segundos);
                        } elseif ($suma > 60 && $suma < 3600) {
                            /* minutos */
                            $resultado2 = $horas . ':' . $minutos2 . ':' . $segundos_2;
                        } else {
                            /* horas */
                            $resultado2 = $horas . ':' . $minutos2 . ':' . $segundos_2;
                        }

                        //FIN DE SEGUNDOS A HORAS MINUTOS Y SEGUNDOS
                        $actualizar = "UPDATE reloj_datos
                              SET gracia = '" . $resultado2 . "'
                              WHERE id=" . $item->id . ";";

                        $actualizar = trim($actualizar);
                        DB::select($actualizar);
                        $GraciaSumar = $GraciaSumar + 300;
                    } else {
                        $actualizar = "UPDATE reloj_datos
                              SET gracia = '00:05:00'
                              WHERE id=" . $item->id . ";";

                        $actualizar = trim($actualizar);
                        DB::select($actualizar);
                        $GraciaSumar = $GraciaSumar + 300;
                    }
                }
                //fin de aplicación de minutos de gracia
            } else {
                $actualizar = "UPDATE reloj_datos
                SET gracia = '00:00:00'
                WHERE id=" . $item->id . ";";

                $actualizar = trim($actualizar);
                DB::select($actualizar);
                $GraciaSumar = $GraciaSumar + 300;
            }
        }

        return response()->json(['mensaje' => 'Exoneración exitosa!']);
    }
    //FIN DE FUNCTION DE EXONERACION DE MINUTOS DE GRACIA
    //PARA LA TABLA DE LA VISTA DEL BLADE
    public function datableAsistenciaJson($depto)
    {

        $empleados = Empleado::orderBy('id')
            ->join('categoria_empleados', 'categoria_empleados.id', '=', 'empleado.categoria')
            ->join('tipo_contrato', 'tipo_contrato.id', '=', 'empleado.id_tipo_contrato')
            ->join('tipo_jornada', 'tipo_jornada.id', '=', 'empleado.id_tipo_jornada')
            ->join('departamentos', 'departamentos.id', '=', 'empleado.id_depto')
            ->select(
                'empleado.*',
                'categoria_empleados.categoria as categoria',
                'tipo_contrato.tipo as contrato',
                'tipo_jornada.tipo as jornada',
                'departamentos.nombre_departamento as departamento'
            );


        if ($depto != 'todos') {
            $empleados = $empleados->where([['empleado.id_depto', $depto], ['empleado.estado', true]]);
        } else {
            $empleados = $empleados->where('empleado.estado', true);
        }



        $empleados = $empleados->get();

        $i = 0;

        foreach ($empleados as $item) {
            # code...
            $i++;
            $botones =
                '<div class="row">
                <div class="col text-center">
                    <div class="btn-group" role="group">
                    <button title="Ver Asistencia" class="btn btn-outline-success btn-sm"
                    value="' . $item->dui . '" onclick="AsistenciaMen(this)">
                    <i class="fa fa-calendar font-16 my-1" aria-hidden="true"></i>
                    </button>
                        <button title="Ver Impuntualidad" class="btn btn-outline-primary btn-sm"
                            value="' . $item->id . '" onclick="Asis(this)">
                            <i class="fa fa-print font-16 my-1" aria-hidden="true"></i>
                        </button>
                        <button title="Descuento" class="btn btn-outline-danger btn-sm"
                        value="' . $item->id . '" onclick="descuento(this)">
                        <i class="fa fa-calculator font-16 my-1" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>';


            $data[] = array(
                "col0" =>  $i,
                "col1" =>  $item->nombre . ' ' . $item->apellido,
                "col2" => $item->categoria,
                "col3" => $item->contrato,
                "col4" => $item->jornada,
                "col5" => $item->departamento,
                "col6" => $botones,
            );
        }
        return isset($data) ? response()->json($data, 200, []) : response()->json([], 200, []);
    }
    //FIN DE PARA MOSTRAR LA VISTA EN EL BLADE
    //PARA MOSTRAR LA LISTA DE ASISTENCIA EN EL BLADE
    public function indexAsistencia()
    {
        //para extraer los departamentos
        $años = Reloj_dato::selectRaw('distinct to_char(reloj_datos.fecha::date, \'YYYY\') as año')->get();
        $departamentos = DB::table('departamentos')->select('id', 'nombre_departamento')->get();
        return view('Reportes.Asistencia.ListaAsistencia', compact('departamentos', 'años'));
    }
    //FIN DE MOSTRAR VISTA EN EL BLADE PARA LA ASISTENCIA

    //PARA GENERAR LA ASISTENCIA EN PDF
    public function AsistenciaPDF(Request $request)
    {



        $empleadito = Empleado::selectRaw('nombre, apellido,departamentos.nombre_departamento')
            ->join('departamentos', 'departamentos.id', '=', 'empleado.id_depto')
            ->where('empleado.id', $request->_id)
            ->get();

        $jornada = Jornada::selectRaw('jornada_items.dia, jornada_items.hora_inicio,jornada_items.hora_fin')
            ->join('periodos', 'periodos.id', '=', 'jornada.id_periodo')
            ->join('jornada_items', 'jornada_items.id_jornada', '=', 'jornada.id')
            ->where([['jornada.id_emp', $request->_id], ['periodos.estado', 'activo']])
            ->get();

        $periodos = Jornada::selectRaw('periodos.fecha_inicio,periodos.fecha_fin ')
            ->join('periodos', 'periodos.id', '=', 'jornada.id_periodo')
            ->where([['jornada.id_emp', $request->_id], ['periodos.estado', 'activo']])
            ->get();

        $query = " select r.fecha,ji.hora_inicio,r.entrada, to_char((r.entrada::time-ji.hora_inicio::time),'HH24:MI:SS') hrs_input,'00:05:00' as gracia,
            to_char(((r.entrada::time-ji.hora_inicio::time)-'00:05'),'HH24:MI:SS') hrs_totales,
            e.nombre as em
            from empleado e 
            inner join jornada ON e.id = jornada.id_emp
            inner join jornada_items ji ON ji.id_jornada = jornada.id
            inner join reloj_datos r on e.dui=r.id_persona
            where e.id=" . $request->_id . " and e.dui=r.id_persona
            and ji.dia=r.dia_semana and ji.hora_inicio::time+'00:05'< r.entrada::time
            and  to_char(r.fecha::date,'YYYY')::int=" . $request->asis_anio . "
            and to_char(r.fecha::date,'MM')::int=" . $request->asis_mes . " and r.entrada !='-'
            GROUP BY  e.nombre,e.id,r.entrada,r.fecha,ji.hora_inicio, r.salida,ji.hora_fin
            ORDER BY r.fecha;";

        $query = trim($query);

        $reloj = DB::select($query);

        //consulta para la sumatoria total
        $query2 = "select sum(rep.hrs_input::time) entradas_marcajes, sum(rep.gracia::time) total_gracia, sum(rep.hrs_totales::time) total
        from(select r.fecha,ji.hora_inicio,r.entrada, to_char((r.entrada::time-ji.hora_inicio::time),'HH24:MI:SS') hrs_input,'00:05:00' as gracia,
                    to_char(((r.entrada::time-ji.hora_inicio::time)-'00:05'),'HH24:MI:SS') hrs_totales,
                    e.nombre as em
                    from empleado e 
                    inner join jornada ON e.id = jornada.id_emp
                    inner join jornada_items ji ON ji.id_jornada = jornada.id
                    inner join reloj_datos r on e.dui=r.id_persona
                    where e.id=" . $request->_id . " and e.dui=r.id_persona
                    and ji.dia=r.dia_semana and ji.hora_inicio::time+'00:05'< r.entrada::time
                    and  to_char(r.fecha::date,'YYYY')::int=" . $request->asis_anio . "
                    and to_char(r.fecha::date,'MM')::int=" . $request->asis_mes . " and r.entrada !='-'
                    GROUP BY  e.nombre,e.id,r.entrada,r.fecha,ji.hora_inicio, r.salida,ji.hora_fin
                    ORDER BY r.fecha)rep";

        $query2 = trim($query2);

        $reloj_total = DB::select($query2);

        //FIN DE LA CONSULTA PARA SUMATORIA TOTAL

        //echo dd($reloj_total);

        $pdf = PDF::loadView('Reportes.Asistencia.AsistenciaPDF', compact('empleadito', 'request', 'jornada', 'periodos', 'reloj', 'reloj_total'));
        return $pdf->setPaper('A4', 'Landscape')->download('Asistencia.pdf');
    }

    //FIN DE GENERAR LA ASISTENCIA



    //PARA GENERAR EL DESCUENTO  EN PDF
    public function DescuentoPersonalPDF(Request $request)
    {
        //echo dd($request);
        if ($request->des_mes == '1') {
            $mes = 'Enero';
            $dias = 31;
        } elseif ($request->des_mes == '2') {
            $mes = 'Febrero';
            //año bisiesto
            if (date('L', strtotime("$request->des_anio-01-01"))) {
                $dias = 29;
            } else {
                $dias = 28;
            }
            //echo dd($dias);
        } elseif ($request->des_mes == '3') {
            $mes = 'Marzo';
            $dias = 31;
        } elseif ($request->des_mes == '4') {
            $mes = 'Abril';
            $dias = 30;
        } elseif ($request->des_mes == '5') {
            $mes = 'Mayo';
            $dias = 31;
        } elseif ($request->des_mes == '6') {
            $mes = 'Junio';
            $dias = 30;
        } elseif ($request->des_mes == '7') {
            $mes = 'Julio';
            $dias = 31;
        } elseif ($request->des_mes == '8') {
            $mes = 'gosto';
            $dias = 31;
        } elseif ($request->des_mes == '9') {
            $mes = 'Septiembre';
            $dias = 30;
        } elseif ($request->des_mes == '10') {
            $mes = 'Octubre';
            $dias = 31;
        } elseif ($request->des_mes == '11') {
            $mes = 'Noviembre';
            $dias = 30;
        } elseif ($request->des_mes == '12') {
            $mes = 'Diciembre';
            $dias = 31;
        }


        $empleadito = Empleado::selectRaw('nombre, apellido,departamentos.nombre_departamento')
            ->join('departamentos', 'departamentos.id', '=', 'empleado.id_depto')
            ->where('empleado.id', $request->_id_des)
            ->get();

        $query = "select e.id,to_char((r.entrada::time-ji.hora_inicio::time)-r.gracia::time,'HH24:MI') hrs_input,/**/

            (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
                 THEN('0') 
                else ( to_char((r.entrada::time-ji.hora_inicio::time),'HH24')::integer *60+(to_char(((r.entrada::time-ji.hora_inicio::time)::time),'MI'))::integer)-
                to_char(r.gracia::time,'MI')::numeric end)::integer  minutosSimples,
                  
    
            TRIM(e.apellido)||' '||TRIM(e.nombre) as nombre, e.salario,r.entrada,r.fecha, 
          to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::numeric + 
          ROUND(to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::numeric/60,2) jornada,
    

            ROUND(( 
            ((e.salario/" . $dias . ")/(to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::numeric + 
            to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::numeric/60)/60)::numeric *
            
            ( ((CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
            THEN('0') 
            else ( to_char((r.entrada::time-ji.hora_inicio::time),'HH24')::integer *60+(to_char(((r.entrada::time-ji.hora_inicio::time)::time),'MI'))::integer)-
            to_char(r.gracia::time,'MI')::numeric end)::integer))
    
            ),2) descuento,
             /*agregando detalle*/
             (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
            THEN('Solventó') 
            else ('Deficit') end) solvente

             /*fin del detalle que corregio*/
          from empleado e 
          inner join jornada ON e.id = jornada.id_emp
          inner join periodos on periodos.id = jornada.id_periodo
          inner join jornada_items ji ON ji.id_jornada = jornada.id
          inner join reloj_datos r on e.dui=r.id_persona
          where e.id=" . $request->_id_des . " and e.dui=r.id_persona
          and jornada.procedimiento='aceptado' and periodos.estado='activo'
          and ji.dia=r.dia_semana and ji.hora_inicio::time+'00:05:59' < r.entrada::time
          and  to_char(r.fecha::date,'YYYY')::int=" . $request->des_anio . "
          and to_char(r.fecha::date,'MM')::int=" . $request->des_mes . " and r.entrada !='-'
          GROUP BY  e.nombre,e.id,r.entrada,r.fecha,ji.hora_inicio, r.salida,ji.hora_fin,r.gracia order by r.fecha";

        $query = trim($query);

        $reloj = DB::select($query);
        //PARA LOS DESCUENTOS DETALLADO POR EMPLEADO
        $query_inasistencia_per = " select              

            e.nombre as em, e.apellido as ap,r.entrada, r.salida,r.fecha,
            /*agregando detalle*/
            (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
            THEN('Solventó') 
            else ('Deficit') end) solvente,
                /*Agregando detalle*/
                
            to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::numeric + 
            ROUND(to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::numeric/60,2) jornada,
            e.salario,
            /*-- calculo de minutos entrada--*/
            (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
                THEN
                ((CASE WHEN (r.entrada='-' AND r.salida !='-') THEN 
                ('0') else ('0')
                 END)) 
                 else ((CASE WHEN (r.entrada='-' AND r.salida !='-') THEN 
                (to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')) else ('0')
                 END)) END)::integer*60--horas/minutos-- 
                +
                (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
                THEN
                ((CASE WHEN (r.entrada='-' AND r.salida !='-') THEN 
                ('0') else ('0')
                 END)) 
                 else ((CASE WHEN (r.entrada='-' AND r.salida !='-') THEN 
                (to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')) else ('0')
                 END)) END)::integer--minutos--
                minutos_entrada,
             
                /*Descuento entrada*/
                    
                ROUND(( 
                      ((e.salario/".$dias.")/(to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::numeric + 
                      to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::numeric/60)/60)::numeric * --por minutos
            (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
                THEN
                ((CASE WHEN (r.entrada='-' AND r.salida !='-') THEN 
                ('0') else ('0')
                 END)) 
                 else ((CASE WHEN (r.entrada='-' AND r.salida !='-') THEN 
                (to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')) else ('0')
                 END)) END)::integer*60--horas/minutos-- 
                +
                (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
                THEN
                ((CASE WHEN (r.entrada='-' AND r.salida !='-') THEN 
                ('0') else ('0')
                 END)) 
                 else ((CASE WHEN (r.entrada='-' AND r.salida !='-') THEN 
                (to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')) else ('0')
                 END)) END)::integer--minutos--
        
                  ),2) descuento_entrada,
                 /*fin descuento entrada*/

        
                /*minutos salida*/
                (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
                THEN
                ((CASE WHEN (r.entrada !='-' AND r.salida ='-') THEN 
                ('0') else ('0')
                 END)) 
                 else ((CASE WHEN (r.entrada !='-' AND r.salida ='-') THEN 
                (to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')) else ('0')
                 END)) END)::integer*60 --horas/minutos
                +
                (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
                THEN
                ((CASE WHEN (r.entrada !='-' AND r.salida ='-') THEN 
                ('0') else ('0')
                 END)) 
                 else ((CASE WHEN (r.entrada !='-' AND r.salida ='-') THEN 
                (to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')) else ('0')
                 END)) END)::integer --minutos
              minutos_salida,
        
                /*fin minutos salida*/
                    
                /*descuento salida*/
             
                 ROUND(( 
                      ((e.salario/".$dias.")/(to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::numeric + 
                      to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::numeric/60)/60)::numeric  * --por minutos
              (
                 (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
                THEN
                ((CASE WHEN (r.entrada !='-' AND r.salida ='-') THEN 
                ('0') else ('0')
                 END)) 
                 else ((CASE WHEN (r.entrada !='-' AND r.salida ='-') THEN 
                (to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')) else ('0')
                 END)) END)::integer*60 --horas/minutos
            +
            (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
                THEN
                ((CASE WHEN (r.entrada !='-' AND r.salida ='-') THEN 
                ('0') else ('0')
                 END)) 
                 else ((CASE WHEN (r.entrada !='-' AND r.salida ='-') THEN 
                (to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')) else ('0')
                 END)) END)::integer --minutos
                        
                )     
                    ),2) descuento_salida,
             
              /*fin descuento salida*/

       
        
                /*minutos entrada-salida*/
                CASE WHEN ((select count(fecha_uso) permiso_fecha from permisos
                        inner join empleado ON empleado.id = permisos.empleado
                        where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and permisos.tipo_permiso='Const. olvido')>=2)
                THEN('0')
                ELSE(
                /*MINUTOS PARA LA LICENCIA CON GOSE*/
                 (CASE WHEN(r.entrada ='-' AND r.salida ='-' AND (select count(fecha_uso) permiso_fecha from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and (permisos.tipo_permiso='LC/GS' OR permisos.tipo_permiso='LS/GS'))>0)
                THEN
                (/*MODIFICACION EN EL CASO QUE NO MARQUE BIEN EL RELOJ*/	
                select (to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::integer*60 +
                 to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::integer)-
                    (to_char((permisos.hora_final-permisos.hora_inicio),'HH24')::integer*60 +
                 to_char((permisos.hora_final-permisos.hora_inicio),'MI')::integer) from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and permisos.tipo_permiso='LC/GS')::varchar
                 else (/*else*/
                (CASE WHEN (r.entrada ='-' AND r.salida ='-') THEN 
                ((to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::integer*60 +
                 to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::integer)::varchar)else('0') 
                 END)
                 )/*FIN ELSE*/ END)::integer--minutos
            
            /*FIN DE MINUTOS PARA LA LICENCIA CON GOSE*/
                )END
                minutos_entrada_salida,
             
             /*fin de minutos entrada-salida*/
        
            /*descuento entrada salida*/
            ROUND(( 
                      ((e.salario/".$dias.")/(to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::numeric + 
                      to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::numeric/60)/60)::numeric * --por minutos
            (CASE WHEN ((select count(fecha_uso) permiso_fecha from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and permisos.tipo_permiso='Const. olvido')>=2)
                THEN('0')
                ELSE(
                /*MINUTOS PARA LA LICENCIA CON GOSE*/
                (CASE WHEN(r.entrada ='-' AND r.salida ='-' AND (select count(fecha_uso) permiso_fecha from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and (permisos.tipo_permiso='LC/GS' OR permisos.tipo_permiso='LC/GS'))>0)
                THEN
                (/*MODIFICACION EN EL CASO QUE NO MARQUE BIEN EL RELOJ*/	
                select (to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::integer*60 +
                 to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::integer)-
                    (to_char((permisos.hora_final-permisos.hora_inicio),'HH24')::integer*60 +
                 to_char((permisos.hora_final-permisos.hora_inicio),'MI')::integer) from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and (permisos.tipo_permiso='LC/GS' OR permisos.tipo_permiso='LC/GS'))::varchar
                 else (/*else*/
                (CASE WHEN (r.entrada ='-' AND r.salida ='-') THEN 
                ((to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::integer*60 +
                 to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::integer)::varchar)else('0') 
                 END)
                 )/*FIN ELSE*/ END)::integer--minutos
            
            /*FIN DE MINUTOS PARA LA LICENCIA CON GOSE*/
            )END
                )  
                    ),2) descuento_entrada_salida,
             
            /*fin de descuento entrada salida*/
            
            /*minutos salida antes*/
          
            (CASE WHEN (r.entrada !='-' AND r.salida !='-' AND (select count(fecha_uso) permiso_fecha from permisos
                    inner join empleado ON empleado.id = permisos.empleado
                    where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and (permisos.tipo_permiso='LC/GS' OR permisos.tipo_permiso='LS/GS'))>0) 
            THEN 
            (
            case when ((select (to_char((ji.hora_fin::time-r.salida::time),'HH24')::integer*60 +
                 to_char((ji.hora_fin::time-r.salida::time),'MI')::integer)-
                    (to_char((permisos.hora_final-permisos.hora_inicio),'HH24')::integer*60 +
                 to_char((permisos.hora_final-permisos.hora_inicio),'MI')::integer)from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and (permisos.tipo_permiso='LC/GS' OR permisos.tipo_permiso='LC/GS'))>0)
            then(
                select (to_char((ji.hora_fin::time-r.salida::time),'HH24')::integer*60 +
                 to_char((ji.hora_fin::time-r.salida::time),'MI')::integer)-
             (to_char((permisos.hora_final-permisos.hora_inicio),'HH24')::integer*60 +
                 to_char((permisos.hora_final-permisos.hora_inicio),'MI')::integer)from permisos
                    
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and (permisos.tipo_permiso='LC/GS' OR permisos.tipo_permiso='LC/GS')
                /**/
            )
            else(
            select (to_char((permisos.hora_final-permisos.hora_inicio),'HH24')::integer*60 +
                 to_char((permisos.hora_final-permisos.hora_inicio),'MI')::integer)-
            (to_char((ji.hora_fin::time-r.salida::time),'HH24')::integer*60 +
                 to_char((ji.hora_fin::time-r.salida::time),'MI')::integer)
                from permisos	
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and (permisos.tipo_permiso='LC/GS' OR permisos.tipo_permiso='LC/GS')
            
            )end
        
                ) ELSE (
                
            ((CASE WHEN (r.entrada !='-' AND r.salida !='-' AND r.salida<ji.hora_fin ) THEN 
                (to_char(ji.hora_fin::time-r.salida::time,'HH24')) else ('0')
                end)::integer*60 --horas/minutos
                +
                (CASE WHEN (r.entrada !='-' AND r.salida !='-' AND r.salida<ji.hora_fin) THEN 
                (to_char(ji.hora_fin::time-r.salida::time,'MI')) else ('0')
                end)::integer --minutos
            )
                ) END )minutos_salida_antes,
                /*fin de minutos salida antes*/
        
                /*descuento por salida antes*/
                ROUND(( 
                            ((e.salario/".$dias.")/(to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::numeric + 
                            to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::numeric/60)/60)::numeric*  --por minutos
                ((CASE WHEN (r.entrada !='-' AND r.salida !='-' AND (select count(fecha_uso) permiso_fecha from permisos
                        inner join empleado ON empleado.id = permisos.empleado
                        where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and (permisos.tipo_permiso='LC/GS' OR permisos.tipo_permiso='LS/GS'))>0) 
                THEN 
                (
             case when ((select (to_char((ji.hora_fin::time-r.salida::time),'HH24')::integer*60 +
                 to_char((ji.hora_fin::time-r.salida::time),'MI')::integer)-
                    (to_char((permisos.hora_final-permisos.hora_inicio),'HH24')::integer*60 +
                 to_char((permisos.hora_final-permisos.hora_inicio),'MI')::integer)from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and (permisos.tipo_permiso='LC/GS' OR permisos.tipo_permiso='LC/GS'))>0)
            then(
                select (to_char((ji.hora_fin::time-r.salida::time),'HH24')::integer*60 +
                 to_char((ji.hora_fin::time-r.salida::time),'MI')::integer)-
             (to_char((permisos.hora_final-permisos.hora_inicio),'HH24')::integer*60 +
                 to_char((permisos.hora_final-permisos.hora_inicio),'MI')::integer)from permisos
                    
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and (permisos.tipo_permiso='LC/GS' OR permisos.tipo_permiso='LC/GS')
                /**/
            )
            else(
            select (to_char((permisos.hora_final-permisos.hora_inicio),'HH24')::integer*60 +
                 to_char((permisos.hora_final-permisos.hora_inicio),'MI')::integer)-
            (to_char((ji.hora_fin::time-r.salida::time),'HH24')::integer*60 +
                 to_char((ji.hora_fin::time-r.salida::time),'MI')::integer)
                from permisos	
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and (permisos.tipo_permiso='LC/GS' OR permisos.tipo_permiso='LC/GS')
            
            )end
        
             ) ELSE (
        
            ((CASE WHEN (r.entrada !='-' AND r.salida !='-' AND r.salida<ji.hora_fin ) THEN 
                (to_char(ji.hora_fin::time-r.salida::time,'HH24')) else ('0')
                end)::integer*60 --horas/minutos
                +
                (CASE WHEN (r.entrada !='-' AND r.salida !='-' AND r.salida<ji.hora_fin) THEN 
                (to_char(ji.hora_fin::time-r.salida::time,'MI')) else ('0')
                end)::integer --minutos
            )
                ) END ))
            
                       
                  ),2) descuento_salida_antes,
        
                /*fin descuento por salida antes*/

                /*PARA SACAR LOS MINUTOS*/
                (CASE WHEN(r.entrada ='-' OR r.salida ='-' ) 
                THEN((to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24:MI'))::varchar)
                ELSE((to_char((ji.hora_fin::time-r.salida::time),'HH24:MI'))::varchar)
                END)min_dias
                /*PARA SACAR LOS MINUTOS*/

                from empleado e 
                inner join jornada ON e.id = jornada.id_emp
                inner join periodos on periodos.id = jornada.id_periodo
                inner join jornada_items ji ON ji.id_jornada = jornada.id
                inner join reloj_datos r on e.dui=r.id_persona
                where  e.id=" . $request->_id_des . " and e.dui=r.id_persona
                and jornada.procedimiento='aceptado' and periodos.estado='activo'
                and ji.dia=r.dia_semana 
                and  to_char(r.fecha::date,'YYYY')::int=" . $request->des_anio . "
                and to_char(r.fecha::date,'MM')::int=" . $request->des_mes . "
                and (r.salida <= ji.hora_fin or r.entrada='-' or r.salida='-')
                GROUP BY  e.nombre,e.id,r.entrada,r.fecha,ji.hora_inicio, r.salida,ji.hora_fin
                order by e.nombre,r.fecha
                ";

        $query_inasistencia_per = trim($query_inasistencia_per);

        $descuento_inasistencia = DB::select($query_inasistencia_per);
        //FIN DE PARA LOS DESCUENTOS DETALLADOS POR EMPLEADO

        //DESCUENTO POR LICENCIA SIN GOSE
        $query_licencia_sin_gose = "select
        e.nombre as nombre, e.apellido as ap,r.fecha,permisos.hora_inicio,permisos.hora_final,
        r.entrada,r.salida,
        /*tiempo licencia sin gose HORAS*/
        (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and permisos.tipo_permiso='LS/GS')>0)
                THEN
                (to_char((permisos.hora_final-permisos.hora_inicio),'HH24:MI:SS')) 
                 else (('0')) END) total_hora,
        /*fin de tiempo de licencia sin gose HORAS*/
        /*timempo en minutos de licencia sin gose*/
        (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and permisos.tipo_permiso='LS/GS')>0)
                THEN
                (to_char((permisos.hora_final-permisos.hora_inicio),'HH24')::integer*60 +
                 to_char((permisos.hora_final-permisos.hora_inicio),'MI')::integer +
                 Round(to_char((permisos.hora_final-permisos.hora_inicio),'SS')::numeric*60/3600,2)
                ) 
                 else (('0')) END) total_minutos,
        /*JORNADA*/
         to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::numeric + 
          ROUND(to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::numeric/60,2) jornada,
        /*FIN DE JORNADA*/
        e.salario, /*SALARIO*/
        /*fin de tiempo en minutos licencia sin gose*/
        
        /*descuento*/
        ROUND(( 
                      ((e.salario/" . $dias . ")/(to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24')::numeric + 
                      to_char((ji.hora_fin::time-ji.hora_inicio::time),'MI')::numeric/60)/60)::numeric * --por minutos
            (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                inner join empleado ON empleado.id = permisos.empleado
                where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado' and permisos.tipo_permiso='LS/GS')>0)
                THEN
                (to_char((permisos.hora_final-permisos.hora_inicio),'HH24')::integer*60 +
                 to_char((permisos.hora_final-permisos.hora_inicio),'MI')::integer +
                 Round(to_char((permisos.hora_final-permisos.hora_inicio),'SS')::numeric*60/3600,2)
                ) 
                 else (('0')) END)
        
                       
                  ),2) descuento
        
        /*fin de descuento*/
         
        from empleado e 
        inner join permisos ON permisos.empleado = e.id
        inner join jornada ON e.id = jornada.id_emp
        inner join periodos on periodos.id = jornada.id_periodo
        inner join jornada_items ji ON ji.id_jornada = jornada.id
        inner join reloj_datos r on e.dui=r.id_persona
        where e.id=" . $request->_id_des . " and e.dui=r.id_persona
        and ji.dia=r.dia_semana and r.entrada='-' and r.salida='-' 
		and jornada.procedimiento='aceptado' and periodos.estado='activo'
        and permisos.tipo_permiso='LS/GS' and permisos.estado='Aceptado'
        and  to_char(r.fecha::date,'YYYY')::int=" . $request->des_anio . "
        and to_char(r.fecha::date,'MM')::int=" . $request->des_mes . "
        GROUP BY  e.nombre,e.id,r.entrada,r.fecha,ji.hora_inicio, r.salida,ji.hora_fin,permisos.hora_inicio,permisos.hora_final order by r.fecha";

        $query_licencia_sin_gose = trim($query_licencia_sin_gose);

        $descuento_sin_gose = DB::select($query_licencia_sin_gose);
        //FIN DE DESCUENTO DE LICENCIA SIN GOSE



        $pdf = PDF::loadView('Reportes.Descuentos.DescuentoPersonal', compact('empleadito', 'request', 'reloj', 'descuento_inasistencia', 'descuento_sin_gose'));
        foreach ($empleadito as $em) {
            $nombre = $em->nombre . ' ' . $em->apellido . ' ' . $mes . ' ' . $request->des_anio;
        }
        return $pdf->setPaper('A4', 'Landscape')->download('Descuento ' . $nombre . '.pdf');
    }

    //FIN DE GENERAR ASISTENCIA MENUAL PARA EMPLEADOS

    //***PARA MOSTRAR EN EL BLADE DE ASISTENCIA POR EMPLEADO */
    public function bladeAsistenciaEmpleado()
    {
        $años = Reloj_dato::selectRaw('distinct to_char(reloj_datos.fecha::date, \'YYYY\') as año')->get();
        $mes = Reloj_dato::selectRaw('distinct to_char(reloj_datos.fecha::date, \'MM\') as mes')->get();

        return view('Reportes.AsistenciaEmpleado.AsistenciaEmpleadoTabla', compact('mes', 'años'));
    }

    //***FIN DE PARA MOSTRAR EN LE BLADE DE ASISTENCIA POR EMPLEADO */

    //***********************PARA GENERAR LA ASISTENCIA POR EMPLEADO */
    public function AsistenciaPersonalEmpleadoPDF(Request $request)
    {

        $empleadito = Empleado::selectRaw('nombre, apellido,departamentos.nombre_departamento')
            ->join('departamentos', 'departamentos.id', '=', 'empleado.id_depto')
            ->where('empleado.dui', $request->dui)
            ->get();

        $jornada = Jornada::selectRaw('jornada_items.dia, jornada_items.hora_inicio,jornada_items.hora_fin')
            ->join('empleado', 'empleado.id', '=', 'jornada.id_emp')
            ->join('periodos', 'periodos.id', '=', 'jornada.id_periodo')
            ->join('jornada_items', 'jornada_items.id_jornada', '=', 'jornada.id')
            ->where([['empleado.dui', $request->dui], ['periodos.estado', 'activo']])
            ->get();

        $periodos = Jornada::selectRaw('periodos.fecha_inicio,periodos.fecha_fin ')
            ->join('empleado', 'empleado.id', '=', 'jornada.id_emp')
            ->join('periodos', 'periodos.id', '=', 'jornada.id_periodo')
            ->where([['empleado.dui', $request->dui], ['periodos.estado', 'activo']])
            ->get();


        $query = "select * from reloj_datos where id_persona='" . $request->dui . "' and  to_char(fecha::date,'YYYY')::int=" . $request->asistencia_anio . "
        and to_char(fecha::date,'MM')::int=" . $request->asistencia_mes . " order by fecha";

        $query = trim($query);
        $reloj = DB::select($query);



        $pdf = PDF::loadView('Reportes.RelojAsistencia.AsistenciaMensual', compact('empleadito', 'request', 'reloj', 'jornada', 'periodos'));
        foreach ($empleadito as $em) {
            $nombre = $em->nombre . ' ' . $em->apellido;
        }
        return $pdf->setPaper('A4', 'Landscape')->download('Asistencia Personal ' . $nombre . '.pdf');
    }
    //******************FIN DE GENERAR LA ASISTENCIA POR EMPLEADO** */

    //***PARA MOSTRAR EN LA TABLA DE ASISTENCIA MENSUAL EMPLEADO "EMPLEADITO LOGUEADO"*/
    public function mostrarTablaAsistencia($mes, $anio)
    {

     

            $query="select r.fecha,r.dia_semana,r.entrada,r.salida,
            case when (r.entrada='-' or r.salida='-')
            then(
                CASE WHEN((select count(fecha_uso) from permisos inner join empleado on empleado.id = permisos.empleado 
                        where empleado.id=".auth()->user()->empleado." and fecha_uso=r.fecha::date and permisos.estado='Aceptado')>0)
                THEN('Solvente')
                ELSE('Déficit') end
                )else(
			
				CASE WHEN( (ji.hora_inicio::time+'00:05:59'< r.entrada::time) OR (r.salida <= ji.hora_fin))
					THEN('Déficit')
					else('Solvente') end
					
					) end permisos
				
				
				
            from reloj_datos r
            inner join empleado on empleado.dui=r.id_persona
            inner join permisos on empleado.id = permisos.empleado
			inner join jornada ON empleado.id = jornada.id_emp
        	inner join periodos on periodos.id = jornada.id_periodo
        	inner join jornada_items ji ON ji.id_jornada = jornada.id
            where empleado.id=".auth()->user()->empleado." and to_char(r.fecha::date,'MM')::int=".$mes."
			and to_char(r.fecha::date,'YYYY')::int=".$anio."
			and jornada.procedimiento='aceptado' and periodos.estado='activo'
            
            group by r.fecha,r.dia_semana,r.entrada,r.salida,ji.hora_fin,ji.hora_inicio,r.gracia";


            $query= trim($query);

            $datos = DB::select($query);
            
          

        //->whereRaw('to_char(permisos.fecha_uso,\'YYYY\')::int=' . $anio);

        //echo dd($datos);

        foreach ($datos as $item) {
            # code...
            if($item->permisos=='Déficit') $row0= '<span class="badge badge-danger font-13">'.Carbon::parse($item->fecha)->format('d/m/Y').'</span>' ;
             else
             $row0= '<span class="badge badge-secondary font-13">'.Carbon::parse($item->fecha)->format('d/m/Y').'</span>';

             if($item->permisos=='Déficit') $row3= '<span class="badge badge-danger font-13">'.$item->permisos.'</span>' ;
             else
             $row3= '<span class="badge badge-secondary font-13">'.$item->permisos.'</span>';

            $data[] = array(
                "row0" =>  $row0,
                "row1" => $item->dia_semana,
                "row2" => $item->entrada,
                "row3" => $item->salida,
                "row4" => $row3,
            );
        }

        return isset($data) ? response()->json($data, 200, []) : response()->json([], 200, []);
    }

    //***************/FIN DE MOSTRAR EN LA TABLA DE ASISTENCIA MENSUAL EMPLEADO */

    public function AsistenciaPersonalPDF(Request $request)
    {


        $empleadito = Empleado::selectRaw('nombre, apellido,departamentos.nombre_departamento')
            ->join('departamentos', 'departamentos.id', '=', 'empleado.id_depto')
            ->where('empleado.dui', $request->dui)
            ->get();

        $jornada = Jornada::selectRaw('jornada_items.dia, jornada_items.hora_inicio,jornada_items.hora_fin')
            ->join('empleado', 'empleado.id', '=', 'jornada.id_emp')
            ->join('periodos', 'periodos.id', '=', 'jornada.id_periodo')
            ->join('jornada_items', 'jornada_items.id_jornada', '=', 'jornada.id')
            ->where([['empleado.dui', $request->dui], ['periodos.estado', 'activo']])
            ->get();

        $periodos = Jornada::selectRaw('periodos.fecha_inicio,periodos.fecha_fin ')
            ->join('empleado', 'empleado.id', '=', 'jornada.id_emp')
            ->join('periodos', 'periodos.id', '=', 'jornada.id_periodo')
            ->where([['empleado.dui', $request->dui], ['periodos.estado', 'activo']])
            ->get();


        $query = "select * from reloj_datos where id_persona='" . $request->dui . "' and  to_char(fecha::date,'YYYY')::int=" . $request->asistencia_anio . "
        and to_char(fecha::date,'MM')::int=" . $request->asistencia_mes . " order by fecha";

        $query = trim($query);
        $reloj = DB::select($query);



        $pdf = PDF::loadView('Reportes.RelojAsistencia.AsistenciaMensual', compact('empleadito', 'request', 'reloj', 'jornada', 'periodos'));
        foreach ($empleadito as $em) {
            $nombre = $em->nombre . ' ' . $em->apellido;
        }
        return $pdf->setPaper('A4', 'Landscape')->download('Asistencia ' . $nombre . '.pdf');
    }

    //FIN DE GENERAR LA ASISTENCIA PARA LOS EMPLEADOS MENSUAL

    ///***********************FIN DE ASISTENCIA*************** */


    //PARA MOSTRAR LA VISTA A LOS EMPLEADOS
    public function indexEmpleadoLicencias()
    {
        $años = Permiso::selectRaw('distinct to_char(permisos.fecha_uso, \'YYYY\') as año')->get();
        return view('Reportes.EmpleadoLicencias.MostrarLicencias', compact('años'));
    }
    //FIN DE MOSTRAR LA VISTA A LOS EMPLEADOS
    //PARA MOSTRAR LA VISTA DE LICENCIAS POR MES PARA LOS JEFES
    public function indexBladeJefes()
    {

        $años = Permiso::selectRaw('distinct to_char(permisos.fecha_uso, \'YYYY\') as año')->get();
        return view('Reportes.Jefes.MostrarMensuales', compact('años'));
    }
    //FIN DE MOSTRAR LA VISTA DE DE LICENCIAS POR MES PARA LOS JEFES
    //PARA MOSTRAR LA VISTA DE LICENCIAS POR ACUERDO
    public function indexBladeAcuerdos()
    {

        $deptos = Departamento::all();
        // echo dd($deptos);
        return view('Reportes.LicenciasAcuerdo.MostrarLicenciasAcuerdos', compact('deptos'));
    }
    //FIN DE MOSTRAR LAS LICENCIAS POR ACUERDO

    //PARA MOSTRAR LA VISTA EN LICENCIAS
    public function indexBladeLicencias()
    {
        $deptos = Departamento::all();
        $años = Permiso::selectRaw('distinct to_char(permisos.fecha_uso, \'YYYY\') as año')->get();
        // echo dd($deptos);
        return view('Reportes.LicenciasReportes.MostrarLicencias', compact('deptos', 'años'));
    }
    //FIN DE MOSTRAR LA VISTA EN LICENCIAS

    //TODAS LAS FUNCIONES PARA EL REPORTE CONSTANCIA DE OLVIDO
    public function indexConsResporte()
    {
        $deptos = Departamento::all();
        // echo dd($deptos);
        return view('Reportes.Constancias.MostrarConstancia', compact('deptos'));
    }
    //FIN DE FUNCIONES CONTANCIA DE OLVIDO


    public function index()
    {
        $data =  Permiso::selectRaw('md5(permisos.id::text) as identificador,permisos.empleado, CONCAT(empleado.nombre,\' \',empleado.apellido) e_nombre, to_char(permisos.fecha_uso, \'DD/MM/YYYY\') inicio,
        to_char(permisos.fecha_presentacion,\'DD/MM/YYYY\') fin, permisos.justificacion, permisos.tipo_permiso, permisos.hora_inicio,permisos.estado, permisos.fecha_presentacion, permisos.olvido,permisos.fecha_uso')
            ->join('empleado', 'empleado.id', '=', 'permisos.empleado')
            ->where('empleado.id', auth()->user()->empleado)
            ->whereRaw('tipo_permiso=\'Const. olvido\'')
            ->get();
        // echo dd($data);
        return view('Licencias.ConstanciaReporte', compact('data'));
    }

    public function downloadPDF()
    {

        $data =  Permiso::selectRaw('md5(permisos.id::text) as identificador,permisos.empleado, CONCAT(empleado.nombre,\' \',empleado.apellido) e_nombre, to_char(permisos.fecha_uso, \'DD/MM/YYYY\') inicio,
        to_char(permisos.fecha_presentacion,\'DD/MM/YYYY\') fin, permisos.justificacion, permisos.tipo_permiso, permisos.hora_inicio,permisos.estado, permisos.fecha_presentacion, permisos.olvido,permisos.fecha_uso')
            ->join('empleado', 'empleado.id', '=', 'permisos.empleado')
            ->where('empleado.id', auth()->user()->empleado)
            ->whereRaw('tipo_permiso=\'Const. olvido\'')
            ->get();

        $pdf = PDF::loadView('Licencias.ConstanciaReporte', compact('data'));
        return $pdf->download('Constancia.pdf');
    }
    //PARA MOSTRAR EN LA TABLA DE CONSTANCIA DE OLVIDO DE MARCAJE
    public function mostrarTablaConst($fecha1, $fecha2, $dep)
    {
        $permisoss = Empleado::selectRaw(' permisos.id, nombre, apellido, permisos.tipo_permiso,permisos.fecha_presentacion,permisos.fecha_uso,
        permisos.hora_inicio,permisos.fecha_uso, permisos.justificacion, permisos.updated_at, permisos.olvido, departamentos.nombre_departamento')
            ->join('departamentos', 'departamentos.id', '=', 'empleado.id_depto')
            ->join('permisos', 'permisos.empleado', '=', 'empleado.id');

        if ($dep == 'all') {
            $permisos = $permisoss->where(
                [
                    ['permisos.estado', '=', 'Aceptado'],
                    ['permisos.tipo_permiso', '=', 'Const. olvido'],
                    ['permisos.fecha_uso', '>=', $fecha1],
                    ['permisos.fecha_uso', '<=', $fecha2]
                ]
            )->get();
        } else {
            $permisos = $permisoss->where(
                [
                    ['permisos.estado', '=', 'Aceptado'],
                    ['permisos.tipo_permiso', '=', 'Const. olvido'],
                    ['permisos.fecha_uso', '>=', $fecha1],
                    ['permisos.fecha_uso', '<=', $fecha2],
                    ['departamentos.id', '=', $dep]
                ]
            )->get();
        }
        // echo dd($permisos);

        foreach ($permisos as $item) {
            # CODIGO PARA MOSTRAR EN LA TABLA
            $data[] = array(
                "row0" => $item->nombre . ' ' . $item->apellido,
                "row1" => '<span class="badge badge-primary font-13">' . $item->tipo_permiso . '</span>',
                "row2" => $item->olvido,
                "row3" => date('H:i', strtotime($item->hora_inicio)),
                "row4" => Carbon::parse($item->fecha_uso)->format('d/m/Y'),
                "row5" => Carbon::parse($item->fecha_presentacion)->format('d/m/Y'),
                "row6" => Carbon::parse($item->updated_at)->format('d/m/Y'),
                "row7" =>  $item->justificacion,

            );
        }

        return isset($data) ? response()->json($data, 200, []) : response()->json([], 200, []);
    }
    //FIN DE MOSTRAR EN LA TABLA CONSTANCIA DE OLVIDO DE MARCAJE

    //PARA DIBUJAR LAS LA TABLA PARA LAS LICENCIAS
    public function mostrarTablaLicencias($mes, $anio, $dep)
    {

        $permisoss = Empleado::selectRaw(' permisos.id, nombre, apellido, permisos.tipo_permiso,permisos.fecha_presentacion,permisos.fecha_uso,
        permisos.hora_inicio,permisos.hora_final,permisos.fecha_uso, permisos.justificacion, permisos.updated_at, permisos.olvido, departamentos.nombre_departamento')
            ->join('departamentos', 'departamentos.id', '=', 'empleado.id_depto')
            ->join('permisos', 'permisos.empleado', '=', 'empleado.id');

        if ($dep == 'all') {
            $permisos = $permisoss->Where(
                function ($query) {
                    $query->Where('tipo_permiso', 'like', 'LC/GS')
                        ->orWhere('tipo_permiso', 'like', 'LS/GS')
                        ->orWhere('tipo_permiso', 'like', 'T COMP')
                        ->orWhere('tipo_permiso', 'like', 'INCAP')
                        ->orWhere('tipo_permiso', 'like', 'L OFICIAL')
                        ->orWhere('tipo_permiso', 'like', 'CITA MEDICA');
                }
            )->where(
                [
                    ['permisos.estado', '=', 'Aceptado']
                ]
            )->whereRaw('to_char(permisos.fecha_uso,\'YYYY\')::int=' . $anio)
                ->whereRaw('to_char(permisos.fecha_uso,\'MM\')::int=' . $mes)->get();
            //->whereRaw('to_char(permisos.fecha_uso,\'YYYY\')::int=' . $anio);
        } else {
            $permisos = $permisoss->Where(
                function ($query) {
                    $query->Where('tipo_permiso', 'like', 'LC/GS')
                        ->orWhere('tipo_permiso', 'like', 'LS/GS')
                        ->orWhere('tipo_permiso', 'like', 'T COMP')
                        ->orWhere('tipo_permiso', 'like', 'INCAP')
                        ->orWhere('tipo_permiso', 'like', 'L OFICIAL')
                        ->orWhere('tipo_permiso', 'like', 'CITA MEDICA');
                }
            )->where(
                [
                    ['permisos.estado', '=', 'Aceptado'],
                    ['departamentos.id', '=', $dep]
                ]
            )->whereRaw('to_char(permisos.fecha_uso,\'YYYY\')::int=' . $anio)
                ->whereRaw('to_char(permisos.fecha_uso,\'MM\')::int=' . $mes)->get();
        }
        // echo dd($permisos);

        foreach ($permisos as $item) {
            # code...

            $col3 = $col4 = $col5 = null;
            if ($item->olvido == 'Entrada' || $item->olvido == 'Salida') {
                $col3 = date('H:i', strtotime($item->olvido == 'Entrada' ? $item->hora_inicio : $item->hora_final));
                $col4 = date('H:i', strtotime($item->olvido == 'Salida' ? $item->hora_inicio : $item->hora_final));
                $col5 = date('H:i', strtotime($item->hora_final));
            } else {
                $col3 = date('H:i', strtotime($item->hora_inicio));
                $col4 = date('H:i', strtotime($item->hora_final));
                $col5 = '' . \Carbon\Carbon::parse($item->fecha_uso . 'T' . $item->hora_inicio)->diffAsCarbonInterval(\Carbon\Carbon::parse($item->fecha_uso . 'T' . $item->hora_final));
            }

            $data[] = array(
                "row0" => $item->nombre . ' ' . $item->apellido,
                "row1" => '<span class="badge badge-primary font-13">' . $item->tipo_permiso . '</span>',
                "row2" => Carbon::parse($item->fecha_presentacion)->format('d/m/Y'),
                "row3" => Carbon::parse($item->fecha_uso)->format('d/m/Y'),
                "row4" => Carbon::parse($item->updated_at)->format('d/m/Y'),
                "row5" => $col3,
                "row6" => $col4,
                "row7" => $col5,
                "row8" => $item->justificacion,

            );
        }

        return isset($data) ? response()->json($data, 200, []) : response()->json([], 200, []);
    }
    //FIN DE DIBUJAR LAS TABLA PARA LAS LICENCIAS

    //PARA MOSTRAR EN LA TABLA DE LA VISTA DE LICENCIAS POR ACUERDO
    public function mostrarTablaLicenciasAcuer($fecha1, $fecha2, $dep)
    {
        $permisoss = Empleado::selectRaw(' permisos.id, nombre, apellido, permisos.tipo_permiso,permisos.fecha_presentacion,permisos.fecha_uso,
        permisos.hora_inicio,permisos.hora_final,permisos.fecha_uso, permisos.justificacion, permisos.updated_at, permisos.olvido, departamentos.nombre_departamento')
            ->join('departamentos', 'departamentos.id', '=', 'empleado.id_depto')
            ->join('permisos', 'permisos.empleado', '=', 'empleado.id');

        if ($dep == 'all') {
            $permisos = $permisoss->Where(
                function ($query) {
                    $query->Where('tipo_permiso', 'like', 'INCAPACIDAD/A')
                        ->orWhere('tipo_permiso', 'like', 'ESTUDIO')
                        ->orWhere('tipo_permiso', 'like', 'FUMIGACIÓN')
                        ->orWhere('tipo_permiso', 'like', 'L.OFICIAL/A')
                        ->orWhere('tipo_permiso', 'like', 'OTROS');
                }
            )->where(
                [
                    ['permisos.estado', '=', 'Aceptado'],
                    ['permisos.fecha_uso', '>=', $fecha1],
                    ['permisos.fecha_uso', '<=', $fecha2]
                ]
            )->get();
        } else {
            $permisos = $permisoss->Where(
                function ($query) {
                    $query->Where('tipo_permiso', 'like', 'INCAPACIDAD/A')
                        ->orWhere('tipo_permiso', 'like', 'ESTUDIO')
                        ->orWhere('tipo_permiso', 'like', 'FUMIGACIÓN')
                        ->orWhere('tipo_permiso', 'like', 'L.OFICIAL/A')
                        ->orWhere('tipo_permiso', 'like', 'OTROS');
                }
            )->where(
                [
                    ['permisos.estado', '=', 'Aceptado'],
                    ['permisos.fecha_uso', '>=', $fecha1],
                    ['permisos.fecha_uso', '<=', $fecha2],
                    ['departamentos.id', '=', $dep]
                ]
            )->get();
        }
        // echo dd($permisos);

        foreach ($permisos as $item) {
            # code...

            $data[] = array(
                "row0" => $item->nombre . ' ' . $item->apellido,
                "row1" => '<span class="badge badge-primary font-13">' . $item->tipo_permiso . '</span>',
                "row2" => Carbon::parse($item->fecha_uso)->format('d/m/Y'),
                "row3" => Carbon::parse($item->fecha_presentacion)->format('d/m/Y'),
                "row4" => $item->justificacion,

            );
        }

        return isset($data) ? response()->json($data, 200, []) : response()->json([], 200, []);
    }
    //FIN MOSTRAR EN LA TABLA DE LA VISTA DE LICENCIAS POR ACUERDO

    //PARA MOSTRAR EN LA TABLA DE LA VISTA DE REVISION MENSUALE A JEFES
    public function mostrarTablaJefes($mes, $anio)
    {

        $permisos = Permiso::selectRaw('tipo_permiso, fecha_uso,fecha_presentacion,hora_inicio,hora_final,justificacion,permisos.estado,
                  observaciones,olvido,empleado.nombre,empleado.apellido')
            ->join('empleado', 'empleado.id', '=', 'permisos.empleado')
            ->where(
                function ($query) {
                    $query->where([
                        ['permisos.estado', 'like', 'Aceptado'],
                        ['permisos.jefatura', '=', auth()->user()->empleado]
                    ]);
                }
            );


        if ($anio != 'todos') {
            $permisos = $permisos->whereRaw('to_char(permisos.fecha_uso,\'YYYY\')::int=' . $anio);
        }

        if ($mes != 'todos') {
            $permisos = $permisos->whereRaw('to_char(permisos.fecha_uso,\'MM\')::int=' . $mes);
        }

        $permisos = $permisos->get();

        foreach ($permisos as $item) {
            # code...
            $col3 = null;
            if ($item->olvido == 'Entrada' || $item->olvido == 'Salida') {
                $col3 = $item->olvido;
            } else {
                $col3 = '' . \Carbon\Carbon::parse($item->fecha_uso . 'T' . $item->hora_inicio)->diffAsCarbonInterval(\Carbon\Carbon::parse($item->fecha_uso . 'T' . $item->hora_final));
            }



            $data[] = array(
                "col0" => $item->nombre . ' ' . $item->apellido,
                "col1" => '<span class="badge badge-primary">' . $item->tipo_permiso . '</span>',
                "col2" => \Carbon\Carbon::parse($item->fecha_uso)->format('d/M/Y'),
                "col3" => $col3,
            );
        }
        return isset($data) ? response()->json($data, 200, []) : response()->json([], 200, []);
    }
    //FIN DE MOSTRAR EN LA TABLA DE LA VISTA DE REVISION MENSUALE A JEFES

    //PARA MOSTRAR EN LA TABLA DE LA VISTA DE REVISION MENSUALE A JEFES

    //FIN DE MOSTRAR EN LA TABLA DE LA VISTA DE REVISION MENSUALE A JEFES
    public function mostrarTablaEmpleado($mes, $anio)
    {
        //echo dd($mes);
        $permisos = Permiso::selectRaw('tipo_permiso, fecha_uso,fecha_presentacion,hora_inicio,hora_final,justificacion,permisos.estado,
                observaciones,olvido,empleado.nombre,empleado.apellido')
            ->join('empleado', 'empleado.id', '=', 'permisos.empleado')
            ->where(
                function ($query) {
                    $query->where([
                        ['permisos.estado', 'like', 'Aceptado'],
                        ['permisos.empleado', '=', auth()->user()->empleado]
                    ]);
                }
            );

        $permisos = $permisos->whereRaw('to_char(permisos.fecha_uso,\'YYYY\')::int=' . $anio);

        $permisos = $permisos->whereRaw('to_char(permisos.fecha_uso,\'MM\')::int=' . $mes);


        $permisos = $permisos->get();

        foreach ($permisos as $item) {
            # code...
            $col3 = $col4 = $col5 = null;
            if ($item->olvido == 'Entrada' || $item->olvido == 'Salida') {
                $col3 = date('H:i', strtotime($item->olvido == 'Entrada' ? $item->hora_inicio : $item->hora_final));
                $col4 = date('H:i', strtotime($item->olvido == 'Salida' ? $item->hora_inicio : $item->hora_final));
                $col5 = date('H:i', strtotime($item->hora_final));
            } else {
                $col3 = date('H:i', strtotime($item->hora_inicio));
                $col4 = date('H:i', strtotime($item->hora_final));
                $col5 = '' . \Carbon\Carbon::parse($item->fecha_uso . 'T' . $item->hora_inicio)->diffAsCarbonInterval(\Carbon\Carbon::parse($item->fecha_uso . 'T' . $item->hora_final));
            }
            $data[] = array(
                "col0" => '<span class="badge badge-primary">' . $item->tipo_permiso . '</span>',
                "col1" => \Carbon\Carbon::parse($item->fecha_presentacion)->format('d/M/Y'),
                "col2" => \Carbon\Carbon::parse($item->fecha_uso)->format('d/M/Y'),
                "col3" => $col3,
                "col4" => $col4,
                "col5" => $col5,
                "col6" => $item->justificacion,

            );
        }
        return isset($data) ? response()->json($data, 200, []) : response()->json([], 200, []);
    }

    //PARA MOSTRAR EN LA TABLA DE LA VISTA DE HISTORIAL DE LICENCIAS

    //FIN DE MOSTRAR EN LA TABLA DE LA VISTA DE HISTORIAL DE LICENCIAS

    //PARA GENERAR EL REPORTE DE CONSTANCIAS EN PDF
    public function ConstDeptosPDF(Request $request)
    {

        $permisoss = Empleado::selectRaw(' permisos.id, nombre, apellido, id_depto, permisos.tipo_permiso,permisos.fecha_presentacion, permisos.fecha_uso,
        permisos.hora_inicio,permisos.hora_final, permisos.justificacion, permisos.updated_at, permisos.olvido, departamentos.nombre_departamento')
            ->join('departamentos', 'departamentos.id', '=', 'empleado.id_depto')
            ->join('permisos', 'permisos.empleado', '=', 'empleado.id');

        if ($request->deptoR_R == 'all') {
            $permisos = $permisoss->where(
                [
                    ['permisos.estado', '=', 'Aceptado'],
                    ['permisos.tipo_permiso', '=', 'Const. olvido'],
                    ['permisos.fecha_uso', '>=', $request->inicioR],
                    ['permisos.fecha_uso', '<=', $request->finR]
                ]
            )->get();
            //para mostrar solo los departamentos que tienen permisos
            $departamentos = Empleado::selectRaw(' DISTINCT id_depto,departamentos.nombre_departamento,departamentos.id')
                ->join('departamentos', 'departamentos.id', '=', 'empleado.id_depto')
                ->join('permisos', 'permisos.empleado', '=', 'empleado.id')
                ->where(
                    [
                        ['permisos.estado', '=', 'Aceptado'],
                        ['permisos.tipo_permiso', '=', 'Const. olvido'],
                        ['permisos.fecha_uso', '>=', $request->inicioR],
                        ['permisos.fecha_uso', '<=', $request->finR]
                    ]
                )->get();
            //para imprimir el reporte

        } else {
            $permisos = $permisoss->where(
                [
                    ['permisos.estado', '=', 'Aceptado'],
                    ['permisos.tipo_permiso', '=', 'Const. olvido'],
                    ['permisos.fecha_uso', '>=', $request->inicioR],
                    ['permisos.fecha_uso', '<=', $request->finR],
                    ['departamentos.id', '=', $request->deptoR_R]
                ]
            )->get();

            $departamentos = Departamento::where('id', '=', $request->deptoR_R)->get();
        }

        // echo dd($permisos);

        $pdf = PDF::loadView('Reportes.Constancias.ReporteConstancias', compact('permisos', 'departamentos', 'request'));
        return $pdf->setPaper('A4', 'Landscape')->download('Constancias.pdf');
    }
    //FIN DE GENERAR EL REPORTE DE CONTANCIAS EN PDF

    //PARA GENERAR EL REPORTE DE LICENCIAS EN PDF
    public function licenciasDeptosPDF(Request $request)
    {

        $permisoss = Empleado::selectRaw(' permisos.id, nombre, apellido, id_depto, permisos.tipo_permiso,permisos.fecha_presentacion, permisos.fecha_uso,
        permisos.hora_inicio,permisos.hora_final, permisos.justificacion, permisos.updated_at, permisos.olvido, departamentos.nombre_departamento')
            ->join('departamentos', 'departamentos.id', '=', 'empleado.id_depto')
            ->join('permisos', 'permisos.empleado', '=', 'empleado.id');

        if ($request->deptoR_R == 'all') {
            $permisos = $permisoss->Where(
                function ($query) {
                    $query->Where('tipo_permiso', 'like', 'LC/GS')
                        ->orWhere('tipo_permiso', 'like', 'LS/GS')
                        ->orWhere('tipo_permiso', 'like', 'T COMP')
                        ->orWhere('tipo_permiso', 'like', 'INCAP')
                        ->orWhere('tipo_permiso', 'like', 'L OFICIAL')
                        ->orWhere('tipo_permiso', 'like', 'CITA MEDICA');
                }
            )->where(
                [
                    ['permisos.estado', '=', 'Aceptado']
                ]
            )->whereRaw('to_char(permisos.fecha_uso,\'YYYY\')::int=' . $request->inicioR)
                ->whereRaw('to_char(permisos.fecha_uso,\'MM\')::int=' . $request->finR)->get();
            //para mostrar solo los departamentos que tienen permisos
            $departamentos = Empleado::selectRaw(' DISTINCT id_depto,departamentos.nombre_departamento,departamentos.id')
                ->join('departamentos', 'departamentos.id', '=', 'empleado.id_depto')
                ->join('permisos', 'permisos.empleado', '=', 'empleado.id')
                ->Where(
                    function ($query) {
                        $query->Where('tipo_permiso', 'like', 'LC/GS')
                            ->orWhere('tipo_permiso', 'like', 'LS/GS')
                            ->orWhere('tipo_permiso', 'like', 'T COMP')
                            ->orWhere('tipo_permiso', 'like', 'INCAP')
                            ->orWhere('tipo_permiso', 'like', 'L OFICIAL')
                            ->orWhere('tipo_permiso', 'like', 'CITA MEDICA');
                    }
                )->where(
                    [
                        ['permisos.estado', '=', 'Aceptado']

                    ]
                )->whereRaw('to_char(permisos.fecha_uso,\'YYYY\')::int=' . $request->finR)
                ->whereRaw('to_char(permisos.fecha_uso,\'MM\')::int=' . $request->inicioR)->get();
            //para imprimir el reporte

        } else {
            $permisos = $permisoss->Where(
                function ($query) {
                    $query->Where('tipo_permiso', 'like', 'LC/GS')
                        ->orWhere('tipo_permiso', 'like', 'LS/GS')
                        ->orWhere('tipo_permiso', 'like', 'T COMP')
                        ->orWhere('tipo_permiso', 'like', 'INCAP')
                        ->orWhere('tipo_permiso', 'like', 'L OFICIAL')
                        ->orWhere('tipo_permiso', 'like', 'CITA MEDICA');
                }
            )->where(
                [
                    ['permisos.estado', '=', 'Aceptado'],
                    ['departamentos.id', '=', $request->deptoR_R]
                ]
            )->whereRaw('to_char(permisos.fecha_uso,\'YYYY\')::int=' . $request->finR)
                ->whereRaw('to_char(permisos.fecha_uso,\'MM\')::int=' . $request->inicioR)->get();

            $departamentos = Departamento::where('id', '=', $request->deptoR_R)->get();
        }

        // echo dd($permisos);
        $pdf = PDF::loadView('Reportes.LicenciasReportes.ReporteLicencias', compact('permisos', 'departamentos', 'request'));
        return $pdf->setPaper('A4', 'Landscape')->download('Licencias.pdf');
    }
    //FIN PARA GENERAR EL REPORTE DE LICENCIAS EN PDF

    //PARA GENERAR EL REPORTE DE LICENCIAS POR ACUERDO
    public function licenciasAcuerdoPDF(Request $request)
    {
        $permisoss = Empleado::selectRaw(' permisos.id, nombre, apellido, id_depto, permisos.tipo_permiso,permisos.fecha_presentacion, permisos.fecha_uso,
        permisos.hora_inicio,permisos.hora_final, permisos.justificacion, permisos.updated_at, permisos.olvido, departamentos.nombre_departamento')
            ->join('departamentos', 'departamentos.id', '=', 'empleado.id_depto')
            ->join('permisos', 'permisos.empleado', '=', 'empleado.id');

        if ($request->deptoR_R == 'all') {
            $permisos = $permisoss->Where(
                function ($query) {
                    $query->Where('tipo_permiso', 'like', 'INCAPACIDAD/A')
                        ->orWhere('tipo_permiso', 'like', 'ESTUDIO')
                        ->orWhere('tipo_permiso', 'like', 'FUMIGACIÓN')
                        ->orWhere('tipo_permiso', 'like', 'L.OFICIAL/A')
                        ->orWhere('tipo_permiso', 'like', 'OTROS');
                }
            )->where(
                [
                    ['permisos.estado', '=', 'Aceptado'],
                    ['permisos.fecha_uso', '>=', $request->inicioR],
                    ['permisos.fecha_uso', '<=', $request->finR]
                ]
            )->get();
            //para mostrar solo los departamentos que tienen permisos
            $departamentos = Empleado::selectRaw(' DISTINCT id_depto,departamentos.nombre_departamento,departamentos.id')
                ->join('departamentos', 'departamentos.id', '=', 'empleado.id_depto')
                ->join('permisos', 'permisos.empleado', '=', 'empleado.id')
                ->Where(
                    function ($query) {
                        $query->Where('tipo_permiso', 'like', 'INCAPACIDAD/A')
                            ->orWhere('tipo_permiso', 'like', 'ESTUDIO')
                            ->orWhere('tipo_permiso', 'like', 'FUMIGACIÓN')
                            ->orWhere('tipo_permiso', 'like', 'L.OFICIAL/A')
                            ->orWhere('tipo_permiso', 'like', 'OTROS')
                            ->orWhere('tipo_permiso', 'like', 'CITA MEDICA');
                    }
                )->where(
                    [
                        ['permisos.estado', '=', 'Aceptado'],
                        ['permisos.fecha_uso', '>=', $request->inicioR],
                        ['permisos.fecha_uso', '<=', $request->finR]
                    ]
                )->get();
            //para imprimir el reporte

        } else {
            $permisos = $permisoss->Where(
                function ($query) {
                    $query->Where('tipo_permiso', 'like', 'INCAPACIDAD/A')
                        ->orWhere('tipo_permiso', 'like', 'ESTUDIO')
                        ->orWhere('tipo_permiso', 'like', 'FUMIGACIÓN')
                        ->orWhere('tipo_permiso', 'like', 'L.OFICIAL/A')
                        ->orWhere('tipo_permiso', 'like', 'OTROS');
                }
            )->where(
                [
                    ['permisos.estado', '=', 'Aceptado'],
                    ['permisos.fecha_uso', '>=', $request->inicioR],
                    ['permisos.fecha_uso', '<=', $request->finR],
                    ['departamentos.id', '=', $request->deptoR_R]
                ]
            )->get();

            $departamentos = Departamento::where('id', '=', $request->deptoR_R)->get();
        }

        // echo dd($permisos);
        $pdf = PDF::loadView('Reportes.LicenciasAcuerdo.ReporteLicenciasAcuerdos', compact('permisos', 'departamentos', 'request'));
        return $pdf->setPaper('A4', 'Landscape')->download('LicenciasPorAcuerdos.pdf');
    }
    //FIN DE GENERAR REPORTE DE LICENCIAS POR ACUERDO

    //PARA GENERAR EL PDF DE REPORTE MENSUAL JEFE
    public function mensualJefePDF(Request $request)
    {
        $permisos = Permiso::selectRaw('tipo_permiso, fecha_uso,fecha_presentacion,hora_inicio,hora_final,justificacion,permisos.estado,
                observaciones,olvido,empleado.nombre,empleado.apellido')
            ->join('empleado', 'empleado.id', '=', 'permisos.empleado')
            ->where(
                function ($query) {
                    $query->where([
                        ['permisos.estado', 'like', 'Aceptado'],
                        ['permisos.jefatura', '=', auth()->user()->empleado]
                    ]);
                }
            );

        $departamentos = Empleado::selectRaw(' DISTINCT id_depto,departamentos.nombre_departamento,departamentos.id')
            ->join('departamentos', 'departamentos.id', '=', 'empleado.id_depto')
            ->join('permisos', 'permisos.empleado', '=', 'empleado.id')
            ->Where(
                function ($query) {
                    $query->Where([['permisos.estado', 'like', 'Aceptado'], ['permisos.jefatura', '=', auth()->user()->empleado]]);
                }
            )->get();


        if ($request->anio != 'todos') {
            $permisos = $permisos->whereRaw('to_char(permisos.fecha_uso,\'YYYY\')::int=' . $request->anio);
        }

        if ($request->mes != 'todos') {
            $permisos = $permisos->whereRaw('to_char(permisos.fecha_uso,\'MM\')::int=' . $request->mes);
        }

        $permisos = $permisos->get();




        // echo dd($permisos);
        $pdf = PDF::loadView('Reportes.Jefes.ReporteMensuales', compact('permisos', 'departamentos', 'request'));
        return $pdf->download('Reporte de licencias ' . $request->mes . '.pdf');
    }
    //FIN GENERAR EL REPORTE MENSUAL JEFE   

    //PARA GENERAR EL PDF DEL EMPLEADO
    public function mensualEmpleadoPDF(Request $request)
    {

        $permisos = Permiso::selectRaw('tipo_permiso, fecha_uso,fecha_presentacion,hora_inicio,hora_final,justificacion,permisos.estado,
                observaciones,olvido,empleado.nombre,empleado.apellido')
            ->join('empleado', 'empleado.id', '=', 'permisos.empleado')
            ->where(
                function ($query) {
                    $query->where([
                        ['permisos.estado', 'like', 'Aceptado'],
                        ['permisos.empleado', '=', auth()->user()->empleado]
                    ]);
                }
            );

        $permisos = $permisos->whereRaw('to_char(permisos.fecha_uso,\'YYYY\')::int=' . $request->anio);

        $permisos = $permisos->whereRaw('to_char(permisos.fecha_uso,\'MM\')::int=' . $request->mes);


        $permisos = $permisos->get();
        $empleado = Empleado::select('*')->where('id', '=', auth()->user()->empleado)->get();


        // echo dd($permisos);
        $pdf = PDF::loadView('Reportes.EmpleadoLicencias.ReporteLicenciasEmpleado', compact('permisos', 'empleado', 'request'));
        return $pdf->download('Reporte de licencias ' . $request->mes . '.pdf');
    }

    //FIN DE GENERAR EL PDF PARA EL EMPLEADO
}

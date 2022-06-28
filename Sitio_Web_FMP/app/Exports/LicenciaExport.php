<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class LicenciaExport implements FromView
{
    public $tipo_contrato;
    public $anio;
    public $mes;
    public $departamento;
    public $comentario;

    public function __construct(/*$tipo_contrato,*/$anio, $mes, $departamento, $comentario)
    {
        $this->anio = $anio;
        $this->mes = $mes;

        //$this->tipo_contrato  = $tipo_contrato;
        $this->departamento = $departamento;
        $this->comentario = $comentario;
    }

    /**
     * @return \Illuminate\Support\Collection
     */

    public function view(): View
    {
        $query = "select TRIM(e.apellido)||','||TRIM(e.nombre) as nombre,

        (select (sum(suma.hrs_input::time)- sum(suma.hrs_permisos::time)) hrs_inpunt
         from(
            select to_char((r.entrada::time-ji.hora_inicio::time),'HH24:MI') hrs_input,
           
                   (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                            inner join empleado ON empleado.id = permisos.empleado
                            where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado')>0)
                   THEN
                   (select to_char(hora_final-hora_inicio,'HH24:MI') from permisos where fecha_uso=r.fecha::date ) else ('00:00') end) hrs_permisos,
           e.nombre as em, r.salida,r.entrada,r.fecha
           
                       from reloj_datos r
                       inner join jornada ON e.id = jornada.id_emp
                       inner join jornada_items ji ON ji.id_jornada = jornada.id
                       where e.dui=r.id_persona and ji.hora_inicio::time+'00:05' < r.entrada::time
                       and ji.dia=r.dia_semana 
                       and  to_char(r.fecha::date,'YYYY')::int=" . $this->anio . "
                       and to_char(r.fecha::date,'MM')::int=" . $this->mes . " and r.entrada !='-' and r.salida !='-'
                       GROUP BY  e.nombre,r.entrada,r.fecha,r.salida,ji.hora_inicio,ji.hora_fin) suma),

                       (select (sum(pivot.inas_entrada::time)+ sum(pivot.inas_salida::time)+sum(pivot.inas_entrada_salida::time)+sum(pivot.inas_salida_antes::time)) hrs_inasis
                       from(select
                       (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                   inner join empleado ON empleado.id = permisos.empleado
                   where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado'and permisos.tipo_permiso='Const. olvido' and permisos.olvido='Entrada')>0)
                   THEN
                   ((CASE WHEN (r.entrada='-' AND r.salida !='-') THEN 
                   ('00:00') else ('00:00')
                    END)) 
                    else ((CASE WHEN (r.entrada='-' AND r.salida !='-') THEN 
                   (to_char((ji.hora_fin::time-ji.hora_inicio::time),'HH24:MI')) else ('00:00')
                    END)) END) inas_entrada,
                
           (CASE WHEN((select count(fecha_uso) permiso_fecha from permisos
                   inner join empleado ON empleado.id = permisos.empleado
                   where fecha_uso=r.fecha::date and e.id=permisos.empleado and permisos.estado='Aceptado'and permisos.tipo_permiso='Const. olvido' and permisos.olvido='Salida')>0)
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

                       e.nombre as em,r.entrada, r.salida,r.fecha
                       from reloj_datos r 
                       inner join jornada ON e.id = jornada.id_emp	 
                       inner join jornada_items ji ON ji.id_jornada = jornada.id
                            
                       
                       where e.dui=r.id_persona
                       and ji.dia=r.dia_semana 
                       and  to_char(r.fecha::date,'YYYY')::int=" . $this->anio . "
                       and to_char(r.fecha::date,'MM')::int=" . $this->mes . "
                       GROUP BY  e.nombre,e.id,r.entrada,r.fecha,ji.hora_inicio, r.salida,ji.hora_fin) pivot),
        
        (select to_char(sum(hora_final-hora_inicio),'HH24:MI') hrs_lc_gs
        from permisos  where empleado = e.id and estado like '%Aceptado%'
        and tipo_permiso like '%LC/GS%'
        and to_char(fecha_uso,'YYYY')::int=" . $this->anio . "
        and to_char(fecha_uso,'MM')::int=" . $this->mes . "),
        
        (select to_char(sum(hora_final-hora_inicio),'HH24:MI') hrs_ls_gs
        from permisos where empleado = e.id and estado like '%Aceptado%' and tipo_permiso like '%LS/GS%'
        and to_char(fecha_uso,'YYYY')::int=" . $this->anio . "
        and to_char(fecha_uso,'MM')::int=" . $this->mes . "),
        
        (select to_char(sum(hora_final-hora_inicio),'HH24:MI') hrs_l_ofic from permisos
        where empleado = e.id and estado like '%Aceptado%' and
        (tipo_permiso like '%L.OFICIAL/A%' or tipo_permiso like '%L OFICIAL%')
        and to_char(fecha_uso,'YYYY')::int=" . $this->anio . "
        and to_char(fecha_uso,'MM')::int=" . $this->mes . "),
        
        (select to_char(sum(hora_final-hora_inicio),'HH24:MI') hrs_t_comp
        from permisos where empleado = e.id and estado like '%Aceptado%' and tipo_permiso like '%T COMP%'
        and to_char(fecha_uso,'YYYY')::int=" . $this->anio . "
        and to_char(fecha_uso,'MM')::int=" . $this->mes . "),
        
        (select to_char(sum(hora_final-hora_inicio),'HH24:MI') hrs_incap
        from permisos where empleado = e.id and estado like '%Aceptado%' and
        (tipo_permiso like '%INCAP%' or tipo_permiso like '%INCAPACIDAD/A%')
        and to_char(fecha_uso,'YYYY')::int=" . $this->anio . "
        and to_char(fecha_uso,'MM')::int=" . $this->mes . "),
        
        (select to_char(sum(hora_final-hora_inicio),'HH24:MI') hrs_lc_gs_jd
        from permisos where empleado = e.id and estado like '%Aceptado%' and
        (tipo_permiso like '%FUMIGACIÓN%' or tipo_permiso like '%ESTUDIO%' or tipo_permiso like '%OTROS%')
        and to_char(fecha_uso,'YYYY')::int=" . $this->anio . "
        and to_char(fecha_uso,'MM')::int=" . $this->mes . "),
        
        (select count(*) cant_olvido
        from permisos where empleado = e.id and estado like '%Aceptado%' and
        tipo_permiso like '%Const. olvido%'
        and to_char(fecha_uso,'YYYY')::int=" . $this->anio . "
        and to_char(fecha_uso,'MM')::int=" . $this->mes . "),
        
        (select to_char(sum(hora_final-hora_inicio),'HH24:MI') hrs_paternidad_duelo
        from permisos where empleado = e.id and estado like '%Aceptado%' and
        tipo_permiso like '%DUELO O PATERNIDAD%'
        and to_char(fecha_uso,'YYYY')::int=" . $this->anio . "
        and to_char(fecha_uso,'MM')::int=" . $this->mes . "),
        
        CASE WHEN (" . $this->mes . ">1) THEN
           (select to_char(sum(hora_final-hora_inicio),'HH24:MI') hrs_lc_gs_ant
           from permisos where empleado = e.id
                  and permisos.estado like '%Aceptado%'
                  and tipo_permiso like '%LC/GS%'
                  and to_char(fecha_uso,'YYYY')::int=" . $this->anio . "
                  and to_char(fecha_uso,'MM')::int=(" . $this->mes . "-1))
            ELSE
            (select '00:00' hrs_lc_gs_ant)
        END,
        
        (select to_char(sum(hora_final-hora_inicio),'HH24:MI') hrs_lc_gs_acu
            from permisos  where empleado = e.id  and permisos.estado like '%Aceptado%' and
            tipo_permiso like '%LC/GS%' and to_char(fecha_uso,'YYYY')::int=" . $this->anio . " and
            to_char(fecha_uso,'MM')::int<=" . $this->mes . "),
        
        lcg.anuales||':00' hrs_lc_gs_anuales,

        CASE WHEN ((select to_char(sum(hora_final-hora_inicio),'HH24:MI')
            from permisos  where empleado = e.id  and permisos.estado like '%Aceptado%' and
            tipo_permiso like '%LC/GS%' and to_char(fecha_uso,'YYYY')::int=" . $this->anio . " and
            to_char(fecha_uso,'MM')::int<=" . $this->mes . ")::text is null) THEN
                (select lcg.anuales||':00' hrs_disp)
            ELSE 
                (select (lcg.anuales::int-to_char(sum(hora_final-hora_inicio),'HH24')::int)||':'||to_char(sum(hora_final-hora_inicio),'MI')::int
                hrs_disp from permisos where empleado = e.id and permisos.estado like 'Aceptado' and
                tipo_permiso like '%LC/GS%' and to_char(fecha_uso,'YYYY')::int=" . $this->anio . " 
                and to_char(fecha_uso,'MM')::int<=" . $this->mes . ")
        END
        
        from empleado e
        
        inner join tipo_jornada tj on e.id_tipo_jornada = tj.id
        inner join licencia_con_goses lcg on tj.id = lcg.id_tipo_jornada
        where e.id_depto=" . $this->departamento . "
        group by e.nombre,e.apellido, lcg.anuales,e.id
        order by e.apellido asc;
        ";

        $query = trim($query);

        $permisos_mensual = DB::select($query);

        //echo dd($permisos_mensual)

        $depto = DB::table('departamentos')
            ->select('nombre_departamento')
            ->where('id', $this->departamento)
            ->first();

        $depto = $depto->nombre_departamento;
        $mes = $this->mes($this->mes);
        $anio = $this->anio;
        $comentario = $this->comentario;

        return view('Licencias.exports.licencias', compact('permisos_mensual', 'depto', 'mes', 'anio', 'comentario'));
    }

    protected function mes($mes)
    {
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        return $meses[$mes - 1];
    }

    /**CONSULTA PURA*/
    /*select TRIM(e.apellido)||','||TRIM(e.nombre) as nombre,
null as hrs_inpunt,null as hrs_inasis,null as hrs_descont,

(select to_char(sum(hora_final-hora_inicio),'HH24:MI') hrs_lc_gs
from permisos  where empleado = e.id and estado like '%Aceptado%'
and tipo_permiso like '%LC/GS%'
and to_char(fecha_uso,'YYYY')::int=". $this->anio ."
and to_char(fecha_uso,'MM')::int=". $this->mes ."),

(select to_char(sum(hora_final-hora_inicio),'HH24:MI') hrs_ls_gs
from permisos where empleado = e.id and estado like '%Aceptado%' and tipo_permiso like '%LS/GS%'
and to_char(fecha_uso,'YYYY')::int=". $this->anio ."
and to_char(fecha_uso,'MM')::int=". $this->mes ."),

(select to_char(sum(hora_final-hora_inicio),'HH24:MI') hrs_l_ofic from permisos
where empleado = e.id and estado like '%Aceptado%' and
(tipo_permiso like '%L.OFICIAL/A%' or tipo_permiso like 'L OFICIAL')
and to_char(fecha_uso,'YYYY')::int=". $this->anio ."
and to_char(fecha_uso,'MM')::int=". $this->mes ."),

(select to_char(sum(hora_final-hora_inicio),'HH24:MI') hrs_t_comp
from permisos where empleado = e.id and estado like '%Aceptado%' and tipo_permiso like '%T COMP%'
and to_char(fecha_uso,'YYYY')::int=". $this->anio ."
and to_char(fecha_uso,'MM')::int=". $this->mes ."),

(select to_char(sum(hora_final-hora_inicio),'HH24:MI') hrs_incap
from permisos where empleado = e.id and estado like '%Aceptado%' and
(tipo_permiso like '%INCAP%' or tipo_permiso like '%INCAPACIDAD/A%')
and to_char(fecha_uso,'YYYY')::int=". $this->anio ."
and to_char(fecha_uso,'MM')::int=". $this->mes ."),

(select to_char(sum(hora_final-hora_inicio),'HH24:MI') hrs_lc_gs_jd
from permisos where empleado = e.id and estado like '%Aceptado%' and
(tipo_permiso like '%FUMIGACIÓN%' or tipo_permiso like '%ESTUDIO%' or tipo_permiso like '%OTROS%')
and to_char(fecha_uso,'YYYY')::int=". $this->anio ."
and to_char(fecha_uso,'MM')::int=". $this->mes ."),

(select count(*) cant_olvido
from permisos where empleado = e.id and estado like '%Aceptado%' and
tipo_permiso like '%Const. olvido%'
and to_char(fecha_uso,'YYYY')::int=". $this->anio ."
and to_char(fecha_uso,'MM')::int=". $this->mes ."),

(select to_char(sum(hora_final-hora_inicio),'HH24:MI') hrs_paternidad_duelo
from permisos where empleado = e.id and estado like 'Aceptado' and
tipo_permiso like 'DUELO O PATERNIDAD'
and to_char(fecha_uso,'YYYY')::int=". $this->anio ."
and to_char(fecha_uso,'MM')::int=". $this->mes ."),

CASE WHEN (". $this->mes .">1) THEN
   (select to_char(sum(hora_final-hora_inicio),'HH24:MI') hrs_lc_gs_ant
   from permisos where empleado = e.id
          and permisos.estado like 'Aceptado'
          and tipo_permiso like 'LC/GS'
          and to_char(fecha_uso,'YYYY')::int=". $this->anio ."
          and to_char(fecha_uso,'MM')::int=(". $this->mes ."-1))
    ELSE
    (select '00:00' hrs_lc_gs_ant)
END,

(select to_char(sum(hora_final-hora_inicio),'HH24:MI') hrs_lc_gs_acu
    from permisos  where empleado = e.id  and permisos.estado like 'Aceptado' and
    tipo_permiso like 'LC/GS' and to_char(fecha_uso,'YYYY')::int=". $this->anio ." and
    to_char(fecha_uso,'MM')::int<=". $this->mes ."),

lcg.anuales||':00' hrs_lc_gs_anuales,

(select (lcg.anuales-to_char(sum(hora_final-hora_inicio),'HH24')::int)||':'||to_char(sum(hora_final-hora_inicio),'MI')
   hrs_lc_gs_disp from permisos where empleado = e.id and permisos.estado like 'Aceptado' and
tipo_permiso like 'LC/GS' and to_char(fecha_uso,'YYYY')::int=". $this->anio ." group by lcg.anuales)

from empleado e

inner join tipo_jornada tj on e.id_tipo_jornada = tj.id
inner join licencia_con_goses lcg on tj.id = lcg.id_tipo_jornada
where e.id_depto=5
group by e.nombre,e.apellido, lcg.anuales,e.id
order by e.apellido asc;

     */
}

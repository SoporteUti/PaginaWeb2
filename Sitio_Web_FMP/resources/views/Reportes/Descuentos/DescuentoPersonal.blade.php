<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte Descuento Personal</title>
    <style>
        #const {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #const td,
        #const th {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 12px;

        }

        #const th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #555755;
            color: #fff;

        }

        .page-break {
            page-break-after: always;
        }

    </style>

</head>

<body>

    @foreach ($empleadito as $e)
        <h4 align="center">
            Universidad de El Salvador<br>
            Facultad Multidisciplinaria Paracentral <br>
            Departamento: {{ $e->nombre_departamento }}<br>
        </h4>
            <h4 align="left">
        
            </div>
            Empleado: {{ $e->nombre }}{{ ' ' }}{{ $e->apellido }} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  Asistencia:
            @if ($request->des_mes == '1')
                Enero
            @elseif($request->des_mes == '2')
                Febrero
            @elseif($request->des_mes == '3')
                Marzo
            @elseif($request->des_mes == '4')
                Abril
            @elseif($request->des_mes == '5')
                Mayo
            @elseif($request->des_mes == '6')
                Junio
            @elseif($request->des_mes == '7')
                Julio
            @elseif($request->des_mes == '8')
                Agosto
            @elseif($request->des_mes == '9')
                Septiembre
            @elseif($request->des_mes == '10')
                Octubre
            @elseif($request->des_mes == '11')
                Noviembre
            @elseif($request->des_mes == '12')
                Diciembre
            @endif
            de {{ $request->des_anio }}<br>

        </h4>
    @endforeach
   
    <h4 align="center">
        DESCUENTO DIARIO POR IMPUNTUALIDAD
    </h4>

    <table id="const" class="table">
        <thead>
            <tr>
                <th style="text-align: center">N°</th>
                <th style="text-align: center">Fecha</th>
                <th style="text-align: center">Hora Marcaje</th>
                <th style="text-align: center">Jornada</th>
                <th style="text-align: center">Minutos</th>
                <th style="text-align: center">Descuento Diario</th>
                <th style="text-align: center">Estado</th>





            </tr>
        </thead>
        <tbody>
            @php
                $i = 0;
                $totalSimple=0;
                $totalDoble=0;
                $totalDescuento=0;
            @endphp
            @foreach ($reloj as $r)
                @php
                    $i++;
                    $totalSimple    =  $totalSimple + $r->minutossimples;
            
                    $totalDescuento =  $totalDescuento + $r->descuento;
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $i }}</td>
                    <td style="text-align: center;">{{ strtotime($r->fecha) }}</td>
                    <td style="text-align: center;">{{ $r->entrada }}</td>
                    <td style="text-align: center;">{{ $r->jornada   }}</td>
                    <td style="text-align: center;">{{ $r->minutossimples }}</td>
                    <td style="text-align: center;">{{'$'}}{{ $r->descuento }}</td>
                    <td style="text-align: center;">{{ $r->solvente }}</td>


                </tr>
            @endforeach

         
            <tr>
                <th style="text-align: center"  >{{''}}</th>
                <th style="text-align: center" >{{'        '}}</th>
                <th style="text-align: center" >{{' '}}</th>               
                <th style="text-align: center" >{{'Total   '}}{{'                     '}}</th>
                <th style="text-align: center">{{ $totalSimple }}{{' Minutos'}}</th>
                <th style="text-align: center">{{'$'}}{{ $totalDescuento}}</th>
                <th style="text-align: center" >{{' '}}</th>               
            </tr>
          

        </tbody>

    </table>
    
    <br>

    <h4 align="center">
        DESCUENTO DIARIO POR INASISTENCIA
    </h4>

    <table id="const" class="table">
        <thead>
            <tr>
                <th style="text-align: center">N°</th>
                <th style="text-align: center">Fecha</th>
                <th style="text-align: center">Entrada Marcaje</th>
                <th style="text-align: center">Salida Marcaje</th>
                <th style="text-align: center">Jornada</th>
                <th style="text-align: center">Salario</th>
                <th style="text-align: center">M.Entrada</th>
                <th style="text-align: center">D.Entrada($)</th>
                <th style="text-align: center">M.Salida</th>
                <th style="text-align: center">D.Salida($)</th>
                <th style="text-align: center">M.Inasistencia</th>
                <th style="text-align: center">D.Inasistencia($)</th>
                <th style="text-align: center">M.salida Antes</th>
                <th style="text-align: center">D.Salida Antes($)</th>

            </tr>
        </thead>
        @if(!empty($descuento_inasistencia))
        <tbody>
            @php
                $i = 0;
                $mEntrada=0;
                $dEntrada=0;
                $mSalida=0;
                $dSalida=0;
                $mInasistencia=0;
                $dInasistencia=0;
                $mSalidaAntes=0;
                $dSalidaAntes=0;
            @endphp
            @foreach ($descuento_inasistencia as $di)
                @php
                    $i++;
                    $mEntrada       =   $mEntrada+$di->minutos_entrada ;
                    $dEntrada       =   $dEntrada+$di->descuento_entrada;
                    $mSalida        =   $mSalida+$di->minutos_salida;
                    $dSalida        =   $dSalida+$di->descuento_salida;
                    $mInasistencia  =   $mInasistencia+$di->minutos_entrada_salida;
                    $dInasistencia  =   $dInasistencia+$di->descuento_entrada_salida;
                    $mSalidaAntes   =   $mSalidaAntes+$di->minutos_salida_antes;
                    $dSalidaAntes   =   $dSalidaAntes+$di->descuento_salida_antes;

                    $totalInasistencia = $dEntrada + $dSalida + $dInasistencia + $dSalidaAntes;
                //minutos
                    $totalInasistenciaMinutos = $mEntrada + $mSalida + $mInasistencia + $mSalidaAntes;
                   
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $i }}</td>
                    <td style="text-align: center;">{{ Carbon\Carbon::parse(strtotime($di->fecha))->formatLocalized('%d/%B/%Y') }}</td>
                    <td style="text-align: center;">{{ $di->entrada }}</td>
                    <td style="text-align: center;">{{ $di->salida }}</td>
                    <td style="text-align: center;">{{ $di->jornada }}</td>
                    <td style="text-align: center;">{{ $di->salario }}</td>
                    <td style="text-align: center;">{{ $di->minutos_entrada }}</td>
                    <td style="text-align: center;">{{'$'}}{{ $di->descuento_entrada }}</td>
                    <td style="text-align: center;">{{ $di->minutos_salida }}</td>
                    <td style="text-align: center;">{{'$'}}{{ $di->descuento_salida }}</td>
                    <td style="text-align: center;">{{ $di->minutos_entrada_salida }}</td>
                    <td style="text-align: center;">{{'$'}}{{ $di->descuento_entrada_salida }}</td>
                    <td style="text-align: center;">{{ $di->minutos_salida_antes }}</td>
                    <td style="text-align: center;">{{'$'}}{{ $di->descuento_salida_antes }}</td>


                </tr>
            @endforeach

         
           <tr>
                <th style="text-align: center"  >{{''}}</th>
                <th style="text-align: center" >{{''}}</th>
                <th style="text-align: center" >{{''}}</th>
                <th style="text-align: center" >{{''}}</th>
                <th style="text-align: center" >{{' '}}</th>
                <th style="text-align: center" >{{'Sub Total   '}}{{'                     '}}</th>
                <th style="text-align: center">{{ $mEntrada }}{{' Minutos'}}</th>
                <th style="text-align: center">{{'$'}}{{ $dEntrada}}</th>
                <th style="text-align: center">{{ $mSalida }}{{' Minutos'}}</th>
                <th style="text-align: center">{{'$'}}{{ $dSalida}}</th>
                <th style="text-align: center">{{ $mInasistencia }}{{' Minutos'}}</th>
                <th style="text-align: center">{{'$'}}{{ $dInasistencia}}</th>
                <th style="text-align: center">{{ $mSalidaAntes}} {{' Minutos'}}</th>
                <th style="text-align: center">{{'$'}}{{ $dSalidaAntes}}</th>
               
            </tr>

            <tr>
                <th style="text-align: center"  >{{''}}</th>
                <th style="text-align: center" >{{'Total Minutos'}}</th>
                <th style="text-align: center" >{{$totalInasistenciaMinutos}}{{' Minutos'}}</th>
                <th style="text-align: center" >{{'Total D.'}}</th>
                <th style="text-align: center" >{{'$'}}{{$totalInasistencia}}</th>
                <th style="text-align: center" >{{''}}</th>
                <th style="text-align: center">{{''}}</th>
                <th style="text-align: center">{{''}}</th>
                <th style="text-align: center">{{''}}</th>
                <th style="text-align: center">{{''}}</th>
                <th style="text-align: center">{{''}}</th>
                <th style="text-align: center">{{''}}</th>
                <th style="text-align: center">{{''}}</th>
                <th style="text-align: center">{{''}}</th>
               
            </tr>
          

        </tbody>
        @endif
    </table>

    <br>

    <h4 align="center">
        DESCUENTO DIARIO POR LICENCIA SIN GOCE DE SUELDO
    </h4>

    <table id="const" class="table">
        <thead>
            <tr>
                <th style="text-align: center">N°</th>
                <th style="text-align: center">Fecha</th>
                <th style="text-align: center">Hora Inicio</th>
                <th style="text-align: center">Hora Final</th>
                <th style="text-align: center">Jornada</th>
                <th style="text-align: center">Salario</th>
                <th style="text-align: center">Total Minutos</th>
                <th style="text-align: center">Descuento($)</th>

            </tr>
        </thead>
        <tbody>
            @php
                $i = 0;
                $minutos=0;
                $sg_descuento=0;
               
            @endphp
            @foreach ($descuento_sin_gose  as $sg)
                @php
                    $i++;
                    $minutos     =   $minutos + $sg->total_minutos;
                    $sg_descuento   =   $sg_descuento + $sg->descuento;
                   
                   
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $i }}</td>
                    <td style="text-align: center;">{{ Carbon\Carbon::parse(strtotime($sg->fecha))->formatLocalized('%d/%B/%Y') }}</td>
                    <td style="text-align: center;">{{ $sg->hora_inicio }}</td>
                    <td style="text-align: center;">{{ $sg->hora_final  }}</td>
                    <td style="text-align: center;">{{ $sg->jornada }}</td>
                    <td style="text-align: center;">{{'$'}}{{ $sg->salario }}</td>
                    <td style="text-align: center;">{{ $sg->total_minutos}}</td>
                    <td style="text-align: center;">{{'$'}}{{ $sg->descuento }}</td>
                </tr>
            @endforeach

         
           <tr>
                <th style="text-align: center"  >{{''}}</th>
                <th style="text-align: center" >{{''}}</th>
                <th style="text-align: center" >{{''}}</th>
                <th style="text-align: center" >{{''}}</th>
                <th style="text-align: center" >{{' '}}</th>
                <th style="text-align: center" >{{' '}}</th>    
                <th style="text-align: center">{{ $minutos}} {{' Minutos'}}</th>
                <th style="text-align: center">{{'$'}}{{ $sg_descuento}}</th>
               
            </tr>

        </tbody>

    </table>


    {{-- PARA EL PAGINADO DE PAGINAS --}}
    <script type="text/php">
        if ( isset($pdf) ) {
                $pdf->page_script('
                    $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                    $pdf->text(270, 820, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 10);
                ');
            }
        	</script>
    {{-- FIN DE PAGINADO --}}


</body>

</html>

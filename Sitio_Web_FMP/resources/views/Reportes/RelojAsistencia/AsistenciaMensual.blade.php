<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte Asistencia Personal</title>
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
            @if ($request->asistencia_mes == '1')
                Enero
            @elseif($request->asistencia_mes == '2')
                Febrero
            @elseif($request->asistencia_mes == '3')
                Marzo
            @elseif($request->asistencia_mes == '4')
                Abril
            @elseif($request->asistencia_mes == '5')
                Mayo
            @elseif($request->asistencia_mes == '6')
                Junio
            @elseif($request->asistencia_mes == '7')
                Julio
            @elseif($request->asistencia_mes == '8')
                Agosto
            @elseif($request->asistencia_mes == '9')
                Septiembre
            @elseif($request->asistencia_mes == '10')
                Octubre
            @elseif($request->asistencia_mes == '11')
                Noviembre
            @elseif($request->asistencia_mes == '12')
                Diciembre
            @endif
            del {{ $request->asistencia_anio }}<br>    

        </h4>
    @endforeach

    <h4 align="center">
        @foreach ($periodos as $p)
            Jornada Laboral para el periodo del :{{ Carbon\Carbon::parse($p->fecha_inicio)->format('d/M/Y') }} al
            {{ Carbon\Carbon::parse($p->fecha_fin)->format('d/M/Y') }}<br>
        @endforeach
    </h4>

    <table id="const" class="table">
        <thead>
            <tr>

                <th style="text-align: center">Dia</th>
                <th style="text-align: center">Hora Entrada</th>
                <th style="text-align: center">Hora Salida</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($jornada as $j)
                <tr>
                    <td style="text-align: center;">{{ $j->dia }}</td>
                    <td style="text-align: center;">{{ $j->hora_inicio }}</td>
                    <td style="text-align: center;">{{ $j->hora_fin }}</td>
                </tr>
            @endforeach


        </tbody>

    </table>

    <br>
   
    <h4 align="center">
        ASISTENCIA MENSUAL
    </h4>

    <table id="const" class="table">
        <thead>
            <tr>
                <th style="text-align: center">N°</th>
                <th style="text-align: center">Fecha</th>
                <th style="text-align: center">Dia de semana</th>
                <th style="text-align: center">Entrada</th>
                <th style="text-align: center">Salida</th>
            
            </tr>
        </thead>
        <tbody>
            @php
                $i = 0;
               
            @endphp
            @foreach ($reloj as $r)
                @php
                    $i++;
                    
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $i }}</td>
                    <td style="text-align: center;">{{ Carbon\Carbon::parse($r->fecha)->format('d/M/Y') }}</td>
                    <td style="text-align: center;">{{ $r->dia_semana}}</td>
                    <td style="text-align: center;">{{ $r->entrada }}</td>
                    <td style="text-align: center;">{{ $r->salida}}</td>
                </tr>
            @endforeach

        </tbody>

    </table>
    <br>

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

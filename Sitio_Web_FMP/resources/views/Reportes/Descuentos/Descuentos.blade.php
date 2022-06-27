<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Descuentos</title>
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

    @foreach ($departamento as $dep)
        <h4 align="center">
            Universidad de El Salvador<br>
            Facultad Multidisciplinaria Paracentral <br>
            Departamento: {{ $dep->nombre_departamento }}{{ ' ' }} &nbsp; &nbsp; &nbsp; Mes: {{$mes}} 
          
            de {{ $request->anio }}<br>
            <br>
        </h4>
        
    @endforeach

    <h4 align="center">
        INFORME DE DESCUENTOS POR IMPUNTUALIDAD

    </h4>
    
       
        <table id="const" class="table">
            <thead>
                <tr>
                    <th style="text-align: center;">N°</th>
                    <th style="text-align: center">Nombre</th>
                    <th style="text-align: center">Jornadas</th>
                    <th style="text-align: center">Días del mes</th>
                    <th style="text-align: center">Minutos por día</th>
                    <th style="text-align: center">Estado</th>
                    <th style="text-align: center">Minutos totales</th>                    
                    <th style="text-align: center">Descuento($)</th>
                </tr>
            </thead>
            <tbody>
                @php
                $i = 0;
                @endphp
                @foreach ($todosDescuentos as $item)
              
                    @php
                     $i ++;
                    @endphp

                        <tr>
                            <td style="text-align: center;">{{$i}}</td>
                            <td style="text-align: center;">{{ $item->nombre}}</td>
                            <td style="text-align: center;">{{ $item->jornada}}</td>
                            <td style="text-align: center;">{{ $item->dias }}</td>
                            <td style="text-align: center;">{{ $item->minutos }}</td>
                            <td style="text-align: center;">{{ $item->solvente }}</td>
                            <td style="text-align: center;">{{ $item->minutossimples}}</td>
                            <td style="text-align: center;">{{'$'}}{{$item->descuentos}}</td>
                           
                        </tr>
                    
                @endforeach


            </tbody>

        </table>
    <h4 align="center">
        INFORME DE DESCUENTOS POR INASISTENCIAS

    </h4>
    
       
        <table id="const" class="table">
            <thead>
                <tr>
                    <th style="text-align: center;">N°</th>
                    <th style="text-align: center">Nombre</th>
                    <th style="text-align: center">Jornadas</th>
                    <th style="text-align: center">Días del mes</th>
                    <th style="text-align: center">Horas por día</th>
                    <th style="text-align: center">Estado</th>
                    <th style="text-align: center">Horas totales</th>
                    <th style="text-align: center">Minutos totales</th>
                    <th style="text-align: center">Descuento($)</th>
                </tr>
            </thead>
            <tbody>
                @php
                $i = 0;
                @endphp
                @foreach ($todosDescuentos_inasistencia as $ina)
              
                    @php
                     $i ++;
                    @endphp

                        <tr>
                            <td style="text-align: center;">{{$i}}</td>
                            <td style="text-align: center;">{{ $ina->nombre}}</td>
                            <td style="text-align: center;">{{ $ina->jornadas}}</td>
                            <td style="text-align: center;">{{ $ina->dia_mes }}</td>
                            <td style="text-align: center;">{{ $ina->horas_dias }}</td>
                            <td style="text-align: center;">{{ $ina->solvente }}</td> 
                            <td style="text-align: center;">{{ $ina->hrs_inasis}}</td>
                            <td style="text-align: center;">{{ $ina->minutos}}</td>

                            <td style="text-align: center;">{{'$'}}{{$ina->descuento}}</td>
                           
                        </tr>
                    
                @endforeach


            </tbody>

        </table>

        <br>

    {{--para validar si hay licencia sin goce--}}
    @if(!empty($sin_gose))

    <h4 align="center">
        INFORME DE DESCUENTO DIARIO POR LICENCIA SIN GOCE DE SUELDO
    </h4>

    <table id="const" class="table">
        <thead>
            <tr>
                <th style="text-align: center">N°</th>
                <th style="text-align: center">Días del Mes</th>       
                <th style="text-align: center">Jornada</th>
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
            @foreach ($sin_gose  as $sg)
                @php
                    $i++;
                    $minutos     =   $minutos + $sg->total_minutos;
                    $sg_descuento   =   $sg_descuento + $sg->descuento;
                   
                   
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $i }}</td>
                    <td style="text-align: center;">{{ $sg->fecha}}</td>
                    <td style="text-align: center;">{{ $sg->jornada }}</td>
                    <td style="text-align: center;">{{ $sg->total_minutos}}</td>
                    <td style="text-align: center;">{{'$'}}{{ $sg->descuento }}</td>
                </tr>
            @endforeach

         
           <tr>
                <th style="text-align: center"  >{{''}}</th>
                <th style="text-align: center" >{{''}}</th>
                <th style="text-align: center" >{{' '}}</th>
                <th style="text-align: center" >{{'Total'}}</th>    
                <th style="text-align: center">{{ $minutos}} {{' Minutos'}}</th>
                <th style="text-align: center">{{'$'}}{{ $sg_descuento}}</th>
               
            </tr>

        </tbody>

    </table>
    @endif
   
  
    
    {{-- PARA EL PAGINADO DE PAGINAS --}}
    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(270, 820, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 10);
            ');
        }
    	</script>
    {{--FIN DE PAGINADO--}}


</body>

</html>

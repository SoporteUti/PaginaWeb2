<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte Licencias</title>
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

    @foreach ($departamentos as $dep)
        <h4 align="center">
            Universidad de El Salvador<br>
            Facultad Multidisciplinaria Paracentral <br>
            {{ $dep->nombre_departamento }}{{ ' ' }}<br>
            {{$request->mesR}} del {{$request->anio}}
          
            <br>

        </h4>

        <table id="const" class="table">
            <thead>
                <tr>
                    <th style="text-align: center; width: 20%;">Nombre</th>
                    <th style="text-align: center">Tipo</th>
                    <th style="text-align: center">Fecha uso</th>
                    <th style="text-align: center">Horas a utilizar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permisos as $item)
                        <tr>
                            <td style="text-align: center;">{{ $item->nombre }}{{ ' ' }}{{ $item->apellido }}</td>
                            <td style="text-align: center;">{{ $item->tipo_permiso }}</td>
                            <td style="text-align: center;">{{ Carbon\Carbon::parse($item->fecha_uso)->format('d/M/Y') }}</td>
                            @if ($item->olvido=='Entrada' || $item->olvido=='Salida')
                            <td style="text-align: center;">{{ $item->olvido }}</td>   
                            @else
                            <td style="text-align: center;">{{ '' . \Carbon\Carbon::parse($item->fecha_uso . 'T' . $item->hora_inicio)->diffAsCarbonInterval(\Carbon\Carbon::parse($item->fecha_uso . 'T' . $item->hora_final)) }}</span></td>
                            @endif
                        </tr>
                @endforeach


            </tbody>

        </table>
   
    @endforeach
    
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

<table border="1">
    <thead>
    <tr>
        <th style="text-align: center; vertical-align: middle;" rowspan="2">N°</th>
        <th style="text-align: center; vertical-align: middle;" width='40' rowspan="2">NOMBRE</th>
        <th style="text-align: center; vertical-align: middle;" width='30' rowspan="2">TIEMPO DE CONTRATO</th>
        <th colspan="2" style="text-align: center; vertical-align: middle;">LUNES</th>
        <th colspan="2" style="text-align: center; vertical-align: middle;">MARTES</th>
        <th colspan="2" style="text-align: center; vertical-align: middle;">MIERCOLES</th>
        <th colspan="2" style="text-align: center; vertical-align: middle;">JUEVES</th>
        <th colspan="2" style="text-align: center; vertical-align: middle;">VERNES</th>
        <th colspan="2" style="text-align: center; vertical-align: middle;">SABADO</th>
        <th colspan="2" style="text-align: center; vertical-align: middle;">DOMINGO</th>
        <th  rowspan="2" style="text-align: center; vertical-align: middle;">TOTAL</th>
    </tr>
    <tr>
        <th style="text-align: center; vertical-align: middle;">ENTRADA</th>
        <th style="text-align: center; vertical-align: middle;">SALIDA</th>
        <th style="text-align: center; vertical-align: middle;">ENTRADA</th>
        <th style="text-align: center; vertical-align: middle;">SALIDA</th>
        <th style="text-align: center; vertical-align: middle;">ENTRADA</th>
        <th style="text-align: center; vertical-align: middle;">SALIDA</th>
        <th style="text-align: center; vertical-align: middle;">ENTRADA</th>
        <th style="text-align: center; vertical-align: middle;">SALIDA</th>
        <th style="text-align: center; vertical-align: middle;">ENTRADA</th>
        <th style="text-align: center; vertical-align: middle;">SALIDA</th>
        <th style="text-align: center; vertical-align: middle;">ENTRADA</th>
        <th style="text-align: center; vertical-align: middle;">SALIDA</th>
        <th style="text-align: center; vertical-align: middle;">ENTRADA</th>
        <th style="text-align: center; vertical-align: middle;">SALIDA</th>
    </tr>
    </thead>
    <tbody>
    @foreach($jornadas as $index => $item)

        <tr>
            <td style="text-align: center; vertical-align: middle;" rowspan="2">{{ ($index+1) }}</td>
            <td style="text-align: center; vertical-align: middle;" rowspan="2">{{ $item->empleado_rf->nombre }} {{ $item->empleado_rf->apellido }}</td>
            <td style="text-align: center; vertical-align: middle;" rowspan="2">{{ $item->empleado_rf->tipo_jornada_rf->tipo }}</td>

            @php
                $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                $horas_diarias = [];
                $total = 0;
            @endphp
            @foreach ($dias as $value)
                @php
                    $valores = $item->horas($value, $item->id_emp , $periodo, $item->id);
                    $horas_diarias[$value] = is_null($valores) ? 0 : intval($valores->hora_fin)-intval($valores->hora_inicio);
                    $total += is_null($valores) ? 0 : intval($valores->hora_fin)-intval($valores->hora_inicio);
                @endphp
                @if (!is_null($valores))
                    <td style="text-align: center; vertical-align: middle;">{{ $valores->hora_inicio }}</td>
                    <td style="text-align: center; vertical-align: middle;">{{ $valores->hora_fin }}</td>
                @else
                    <td style="background-color: #ef8888; text-align: center; vertical-align: middle;"> -- </td>
                    <td style="background-color: #ef8888; text-align: center; vertical-align: middle;"> -- </td>
                @endif
            @endforeach
            <td rowspan="2" style="text-align: center; vertical-align: middle;">{{ $total }} HORAS </td>
        </tr>
        <tr>
            @foreach ($horas_diarias as $value)
                    <td colspan="2" style="text-align: center; vertical-align: middle;"> {{ $value }}  HORAS</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>

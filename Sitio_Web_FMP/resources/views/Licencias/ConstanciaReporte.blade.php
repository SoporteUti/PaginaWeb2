<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Const. Olvido de Marcaje</title>
    <style>
        #const{
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        #const td, #const th{
            border: 1px solid #ddd;
            padding: 8px;

        }
        #const th{
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: #fff;

        }
    </style>
</head>
<body>
    <h4 align="center">
        Universidad de El Salvador<br>
        Facultad Multidisciplinaria Paracentral <br>

        
        <br>

    </h4>
    <table id="const" class="table">
        <thead>
            <tr>
            <th>Fecha</th>
            <th>Marcaje</th>
            <th>Hora de olvido</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr>
                <td>{{Carbon\Carbon::parse($item->fecha_uso)->format('d/M/Y')}}</td>
                <td> <span class="badge badge-success font-13">{{$item->olvido}}</span></td>
                <td>{{date('H:i', strtotime($item->hora_inicio))}}</td>
            </tr> 
        @endforeach 
         
        </tbody>

    </table>
    
</body>
</html>
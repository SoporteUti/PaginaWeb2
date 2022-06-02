@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title"><i class="fa fa-list"></i> Administración de Jornada</h4>
        </div>
    </div>
</div>
<div class="card-box">
    <div class="row">
        <div class="col-12 col-sm-5">
            <h3>Jornadas Registradas</h3>
        </div>
        @if($cargar)
            <div class="col-12 col-sm-7" style="text-align:right">
                @hasanyrole('Jefe-Academico|Jefe-Administrativo')
                    <button class="btn btn btn-info" title="Enviar notificación a Recursos Humanos de la finalización del registro de las jornadas" data-toggle="modal" data-target="#modalEmail"> <i class="fa fa-check-circle" aria-hidden="true"></i> </button>
                @endhasanyrole
                @hasanyrole('super-admin|Jefe-Academico|Recurso-Humano')
                    <button class="btn btn btn-success" title="Generar Reporte" data-toggle="modal" data-target="#modalExport"> <i class="fa fa-file-excel" aria-hidden="true"></i> </button>
                @endhasanyrole
                @if(is_null($emp) || $emp->tipo_empleado=='Académico')
                    <button class="btn btn btn-primary" title="Agregar Jornada" id="btnNewJornada"> <i class="dripicons-plus" aria-hidden="true"></i> </button>
                @endif
            </div>
        @endif
    </div>
        <hr>
    @if($cargar)
        <form action="{{ route('admin.jornada.index') }}" method="get" id="frmFiltrar">
            <div class="row">
                {{--  <div class="col-12 col-sm-2 col-md-2">
                    <button class="btn btn btn-outline-info btn-block" title="Filtrar Contenido" type="submit"> <i class="fa fa-filter" aria-hidden="true"></i> </button>
                </div>  --}}
                <div class="col-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <select class="form-group select2 select-filter" data-live-search="true" style="width: 100%"  data-style="btn-white"  name="periodo">
                            @if(isset($periodos))
                                @foreach ($periodos as $item)
                                    <option value="{{ $item->id }}" {{ strcmp($item->id, $periodo->id)==0 ? 'selected' : '' }}>({{ ucfirst($item->estado) }}) {{ $item->tipo }} -> {{ $item->nombre }} / {{ date('d-m-Y', strtotime($item->fecha_inicio)) }} - {{ date('d-m-Y', strtotime($item->fecha_fin)) }}</option>
                                @endforeach
                            @else
                                <script>window.location = "/admin/periodo";</script>
                            @endif
                        </select>
                    </div>
                </div>
                @hasanyrole('super-admin|Recurso-Humano|Jefe-Administrativo|Jefe-Academico')
                    <div class="col-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <select class="form-group select2 select-filter" style="width: 100%" data-live-search="true" data-style="btn-white"  name="depto">
                                <option value="all" selected> Todos los Departamentos </option>
                                @foreach ($deptos as $item)
                                    <option value="{{ $item->id }}" {{ strcmp($item->id, $depto)==0 ? 'selected' : '' }}>{!!$item->nombre_departamento!!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endhasanyrole
            </div>
        </form>
        <br/>
        <br/>
        <table  class="table table-sm dt-responsive nowrap" style="width:100%" id="table-jornada">
            <thead>
                <tr>
                    <th>Registro</th>
                    <th>Empleado</th>
                    <th>Tipo</th>
                    <th>Departamento</th>
                    <th>Tipo</th>
                    <th>Periodo Tipo</th>
                    <th>Periodo</th>
                    <th>Proceso</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jornadas as $item)
                    <tr {!! ($item->empleado_rf->id == Auth::user()->empleado_rf->id) ? 'style="background-color: rgba(21, 174, 234, 0.1);"' : '' !!} >
                        <th  data-sort="{{ strtotime($item->created_at) }}">{{ date('d/m/Y H:m', strtotime($item -> created_at)) }}</th>
                        <th>{{ $item -> empleado_rf->nombre }} {{ $item -> empleado_rf->apellido }}</th>
                        <td>{{ $item->empleado_rf->tipo_empleado }}</td>
                        <td>{{ $item->empleado_rf->departamento_rf->nombre_departamento }}</td>
                        <td>{{ $item->empleado_rf->tipo_jornada_rf->tipo }}</td>
                        <td>{{ $item->tipo_periodo }}</td>
                        <td>{{ $item -> periodo }}</td>
                        <td>
                            @php
                                $color = 'secondary';
                                if($item->procedimiento=='enviado a jefatura')
                                    $color = 'info';
                                else if($item->procedimiento=='enviado a recursos humanos')
                                    $color = 'primary';
                                else if($item->procedimiento=='la jefatura lo ha regresado por problemas')
                                    $color = 'warning';
                                else if($item->procedimiento=='aceptado')
                                    $color = 'success';
                                else if($item->procedimiento=='invalidado')
                                    $color = 'danger';
                            @endphp
                            <span class="badge badge-{{ $color }}">{{ Str::ucfirst($item->procedimiento) }}</span>
                        </td>
                        <td class="text-center">
                            <button data-key="{{ ($item->id) }}" data-toggle="modal" title="" data-target="#modalView" class="btn btn-outline-success btn-sm" onclick="fnDetalleJornada(this);" title="Detalle"><i class="fa fa-info-circle fa-fw" aria-hidden="true"></i></button>

                            {{-- CODIGO QUE DESCOMENTARIE--}}
                            {{--
                                @if(!($item->procedimiento=='aceptado'))
                                <button data-key="{{ ($item->id) }}" data-toggle="modal" data-target="#modalProcedimiento" class="btn btn-outline-info btn-sm" onclick="fnProcedimiento(this)" title="Seguimiento"><i class="fa fa-check-circle fa-fw" aria-hidden="true"></i></button>
                            @endif --}}
                            {{--CODIGO QUE DESCOMENTARIE--}}
                        {{--CODIGO QUE DESCOMENARIE--}}
                        
                          {{--***  @if (($item->empleado_rf->id == Auth::user()->empleado_rf->id))

                             {{-- @if($item->procedimiento=='guardado' || $item->procedimiento=='recursos humanos lo ha regresado a jefatura')
                                    <button data-key="{{ ($item->id) }}" data-toggle="modal" data-target="#modalProcedimiento" class="btn btn-outline-info btn-sm" onclick="fnProcedimiento(this)" title="Seguimiento"><i class="fa fa-check-circle fa-fw" aria-hidden="true"></i></button>
                                @endif--}}
                                

                            
                           {{--* @elseif (@Auth::user()->hasRole('super-admin') || @Auth::user()->hasRole('Recurso-Humano'))
                               {{-- ACTIVA DOS BOTONES EN RECURSOS HUMANOS 
                                @if($item->procedimiento=='enviado a recursos humanos')
                                    <button data-key="{{ ($item->id) }}" data-toggle="modal" data-target="#modalProcedimiento" class="btn btn-outline-info btn-sm" onclick="fnProcedimiento(this)" title="Seguimiento"><i class="fa fa-check-circle fa-fw" aria-hidden="true"></i></button>
                                @endif--}}

                           
                               {{-- @elseif(@Auth::user()->hasRole('Jefe-Academico') || @Auth::user()->hasRole('Jefe-Administrativo')|| @Auth::user()->hasRole('Recurso-Humano'))
                                @if($item->procedimiento=='enviado a jefatura' || $item->procedimiento=='recursos humanos lo ha regresado a jefatura')
                                    <button data-key="{{ ($item->id) }}" data-toggle="modal" data-target="#modalProcedimiento" class="btn btn-outline-info btn-sm" onclick="fnProcedimiento(this)" title="Seguimiento"><i class="fa fa-check-circle fa-fw" aria-hidden="true"></i></button>
                                @endif
                           
                            @endif --}}{{--FIN DE CODIGO QUE DESCOMENTARIE--}}

                            @php
                                //para establecer que si la jornada se encuentra finalizada ya no es posible darle seguimiento
                                $buttons = '';
                                if(strcmp('aceptado', $item->procedimiento)!=0)
                                    $buttons.='<button data-key="'.($item->id).'" data-toggle="modal" data-target="#modalProcedimiento" class="btn btn-outline-info btn-sm" onclick="fnProcedimiento(this)" title="Seguimiento"><i class="fa fa-check-circle fa-fw" aria-hidden="true"></i></button>';

                                    $buttons .= '<button class="btn btn-outline-primary btn-sm" onclick="fnEditJornada(this);" data-id="'.$item->id.'" title="Editar"><i class="fa fa-edit fa-fw" aria-hidden="true"></i></button>';
                            @endphp

                            @if( (@Auth::user()->hasRole('super-admin') || @Auth::user()->hasRole('Recurso-Humano')) || ( (@Auth::user()->hasRole('Jefe-Academico') || @Auth::user()->hasRole('Jefe-Administrativo') || @Auth::user()->hasRole('Docente')) && strcmp($item->periodo_rf->estado, 'activo')==0) )
                            @php //var_dump('******entrexxx'); 
                            @endphp
                                @if (($item->empleado_rf->id == Auth::user()->empleado_rf->id))
                                   @php var_dump('***********entre 1');
                                    @endphp
                                    @if (@Auth::user()->hasRole('super-admin') || @Auth::user()->hasRole('Recurso-Humano') )
                                 

                                        @if($item->procedimiento=='guardado' || $item->procedimiento=='enviado a recursos humanos' || $item->procedimiento=='aceptado')
                                            {!! $buttons !!}
                                        @endif
                                        

                                    @elseif((@Auth::user()->hasRole('Docente') && @Auth::user()->hasRole('Jefe-Academico')))
                                        @if($item->procedimiento=='guardado' || $item->procedimiento=='la jefatura lo ha regresado por problemas' ||  $item->procedimiento == 'enviado a jefatura' || $item->procedimiento=='recursos humanos lo ha regresado a jefatura')
                                            {!! $buttons !!}
                                        @endif
                                        
                                    @elseif((@Auth::user()->hasRole('Docente') && @Auth::user()->hasRole('Jefe-Administrativo')))
                                        @if($item->procedimiento=='guardado' || $item->procedimiento=='la jefatura lo ha regresado por problemas' )
                                            {!! $buttons !!}
                                        @endif
                                    @elseif(@Auth::user()->hasRole('Jefe-Academico') || @Auth::user()->hasRole('Jefe-Administrativo'))
                                        @if($item->procedimiento=='guardado' || $item->procedimiento=='recursos humanos lo ha regresado a jefatura' || $item->procedimiento == 'enviado a jefatura')
                                            {!! $buttons !!}
                                        @endif
                                    @elseif(@Auth::user()->hasRole('Docente'))
                                        @if($item->procedimiento=='guardado' || $item->procedimiento=='la jefatura lo ha regresado por problemas')
                                            {!! $buttons !!}
                                        @endif
                                    @endif

                                @elseif (@Auth::user()->hasRole('super-admin') || @Auth::user()->hasRole('Recurso-Humano')|| @Auth::user()->hasRole('Jefe-Administrativo'))

                                @php //var_dump('***entre 3'); 
                                 @endphp

                                
                                {{--codigo que agregue--}}
                                @if (@Auth::user()->hasRole('super-admin') || @Auth::user()->hasRole('Recurso-Humano') && $item->empleado_rf->departamento_rf->nombre_departamento=='RRHH' || 
                                $item->empleado_rf->departamento_rf->nombre_departamento=='Recursos Humanos')
                                @if( $item->procedimiento=='recursos humanos lo ha regresado a jefatura')
                                    @php //var_dump('*********ESTADO 1 REPRUEBA'); 
                                    @endphp
                                        {!! $buttons !!}
                                    @endif
                                @endif
                                {{--fin de codigo que agregue--}}

                                 {{--codigo que agregue--}}
                                 @if (@Auth::user()->hasRole('super-admin') || @Auth::user()->hasRole('Jefe-Administrativo'))
                                 @php //var_dump('####Admi'); 
                                 @endphp
                                 @if( $item->procedimiento=='recursos humanos lo ha regresado a jefatura')
                                     @php //var_dump('*********ESTADO 1 REPRUEBA'); 
                                     @endphp
                                         {!! $buttons !!}
                                     @endif
                                 @endif
                                 {{--fin de codigo que agregue--}}
                               
                                @if(@Auth::user()->hasRole('Recurso-Humano') && $item->procedimiento=='aceptado')
                                    @php //var_dump('*********ESTADO 1');
                                     @endphp
                                        {!! $buttons !!}
                                    @endif
                                
                                    @if(@Auth::user()->hasRole('Recurso-Humano') && $item->procedimiento=='enviado a recursos humanos')
                                    @php //var_dump('*********ESTADO 1');
                                     @endphp
                                        {!! $buttons !!}
                                    @endif
                                

                                @elseif((@Auth::user()->hasRole('Docente') && @Auth::user()->hasRole('Jefe-Academico')))
                                @php //var_dump('*********ESTADO 2');
                                 @endphp
                                    @if($item->procedimiento=='guardado' || $item->procedimiento == 'enviado a jefatura' || $item->procedimiento=='recursos humanos lo ha regresado a jefatura')
                                    @php //var_dump('*********ESTADO 3'); 
                                    @endphp {!! $buttons !!}
                                    @endif
                                @elseif((@Auth::user()->hasRole('Docente') && @Auth::user()->hasRole('Jefe-Administrativo')))
                                @php //var_dump('*********ESTADO 4'); 
                                @endphp
                                    @if($item->procedimiento=='guardado' || $item->procedimiento == 'enviado a jefatura')
                                        {!! $buttons !!}
                                    @endif
                                @elseif(@Auth::user()->hasRole('Jefe-Academico') || @Auth::user()->hasRole('Jefe-Administrativo')|| @Auth::user()->hasRole('Recurso-Humano'))
                                @php //var_dump('*********ESTADO 5'); 
                                @endphp    
                                @if($item->procedimiento=='enviado a jefatura' || $item->procedimiento=='recursos humanos lo ha regresado a jefatura')
                                @php //var_dump('*********ESTADO 4 re');
                                 @endphp
                                        {!! $buttons !!}
                                    @endif
                                @elseif(@Auth::user()->hasRole('Docente'))
                                @php //var_dump('*********ESTADO 5'); 
                                @endphp
                                    @if($item->procedimiento=='guardado' || $item->procedimiento=='la jefatura lo ha regresado por problemas')
                                        {!! $buttons !!}
                                    @endif
                                @endif



                            @endif
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="row">
            <div class="col-12">
                <div class="card-box p-2 border">
                    <p> <i class="fa fa-info-circle"></i> No es posible cargar la información perteneciente a <strong> {{ @Auth::user()->name }} </strong>.</p>
                    <label> A continuación se detallan las posibles causas: </label>
                    <ul>
                        <li>No existen <strong>Periodos</strong> registrados en el sistema.</li>
                        <li>El Usuario no se encuentra vinculado con ningun <strong>Empleado</strong> registrado en el sistema.</li>
                        <li>El Usuario no tiene los permisos necesarios.</li>
                        <li>El Usuario no es tipo <strong>Docente</strong>.</li>
                    </ul>
                </div>
            </div>
        </div>
    @endif
</div>
@include('Jornada._components.modals')
@endsection
@section('plugins')
<link href="{{ asset('template-admin/dist/assets/libs/select2/select2.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('template-admin/dist/assets/libs/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet"/>
@endsection
@section('plugins-js')
<!-- Bootstrap Select -->
<script src="{{ asset('template-admin/dist/assets/libs/bootstrap-select/bootstrap-select.min.js') }}" ></script>
<script src="{{ asset('template-admin/dist/assets/libs/select2/select2.min.js') }}" ></script>
<link rel="stylesheet" href="{{ asset('vendor/tabulator/dist/css/tabulator_simple.css') }}">
<script src="{{ asset('vendor/tabulator/dist/js/tabulator.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/scripts/jornadas.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.select2').select2();
        $("#jornada-div :input").prop("disabled", true);//para deshabilitar los botones cuando no este seleccionado ningun empleado


        $('#table-jornada').DataTable({
            'responsive': true,
            "order": [[ 0, "desc" ]],
            "language": {
                "decimal":        ".",
                "emptyTable":     "No hay datos para mostrar",
                "info":           "Del _START_ al _END_ (_TOTAL_ total)",
                "infoEmpty":      "Del 0 al 0 (0 total)",
                "infoFiltered":   "(Filtrado de todas las _MAX_ entradas)",
                "infoPostFix":    "",
                "thousands":      "'",
                "lengthMenu":     "Mostrar _MENU_ entradas",
                "loadingRecords": "Cargando...",
                "processing":     "Procesando...",
                "search":         "Buscar:",
                "zeroRecords":    "No hay resultados",
                "paginate": {
                    "first":      "Primero",
                    "last":       "Último",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                },
                "aria": {
                    "sortAscending":  ": Ordenar de manera Ascendente",
                    "sortDescending": ": Ordenar de manera Descendente ",
                }
                },
            "pagingType": "full_numbers",
            "lengthMenu":		[[5, 10, 20, 25, 50, -1], [5, 10, 20, 25, 50, "Todos"]],
		    "iDisplayLength":	5,
        });
    });

    $("#id_periodo").on('change', function () {//para cargar los empleados dependiendo del periodo
        let id = $(this).val();
        let is_edited = $("#is_edited").val();
        if(id!=='' && is_edited == 'false'){
            $("#jornada-div :input").prop("disabled", false);
            is_edited =  $("#is_edited").val('false');
            fnUpdatePeriodoSelect(id);
        }else{
            $("#jornada-div :input").prop("disabled", true);
        }
    });

    function fnUpdatePeriodoSelect(id, updateEmpleado = false, empleado = null, setPeriodo = false, periodo = null){
        let data = getData('GET', `{{ url('admin/jornada/periodoEmpleados') }}/`+id+'?updateEmpleado='+updateEmpleado,'#notificacion_jornada');
        let is_edited = $("#is_edited").val('true');
        data.then(function(response){
            $("#id_emp").val(null).trigger('change');
            $('#id_emp').empty();
            $('#id_emp').append('<option selected value="">Seleccione un Empleado</option>');
            $(response).each(function (index, element) {
                $("#id_emp").append('<option value="'+element.id+'">'+element.apellido+', '+element.nombre+'</option>');
            });

            if(setPeriodo && periodo!==null  || is_edited == 'true'){
                $("#id_periodo").val(periodo).trigger('change');
                $("#id_periodo").selectpicker('refresh');
                $("#id_periodo_text").prop('disabled', false);
                $("#id_periodo_text").val($("#id_periodo").val());
                $("#id_periodo").prop('disabled', true);
            }
            if(updateEmpleado && empleado!==null || is_edited == 'true'){//para uctualizar el dato del empleado
                $("#id_emp").val(empleado).trigger('change');
                $("#_idaux").val(empleado).trigger('change');
                $("#id_emp_text").prop('disabled', false);
                $("#id_emp_text").val($("#id_emp").val());
                $("#id_emp").prop('disabled', 'disabled');
            }
            is_edited =  $("#is_edited").val('false');
            $('#id_emp').selectpicker('refresh');
        });
    }


    //Para editar la jornada
    function fnEditJornada(element) {
        $("#modalNewJonarda").modal('show');
        $("#nota_div").show();
        let id = $(element).data('id');
        let data = getData('GET', `{{ url('admin/jornada') }}/`+id,'#notificacion_jornada');
        data.then(function(response){
            $("#_id").val(id);
            fnUpdatePeriodoSelect(response.jornada.id_periodo, true, response.jornada.id_emp, true, response.jornada.id_periodo);
            table.replaceData(response.items);
            $("#frmJornada #observaciones").val(response.jornada.observaciones);
        });
    }


    $("#id_emp").on('change', function () {//para cargar el total de horas por empleados
        let id = $(this).val();
        $("#jornada-div").show('slow');
        $("#btnSaveJornada").show('slow');
        $(".alert-error").remove();

        if(id!=='' && id!==null){
            $("#jornada-div :input").prop("disabled", false);
            let data = getData('GET', `{{ url('admin/jornada/jornadaEmpleado') }}/`+id,'#notificacion_jornada');
            data.then(function(response){
                $(".total-horas").val(response.empleado.horas_semanales + ':00');
                updateChangeTable();
                if(!response.permiso){
                    $("#jornada-div").hide('slow');
                    $("#btnSaveJornada").hide('slow');
                    let alert = `<div class="alert alert-danger alert-error" role="alert">
                            <div class="alert-message">
                                <strong> <i class="fa fa-info-circle"></i> Información!</strong>  Usted no cuenta con los permisos suficientes para poder realizar este proceso.
                            </div>
                        </div>`;
                    $("#jornada-div").before(alert);
                }
            });
        }else{
            $("#jornada-div :input").prop("disabled", true);
        }
    });


    //Para cargar las opciones del seguimiento
    function fnProcedimiento(componet){
        let jornada = $(componet).data('key');
        $("#formSeguimiento #jornada_id").val(jornada);
        let data = getData('GET', `{{ url('admin/jornada-seguimiento-opciones') }}/${jornada}`, '#notificacion_seguimiento');
        data.then(function (response) {
            $("#formSeguimiento #procesoSeguimiento").val(null).trigger('change');
            $('#formSeguimiento #procesoSeguimiento').empty();
            $.each(response, function (index, element) {
                $("#formSeguimiento #procesoSeguimiento").append('<option value="' + element.value + '">' + element.text + '</option>');
            });
            $('#formSeguimiento #procesoSeguimiento').selectpicker('refresh');
        });
    }


    function fnDetalleJornada(element) {
        $('#modalView').modal('show');
        let key = $(element).data('key');
        $.get( `{{ url('admin/jornada') }}/`+key, function(data) {
            var fecha = new Date(data.jornada.created_at);
            var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            let nota = (data.jornada.observaciones === null || data.jornada.observaciones === '') ? null : data.jornada.observaciones;
            let contNota= `<span class="float-center" >
                                <p class="lead" style="font-size: 13px;">Nota: <span class="badge badge-info" id="notaDetalle">${nota}</span></p>
                            </span>`;

            $('#fechaRegistroDetalle').html(fecha.toLocaleDateString("es-ES", options));
            if(nota != null){
                $('#rrNota').html(contNota);
            }else{
                $('#rrNota').hide();
            }

            let contenido = '';
            $.each(data.items, function (indexInArray, valueOfElement) {
                contenido +=`<tr>
                                <td>${valueOfElement.dia}</td>
                                <td>${valueOfElement.hora_inicio}</td>
                                <td>${valueOfElement.hora_fin}</td>
                                <td>${valueOfElement.jornada}</td>
                            </tr>`;
            });
            $("#bodyView").html(contenido);

            contenido = '';
            $.each(data.seguimiento, function (indexInArray, valueOfElement) {
                let options = { year: 'numeric', month: 'long', day: 'numeric' };
                let observaciones = valueOfElement.observaciones === null ? '' : valueOfElement.observaciones;
                contenido +=`<tr>
                                <td>${ new Date(valueOfElement.created_at).toLocaleDateString("es-ES", options) }</td>
                                <td class="text-dark">${ valueOfElement.proceso[0].toUpperCase() + valueOfElement.proceso.slice(1) }</td>
                                <td>${observaciones}</td>
                            </tr>`;
            });
            $("#bodySeguimiento").html(contenido);
        });
    }


</script>
@endsection

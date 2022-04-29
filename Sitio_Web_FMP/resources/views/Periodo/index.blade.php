@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title"><i class="fa fa-list"></i> Administación de Periodos</h4>
        </div>
    </div>
</div>
<div class="card-box">
    <div class="row">
        <div class="col-9">
            <h3>Periodos Registrados</h3>
        </div>
        <div class="col-3" style="text-align:right">
            <button class="btn btn btn-primary" title="Agregar nuevo registro" data-toggle="modal" data-target="#modalRegistro" id="btnNuevoRegistro"> <i class=" dripicons-plus" aria-hidden="true"></i> </button>
        </div>
    </div>
    <br/>
    @if(Session::has('bandera'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <div class="alert-message">
                <strong> <i class="fa fa-info-circle"></i> Información!</strong> {{ (Session::get('bandera')) }}
            </div>
        </div>
    @endif
    <br/>
    <table  class="table table-sm dt-responsive nowrap" style="width:100%" id="table-periodo">
        <thead>
            <tr>
                <th>Registro</th>
                <th data-priority="0">Id</th>
                <th data-priority="2">Ciclo</th>
                <th data-priority="3">Tipo</th>
                <th data-priority="4">Inicio</th>
                <th data-priority="5">Fin</th>
                <th data-priority="6">Estado</th>
                <th data-priority="6">Observaciones</th>
                <th data-priority="0" class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($periodo as $item)
            <tr>
                <th  data-sort="{{ strtotime($item->created_at) }}">{{ date('d/m/Y H:m', strtotime($item -> created_at)) }}</th>
                <th>{{ $item->id }}</th>
                <td>{{ $item->ciclo_rf->nombre }}</td>
                <td>{{ $item->tipo }}</td>
                <td>{{ date('d-m-Y', strtotime( $item->fecha_inicio)) }}</td>
                <td>{{ date('d-m-Y', strtotime( $item->fecha_fin)) }}</td>
                <td>
                    <span class="badge badge-{{ strcmp($item->estado, 'activo')==0 ? 'success' : 'secondary' }}">{{ Str::ucfirst($item->estado) }}</span>
                </td>
                <td>{{  $item->observaciones }}</td>
                <td class="text-center">
                    @if(strcmp($item->estado, 'finalizado')==0)
                        @hasanyrole('super-admin')
                            @if(strcmp($item->estado, 'finalizado')==0)
                                <button type="buttom"  class="btn btn-outline-dark btn-sm" {!! 'onclick="fnReactivar('. $item->id .')" data-toggle="modal" data-target="#modalReactivar"' !!}  title="Reactivar Ciclo"><i class="mdi mdi-restore"></i></button>
                            @endif                        
                        @endhasanyrole
                        @hasanyrole('Recurso-Humano')
                            <span class="small"> <i>Sin Acciones</i> </span>
                        @endhasanyrole
                    @elseif(strcmp($item->estado, 'inactivo')==0)
                        <button type="buttom"  class="btn btn-outline-dark btn-sm" {!! strcmp($item->estado, 'finalizado')==0 ? 'disabled' : 'onclick="fnReactivar('. $item->id .')" data-toggle="modal" data-target="#modalReactivar"' !!}  title="Reactivar Periodo"><i class="mdi mdi-restore"></i></button>
                    @else
                        <button type="buttom" class="btn btn-outline-dark btn-sm" {!! strcmp($item->estado, 'finalizado')==0 ? 'disabled' : 'onclick="fnFinalizar('. $item->id .')" data-toggle="modal" data-target="#modalFinalizar"' !!}  title="Finalizar Periodo"><i class="mdi mdi-close-octagon"></i></button>
                        <button class="btn btn-outline-primary btn-sm" title="Modificar Periodo" {!! strcmp($item->estado, 'finalizado')==0 ? 'disabled' : 'data-id="'. $item->id .'" data-toggle="modal" data-target="#modalRegistro" onclick="btnEdit(this);"' !!}><i class="fa fa-edit fa-fw" aria-hidden="true"></i></button>
                        <button type="buttom"  class="btn btn-outline-danger btn-sm" title="Eliminar Periodo" {!! strcmp($item->estado, 'finalizado')==0 ? 'disabled' : 'onclick="fnEliminar('. $item->id .')" data-toggle="modal" data-target="#modalEliminar"' !!} ><i class="mdi mdi-delete"></i></button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<!-- inicio Modal de registro -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="modalRegistro" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title"><i class=" mdi mdi-account-badge-horizontal mdi-24px" aria-hidden="true" ></i> Periodo</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form id="registroForm"  action="{{ route('admin.periodo.store') }}" method="POST">
                <input type="hidden" name="_id" id="_id">
                <div class="modal-body">
                        <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show" role="alert" style="display:none" id="notificacion"></div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <label>Nota: <code>* Campos Obligatorio</code></label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <label for="ciclo_id">Ciclo <span class="text-danger">*</span> </label>
                                    <select class="form-group selectpicker" data-live-search="true" data-style="btn-white" name="ciclo_id" id="ciclo_id">
                                        <option value="">Selecione un ciclo</option>
                                        @foreach ($ciclos as $item)
                                            <option value="{{ $item->id }}"> {{ $item->nombre }} <strong>{{ $item->año }}</strong></option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="FechaI">Periodo <span class="text-danger">*</span> </label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                                        </div>
                                        <input class="form-control" data-toggle="daterangepicker" id="rangos" maxlength="23" name="timestamp" data-filter-type="date-range">
                                        <input type="hidden" name="fecha_inicio" id="fecha_inicio">
                                        <input type="hidden" name="fecha_fin" id="fecha_fin">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12">
                                <div class="form-group selectpicker" data-live-search="true" data-style="btn-white">
                                    <label for="tipo">Tipo <span class="text-danger">*</span> </label>
                                    <select class="custom-select" name="tipo" id="tipo">
                                        <option value="Administrativo" >Administrativo</option>
                                        <option value="Académico">Académico</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="FechaI">Observaciones</label>
                                    <textarea type="text" class="form-control" name="observaciones" id="observaciones" placeholder="Ingrese las observaciones necesarias" rows="2"></textarea>
                                </div>
                            </div>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-ban"  aria-hidden="true"></i> Cerrar</button>
                    <button type="button" class="btn btn-primary" onClick="submitForm('#registroForm','#notificacion')"><li class="fa fa-save"></li> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modalEliminar" class="modal fade bs-example-modal-center" tabindex="-1"  role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myCenterModalLabel"><i class="mdi mdi-delete mdi-24px"></i> Eliminar Periodo</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="frmDelete" action="" method="POST">
                    <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show" role="alert" style="display:none" id="notificacion_eliminar"></div>
                    <div id="tblJornadasEliminar"></div>
                    <hr>
                    @csrf
                    @method('DELETE')
                    <div class="row py-3 text-center">
                        <div class="col-lg-2 fa fa-exclamation-triangle text-warning fa-4x"></div>
                        <div class="col-lg-10 text-black">
                            <h4 class="font-14 text-justify font-weight-bold">Advertencia: Se eliminará este registro de manera permanente, todas las Jornadas registradas quedaran inhabilitadas, ¿Desea continuar?</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <button type="submit" class="btn p-1 btn-light waves-effect waves-light btn-block font-24"> <i class="mdi mdi-check mdi-16px"></i>Si</button>
                        </div>
                        <div class="col-12 col-sm-6">
                            <button type="reset" class="btn btn-light p-1 waves-light waves-effect btn-block font-24" data-dismiss="modal" ><i class="mdi mdi-block-helper mdi-16px" aria-hidden="true"></i>No</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="modalFinalizar" class="modal fade bs-example-modal-center" tabindex="-1"  role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myCenterModalLabel"><i class="mdi mdi-close-octagon mdi-24px"></i> Finalizar Periodo</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show" role="alert" style="display:none" id="notificacion_finalizar"></div>
                <div id="tblJornadasFinalizar"></div>
                <hr>
                <form id="frmFinalizar" action="" method="GET">
                    <div class="row py-3">
                        <div class="col-lg-2 fa fa-exclamation-triangle text-warning fa-4x"></div>
                        <div class="col-lg-10 text-black">
                            <h4 class="font-14 text-justify font-weight-bold">Advertencia: Al finalizar este <strong>Periodo</strong> los empleados ya no podrán registrar las Jornadas, ni finalizar el proceso de seguimiento de las Jornadas de Trabajo, ¿Desea continuar?</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <button type="submit" class="btn p-1 btn-light waves-effect waves-light btn-block font-24"> <i class="mdi mdi-check mdi-16px"></i>Si</button>
                        </div>
                        <div class="col-12 col-sm-6">
                            <button type="reset" class="btn btn-light p-1 waves-light waves-effect btn-block font-24" data-dismiss="modal" ><i class="mdi mdi-block-helper mdi-16px" aria-hidden="true"></i>No</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="modalReactivar" class="modal fade bs-example-modal-center" tabindex="-1"  role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myCenterModalLabel"><i class="mdi mdi-close-octagon mdi-24px"></i> Reactivar Periodo</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="frmReactivar" action="" method="GET">
                    @csrf
                    <div class="row py-3">
                        <div class="col-lg-2 fa fa-exclamation-triangle text-warning fa-4x"></div>
                        <div class="col-lg-10 text-black">
                            <h4 class="font-17 text-justify font-weight-bold">Advertencia: Se Reactivará el Periodo seleccionado, ¿Desea continuar?</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <button type="submit" class="btn p-1 btn-light waves-effect waves-light btn-block font-24"> <i class="mdi mdi-check mdi-16px"></i>Si</button>
                        </div>
                        <div class="col-xl-6">
                            <button type="reset" class="btn btn-light p-1 waves-light waves-effect btn-block font-24" data-dismiss="modal" ><i class="mdi mdi-block-helper mdi-16px" aria-hidden="true"></i>No</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('plugins-js')
<script type="text/javascript">

    const idioma = {
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
                };

    const localCustom = {
            format: 'DD/MM/YYYY',
            "separator": " hasta ",
            "applyLabel": "Aplicar",
            "cancelLabel": "Cancelar",
            "fromLabel": "DE",
            "toLabel": "HASTA",
            "customRangeLabel": "Custom",
            "daysOfWeek": [
                "Dom",
                "Lun",
                "Mar",
                "Mie",
                "Jue",
                "Vie",
                "Sáb"
            ],
            "monthNames": [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ],
            "firstDay": 1
    };

    $(document).ready(function () {
        $('#table-periodo').DataTable({
            'responsive': true,
            "order": [[ 0, "desc" ]],
            "language": idioma,
            "pagingType": "full_numbers",
            "lengthMenu":		[[5, 10, 20, 25, 50, -1], [5, 10, 20, 25, 50, "Todos"]],
		    "iDisplayLength":	5,
        });
    });

    $('#rangos').daterangepicker({
        locale: localCustom
    },function(start, end, label) {
        var utc= (new Date(start).toUTCString());
        var utcEnd= (new Date(end).toUTCString());
        $('#fecha_inicio').val(new Date(utc).getFullYear() + "-" + (new Date(utc).getMonth() + 1) + "-" + (new Date(utc).getDate()));
        $('#fecha_fin').val(new Date(utcEnd).getFullYear() + "-" + (new Date(utcEnd).getMonth() + 1) + "-" + (new Date(utcEnd).getDate())); 
    });

    function btnEdit(element){
        let id = $(element).data('id');
        let data = getData('GET', `{{ url('admin/periodo') }}/`+id,'#notificacion');
        data.then(function(response){
            $("#registroForm #fecha_inicio").val(response.fecha_inicio);
            $("#registroForm #fecha_fin").val(response.fecha_fin);
            $('#rangos').daterangepicker({
                startDate: moment(response.fecha_inicio).format('DD/MM/YYYY'),
                endDate: moment(response.fecha_fin).format('DD/MM/YYYY'),
                locale: localCustom
            },function(start, end, label) {
                var utc= (new Date(start).toUTCString());
                var utcEnd= (new Date(end).toUTCString());
                $('#fecha_inicio').val(new Date(utc).getFullYear() + "-" + (new Date(utc).getMonth() + 1) + "-" + (new Date(utc).getDate()));
                $('#fecha_fin').val(new Date(utcEnd).getFullYear() + "-" + (new Date(utcEnd).getMonth() + 1) + "-" + (new Date(utcEnd).getDate())); 
            });
            $("#registroForm #observaciones").val(response.observaciones);
            $("#registroForm #ciclo_id").val(response.ciclo_id).change();
            $("#registroForm #tipo").val(response.tipo).change();
            $("#registroForm #_id").val(response.id);
        });
    }

    $('#btnFinalizarPeriodo').on('click', function () {
        
    });

    function fnEliminar(id){
        $("#frmDelete").attr('action', `{{ url("admin/periodo/") }}/`+id);
        let data = getData('GET', `{{ url('admin/periodo/jornadasEliminar') }}/`+id,'#notificacion_eliminar');
        data.then(function(response){
            fnDrwaTable(response, '#tblJornadasEliminar');
        });
    }

    function fnFinalizar(id){
        $("#frmFinalizar").attr('action', `{{ url("admin/periodo/finalizar/") }}/`+id);
        let data = getData('GET', `{{ url('admin/periodo/jornadasFinalizar') }}/`+id,'#notificacion_finalizar');
        data.then(function(response){
            fnDrwaTable(response, '#tblJornadasFinalizar');
        });
    }

    function fnReactivar(id){
        $("#frmReactivar").attr('action', `{{ url("admin/periodo/reactivar/") }}/`+id);
    }


    function fnDrwaTable(data, table){
        let contenido = `
            <div class="float-right mb-3">
                <i class="fa fa-users"></i> Empleados pendientes con la <strong>Jornada</strong> para este periodo: <span class="badge badge-dark"> ${data['pendientes']}</span>
            </div>
            <br>
            <hr>
        `;

        if(data['jornadas'].length>0){

            contenido += `
                <table class="table table-sm table-hover tblJornadas mt-3" style="width: 100%;">
                    <thead>
                        <tr>
                            <th colspan='3' class="text-center">Jornadas en espera de Aprobación</th>
                        </tr>
                        <tr>
                            <th>Empleado</th>
                            <th>Departamento</th>
                            <th>Procedimiento Actual</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            $.each(data['jornadas'], function (indexInArray, item) { 
                contenido +=`
                    <tr>
                        <td>${item.nombre} ${item.apellido}</td>
                        <td>${item.nombre_departamento}</td>
                        <td>${item.procedimiento.charAt(0).toUpperCase() + item.procedimiento.slice(1)}</td>
                    </tr>
                `;
            });

            contenido +=`</tbody></table>`;
            $(table).html(contenido);

            $('.tblJornadas').DataTable({
                "bDestroy": true,
                'responsive': true,
                "order": [[ 0, "desc" ]],
                "language": idioma,
                "pagingType": "full_numbers",
                "lengthMenu":		[[5, 10, 20, 25, 50, -1], [5, 10, 20, 25, 50, "Todos"]],
                "iDisplayLength":	5,
            });

        }else{
            contenido += `<div class="alert alert-primary" role="alert">
                    <strong> <i class="fa fa-exclamation-circle"></i> Información</strong> No existen Jornadas registradas para este <strong>Periodo</strong>
                </div>`;
            $(table).html(contenido);
        }

    }

    </script>
@endsection

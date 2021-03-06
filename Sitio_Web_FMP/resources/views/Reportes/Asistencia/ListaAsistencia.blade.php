@extends('layouts.admin')
@section('content')


<!--Modal para generar la asistencia mensual-->
<div id="AsistenciaMensual" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" 
    aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myCenterModalLabel">
                    <i class=" fa fa-calendar mdi-24px" style="margin: 0px;"></i>  Asistencia Laboral Mensual</h3>
               
            </div>
            <form action="{{ route('Reporte/Asistencia/M') }}" method="POST" id="AsisMensual">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show"
                        role="alert" style="display:none" id="notificacion1">
                    </div>
                    <input type="hidden" name="dui" id="dui">
                    <div class="row py-3">
                        <div class="col-xl-2 fa fa-check text-success fa-3x mr-1"></div>
                        <div class="col-xl-9 text-black"> 
                            <h3 class="font-17 text-justify font-weight-bold">
                                Nota: Para procesar la Asistencia mensual seleccione Año y Mes.
                            </h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 p-1">
                            <label for="mes">Mes</label>
                            <select id="asistencia_mes" name="asistencia_mes" class="form-control select2 asisMen" style="width: 100%" required>
                                <option value="">Seleccione</option>
                               <option value="1">Enero</option>
                               <option value="2">Febrero</option>
                               <option value="3">Marzo</option>
                               <option value="4">Abril</option>
                               <option value="5">Mayo</option>
                               <option value="6">Junio</option>
                               <option value="7">Julio</option>
                               <option value="8">Agosto</option>
                               <option value="9">Septiembre</option>
                               <option value="10">Octubre</option>
                               <option value="11">Noviembre</option>
                               <option value="12">Diciembre</option>
                            </select>
                        </div>
                        <div class="col-xl-6 p-1">
                            <label for="anio">Año</label>
                            <select id="asistencia_anio" name="asistencia_anio" class="form-control select2 asisMen" style="width: 100%" required>
                                <option value="">Seleccione</option>
                                @foreach ($años as $item)
                                    <option value="{{$item->año}}">{{$item->año}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xl-6 p-1">
                            <button  type="submit" 
                                class="btn p-1 btn-light waves-effect waves-light btn-block font-24">
                                <i class="mdi mdi-check mdi-16px"></i>
                                Aceptar
                            </button>
                        </div>
                        <div class="col-xl-6 p-1">
                            <button type="reset" 
                                class="btn btn-light p-1 waves-light waves-effect btn-block font-24" onclick="AsisMenSubmit()">
                                <i class="mdi mdi-block-helper mdi-16px"></i>
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal-->
<!--Modal para generar reporte de la asistencia mensual-->

<!--Modal para generar reporte de impuntualidad-->
<div id="AsistenciasProcesar" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" 
    aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myCenterModalLabel">
                    <i class=" fa fa-calendar mdi-24px" style="margin: 0px;"></i>  Asistencia Laboral</h3>
               
            </div>
            <form action="{{ route('Reporte/Asistencia') }}" method="POST" id="AsisModal">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show"
                        role="alert" style="display:none" id="notificacion1">
                    </div>
                    <input type="hidden" name="_id" id="_id">
                    <div class="row py-3">
                        <div class="col-xl-2 fa fa-check text-primary fa-3x mr-1"></div>
                        <div class="col-xl-9 text-black"> 
                            <h3 class="font-17 text-justify font-weight-bold">
                                Nota: Para procesar la Asistencia seleccione Año y Mes.
                            </h3>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-xl-6 p-1">
                            <label for="mes">Mes</label>
                            <select id="asis_mes_2" name="asis_mes" class="form-control select2 asis" style="width: 100%" required>
                                <option value="">Seleccione</option>
                               <option value="1">Enero</option>
                               <option value="2">Febrero</option>
                               <option value="3">Marzo</option>
                               <option value="4">Abril</option>
                               <option value="5">Mayo</option>
                               <option value="6">Junio</option>
                               <option value="7">Julio</option>
                               <option value="8">Agosto</option>
                               <option value="9">Septiembre</option>
                               <option value="10">Octubre</option>
                               <option value="11">Noviembre</option>
                               <option value="12">Diciembre</option>
                            </select>
                        </div>
                        <div class="col-xl-6 p-1">
                            <label for="anio">Año</label>
                            <select id="asis_anio_2" name="asis_anio" class="form-control select2 asis" style="width: 100%" required>
                                <option value="">Seleccione</option>
                                @foreach ($años as $item)
                                    <option value="{{$item->año}}">{{$item->año}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xl-6 p-1">
                            <button  type="submit" 
                                class="btn p-1 btn-light waves-effect waves-light btn-block font-24">
                                <i class="mdi mdi-check mdi-16px"></i>
                                Aceptar
                            </button>
                        </div>
                        <div class="col-xl-6 p-1">
                            <button type="reset" 
                                class="btn btn-light p-1 waves-light waves-effect btn-block font-24" onclick="AsisSubmit()">
                                <i class="mdi mdi-block-helper mdi-16px"></i>
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal-->
<!--Modal para generar reporte de impuntualidad-->

<!--Modal para generar reporte de impuntualidad-->
<div id="modalDescuento" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" 
    aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myCenterModalLabel">
                    <i class=" fa fa-calculator mdi-24px" style="margin: 0px;"></i> Descuento</h3>
               
            </div>
            <form id="graciaForm" action="{{ route('Descuento/Personal') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show"
                        role="alert" style="display:none" id="notificacionGracia">
                    </div>
                    <input type="hidden" name="_id_des" id="_id_des">
                    <div class="row py-3">
                        <div class="col-xl-2 fa fa-check text-danger fa-3x mr-1"></div>
                        <div class="col-xl-9 text-black"> 
                            <h3 class="font-17 text-justify font-weight-bold">
                                Nota: Para procesar el descuento debe seleccionar el mes y año.
                            </h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 p-1">
                            <label for="mes">Mes</label>
                            <select id="des_mes" name="des_mes" class="form-control select2 des" style="width: 100%" required>
                                <option value="">Seleccione</option>
                               <option value="1">Enero</option>
                               <option value="2">Febrero</option>
                               <option value="3">Marzo</option>
                               <option value="4">Abril</option>
                               <option value="5">Mayo</option>
                               <option value="6">Junio</option>
                               <option value="7">Julio</option>
                               <option value="8">Agosto</option>
                               <option value="9">Septiembre</option>
                               <option value="10">Octubre</option>
                               <option value="11">Noviembre</option>
                               <option value="12">Diciembre</option>
                            </select>
                        </div>
                        <div class="col-xl-6 p-1">
                            <label for="anio">Año</label>
                            <select id="des_anio" name="des_anio" class="form-control select2 des" style="width: 100%" required>
                                <option value="">Seleccione</option>
                                @foreach ($años as $item)
                                    <option value="{{$item->año}}">{{$item->año}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xl-6 p-1">
                            <button  type="submit" 
                                class="btn p-1 btn-light waves-effect waves-light btn-block font-24"
                                >
                                <i class="mdi mdi-check mdi-16px"></i>
                                Aceptar
                            </button>
                        </div>
                        <div class="col-xl-6 p-1">
                            <button type="reset" 
                                class="btn btn-light p-1 waves-light waves-effect btn-block font-24" onclick="DesSubmit()" >
                                <i class="mdi mdi-block-helper mdi-16px" ></i>
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal-->
<!--Modal para generar reporte de impuntualidad-->

<!--MODAL PARA GENERAR DESCUENTOS-->
<div id="modalDescuentos" class="modal fade bs-example-modal-sm" role="dialog" 
    aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myCenterModalLabel">
                    <i class="fa fa-calculator mdi-36px" style="margin: 0px;"></i>  Descuentos</h3>
                
            </div>
            <form action="{{ route('Descuento/PDF') }}" method="POST" id="TodosForm">    
                @csrf       
                <div class="modal-body"> 
                    <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show"
                        role="alert" style="display:none" id="notificacionExcel">
                    </div>           
                  
                    <div class="row"> 
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="depto">Departamento</label>
                                <select name="id_depto" class="form-control select2 todos_select" style="width: 100%" required>
                                   <option value="" selected>Seleccione</option>
                                    @foreach ($departamentos as $item)
                                        <option value="{{$item->id}}">{{$item->nombre_departamento}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="anio">Año</label>
                                <select name="anio" class="form-control select2 todos_select" style="width: 100%" required>
                                   <option value="" selected>Seleccione</option>
                                    @foreach ($años as $item)
                                        <option value="{{$item->año}}">{{$item->año}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">                    
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="mes">Mes</label>
                                <select name="mes" class="form-control select2 todos_select" style="width: 100%" required>
                                   <option value="" selected>Seleccione</option>
                                   <option value="1">Enero</option>
                                   <option value="2">Febrero</option>
                                   <option value="3">Marzo</option>
                                   <option value="4">Abril</option>
                                   <option value="5">Mayo</option>
                                   <option value="6">Junio</option>
                                   <option value="7">Julio</option>
                                   <option value="8">Agosto</option>
                                   <option value="9">Septiembre</option>
                                   <option value="10">Octubre</option>
                                   <option value="11">Noviembre</option>
                                   <option value="12">Diciembre</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn p-1 btn-light waves-effect waves-light btn-block font-20 btn-block"  id="generar" > 
                        <li class="fa fa-calculator"></li> Generar
                    </button><br>
                    <button type="reset" class="btn p-1 btn-light waves-effect waves-light btn-block font-20 btn-block" onclick="CancelSubmit()"> 
                        <li class="fa fa-ban"></li> Cancelar
                    </button>
                </div>   
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!--FIN DE MODAL PARA GENERAR DESCUENTOS-->



<div class="row">
    <div class="col-xl-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Inicio</a></li>
                    <li class="breadcrumb-item active">Lista de Empleados</li>
                </ol>
            </div>
            <h4 class="page-title">&nbsp;</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card-box">
            <div class="row py-2">
                <div class="col-lg-10 order-first">
                    <h3>
                        Lista de Empleados Asistencia Mensual
                    </h3>
                    <div class="row my-1">
                        <div class="col-xl-4">
                            <label for="depto">Departamento</label>
                            <select id="rrhh_depto" class="form-control select2" style="width: 100%" required>
                                <option value="todos">Todos</option>
                               @foreach ($departamentos as $item)
                                    <option value="{{$item->id}}">{{$item->nombre_departamento}}</option>
                                @endforeach
                            </select>
                        </div>                       
                    </div> 
                </div>

                <div class="col-lg-2 text-right order-last">
                    <div class="btn-group" role="group">
                        <button title="Generar Descuentos" type="button" id="btnDescuentos" class="btn btn-danger"><i class="fa fa-calculator"></i></button>
                    </div>  
                </div> 
                
            </div>
            <table id="asistenciaLaboral" class="table" style="width: 100%;">
                <thead>
                <tr>
                    <th data-priority="1" class="col-sm-1">#</th>
                    <th data-priority="3">Nombre</th>
                    <th data-priority="3" class="col-sm-1 text-center">Categoria</th>
                    <th data-priority="3" class="col-sm-1 text-center">Contrato</th>
                    <th data-priority="3" class="col-sm-2 text-center">Jornada</th>
                    <th data-priority="3" class="col-sm-2 text-center">Departamento</th>
                    <th data-priority="1" class="col-sm-1 text-center">Acciones</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>    
              
                </tbody>
            </table>

        </div> <!-- end card-box -->
    </div> <!-- end col -->
</div>

@endsection


@section('plugins')
<link href="{{ asset('template-admin/dist/assets/libs/select2/select2.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('template-admin/dist/assets/libs/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet"/>

@endsection

@section('plugins-js')
<script src="{{ asset('template-admin/dist/assets/libs/bootstrap-select/bootstrap-select.min.js') }}" ></script>
<script src="{{ asset('template-admin/dist/assets/libs/select2/select2.min.js') }}" ></script>


<script src="{{ asset('js/scripts/configuracion.js')}}"></script>
<script src="{{ asset('js/licencias/asistencia.js') }}"></script>
<script src="{{ asset('js/licencias/http.js')}}"></script>


<script>
    $(
        function() {
            $('.select2').select2();
        });
</script>

@endsection

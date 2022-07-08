@extends('layouts.admin')
@section('content')




<!--MODAL PARA GENERAR DESCUENTOS-->
<div id="impuntualidad" class="modal fade bs-example-modal-sm" role="dialog" 
    aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myCenterModalLabel">
                    <i class="fa fa-calculator mdi-36px" style="margin: 0px;"></i>  Descuentos</h3>
                
            </div>
            <form action="{{ route('Reporte/Asistencia') }}" method="POST" id="Impuntual">    
                @csrf       
                <div class="modal-body"> 
                    <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show"
                        role="alert" style="display:none" id="notificacionExcel">
                    </div>           
                  
                   
                    <div class="row">                    
                        <div class="col-xl-12">
                            <input type="hidden" value="{{auth()->user()->empleado }}" name="_id">
                            <div class="form-group">
                                <label for="mes">Mes</label>
                                <select name="asis_mes" class="form-control select2 impu" style="width: 100%" required>
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

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="anio">Año</label>
                                <select name="asis_anio" class="form-control select2 impu" style="width: 100%" required>
                                   <option value="" selected>Seleccione</option>
                                    @foreach ($años as $item)
                                        <option value="{{$item->año}}">{{$item->año}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn p-1 btn-light waves-effect waves-light btn-block font-20 btn-block"  id="generar" > 
                        <li class="fa fa-calculator"></li> Generar
                    </button><br>
                    <button type="reset" class="btn p-1 btn-light waves-effect waves-light btn-block font-20 btn-block" onclick="AsisSubmit()"> 
                        <li class="fa fa-ban"></li> Cancelar
                    </button>
                </div>   
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!--FIN DE MODAL PARA GENERAR DESCUENTOS-->


<!--MODAL PARA GENERAR DESCUENTOS-->
<div id="AsistenciasProcesar" class="modal fade bs-example-modal-sm" role="dialog" 
    aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myCenterModalLabel">
                    <i class="fa fa-calculator mdi-36px" style="margin: 0px;"></i>  Descuentos</h3>
                
            </div>
            <form action="{{ route('Reporte/Asistencia/M') }}" method="POST" id="AsisModal">    
                @csrf       
                <div class="modal-body"> 
                    <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show"
                        role="alert" style="display:none" id="notificacionExcel">
                    </div>           
                  
                   
                    <div class="row">                    
                        <div class="col-xl-12">
                            <input type="hidden" value="{{auth()->user()->dui }}" name="dui">
                            <div class="form-group">
                                <label for="mes">Mes</label>
                                <select name="asis_mes_2" class="form-control select2 asis" style="width: 100%" required>
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

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="anio">Año</label>
                                <select name="asis_anio_2" class="form-control select2 asis" style="width: 100%" required>
                                   <option value="" selected>Seleccione</option>
                                    @foreach ($años as $item)
                                        <option value="{{$item->año}}">{{$item->año}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn p-1 btn-light waves-effect waves-light btn-block font-20 btn-block"  id="generar" > 
                        <li class="fa fa-calculator"></li> Generar
                    </button><br>
                    <button type="reset" class="btn p-1 btn-light waves-effect waves-light btn-block font-20 btn-block" onclick="AsisSubmit()"> 
                        <li class="fa fa-ban"></li> Cancelar
                    </button>
                </div>   
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!--FIN DE MODAL PARA GENERAR DESCUENTOS-->



<!--MODAL PARA GENERAR DESCUENTOS-->
<div id="modalDescuentos" class="modal fade bs-example-modal-sm" role="dialog" 
    aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myCenterModalLabel">
                    <i class="fa fa-calculator mdi-36px" style="margin: 0px;"></i>  Descuentos</h3>
                
            </div>
            <form action="{{ route('Descuento/Personal') }}" method="POST" id="TodosForm">    
                @csrf       
                <div class="modal-body"> 
                    <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show"
                        role="alert" style="display:none" id="notificacionExcel">
                    </div>           
                  
                   
                    <div class="row">                    
                        <div class="col-xl-12">
                            <input type="hidden" value="{{auth()->user()->empleado }}" name="_id_des">
                            <div class="form-group">
                                <label for="mes">Mes</label>
                                <select name="des_mes" class="form-control select2 todos_select" style="width: 100%" required>
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

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="anio">Año</label>
                                <select name="des_anio" class="form-control select2 todos_select" style="width: 100%" required>
                                   <option value="" selected>Seleccione</option>
                                    @foreach ($años as $item)
                                        <option value="{{$item->año}}">{{$item->año}}</option>
                                    @endforeach
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
                    <li class="breadcrumb-item active">Registros de Asistencia Mensual</li>
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
                        Registro de Asistencia Mensual
                    </h3>
                    <div class="row my-1">
                        <div class="col-xl-4">
                            <label for="depto">Mes</label>
                            <select id="mes_select" class="form-control select2" style="width: 100%" required>
                                <option value="0">Seleccione</option>
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

                        <div class="col-xl-4">
                            <label for="depto">Año</label>
                            <select id="anio_select" class="form-control select2" style="width: 100%" required>
                                <option value="0">Seleccione</option>
                               @foreach ($años as $item)
                                    <option value="{{$item->año}}">{{$item->año}}</option>
                                @endforeach
                            </select>
                        </div>
                                               
                    </div> 
                </div>

                <div class="col-lg-2 text-right order-last">
                    <div class="btn-group" role="group">
                        <button title="Generar Asistencia" type="button" id="btnAsistencia" class="btn btn-success"><i class="fa fa-print"></i></button>
                      </div> 
                    <div class="btn-group" role="group">
                        <button title="Generar Impuntualidad" type="button" id="btnImpuntualidad" class="btn btn-primary"><i class="fa fa-bell"></i></button>
                      </div> 
                    <div class="btn-group" role="group">
                      <button title="Generar Descuentos" type="button" id="btnDescuento" class="btn btn-danger"><i class="fa fa-calculator"></i></button>
                    </div>  
                </div> 
                
            </div>
            <table id="EmpleadoAsistencia" class="table" style="width: 100%;">
                <thead>
                
                    <tr>
                        <th style="text-align">Fecha</th>
                        <th style="text-align">Dia</th>
                        <th style="text-align">Hora Entrada</th>
                        <th style="text-align">Hora Salida</th>
                        <th style="text-align">Estado</th>

        
                    </tr>
                
                </thead>
                <tbody>
                   
              
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
<script src="{{ asset('js/ReportesJs/tablaAsistenciaEmpleado.js') }}"></script>
<script src="{{ asset('js/licencias/http.js')}}"></script>


<script>
    $(
        function() {
            $('.select2').select2();
        });
</script>

@endsection

@extends('layouts.admin')

@section('content')
@if (!is_null(auth()->user()->empleado))
<!-- inicio Modal de registro -->
<div class="modal fade bs-example-modal-lg" 
    role="dialog" aria-labelledby="myLargeModalLabel" 
    id="modalRegistro" tabindex="-1">
    <div class="modal-dialog modal-lg-8" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id=" exampleModalLongTitle"><i class="icon-notebook mdi-36px"></i> Const. Olvido de Marcaje</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="registroForm"  action="{{ route('olvido/create') }}" method="POST">
            @csrf
            
            <div class="modal-body">
                <input type="hidden" id="idPermiso" name="_id"/>
                <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show"
                    role="alert" style="display:none" id="notificacion">
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label>Nota: <code>* Campos Obligatorio</code></label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="">Nombre <code>*</code></label>
                            <input type="text" class="form-control" value="{{$logueado->nombre}}"  
                            autocomplete="off" placeholder="Digite el nombre" readonly>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="">Apellido <code>*</code></label>
                            <input type="text" class="form-control" value="{{$logueado->apellido}}"
                             autocomplete="off" placeholder="Digite el correo" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!--para el campo fecha-->
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="fecha_de_uso">Fecha<code>*</code></label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                </div>
                                <input type="date" name="fecha" class="form-control"
                                    tyle="width: 100%;"  id="fecha" >
                            </div>
                        </div>                            
                    </div>
                    <!--fin del campo fecha-->
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="exampleInputNombre">Marcaje de:<code>*</code></label>
                            <select class="form-control select2" style="width: 100%" data-live-search="true" 
                                data-style="btn-white"   id="marcaje" name="marcaje">
                                <option value="">Seleccione</option>
                                <option value="Entrada">Entrada</option>
                                <option value="Salida">Salida</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label for="fecha_de_presentacion">Hora <code>*</code></label> 
                            <div class="input-group">
                                <div class="input-group-append" style="width: 100%;">
                                    <span class="input-group-text"><i class=" mdi mdi-account-clock "></i></span>
                                    <input type="time" name="hora" class="form-control"
                                        style="width: 100%;"  id="hora" readonly >
                                </div>
                            </div>                           
                        </div>
                    </div>
                </div>
              
                <div class="row">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label for="exampleInputNombre">Justificación<code>*</code></label>
                            <textarea value=" " class="form-control summernote-config" 
                                name="justificación" id="justificacion" rows="6"></textarea>
                                <input type="hidden" value="Guardado" name="estadoConstancia" id="estadoConstancia">
                        </div> 
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-dismiss="modal"><i class="fa fa-ban"
                    aria-hidden="true"></i> Cerrar</button>
                <button type="button" class="btn btn-primary" id='guardar_registro'
                    onClick="submitForm('#registroForm','#notificacion')">
                    <li class="fa fa-save"></li> Guardar</button>
            </div>
            
        </form>
      </div>
    </div>
</div>
<!--fin modal de registro-->

<!--modal para dar alta-->
<div id="modalCancelar" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" 
    aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myCenterModalLabel">
                    <i class="fa fa-ban mdi-24px" style="margin: 0px;"></i> Cancelar</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ route('olvido/cancel') }}" method="POST" id="cancelarModal">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show"
                        role="alert" style="display:none" id="notificacion1">
                    </div>
                    <input type="hidden" name="_id" id="cancelar_id">
                    <div class="row py-3">
                        <div class="col-xl-2 fa fa-exclamation-triangle text-warning fa-4x mr-1"></div>
                        <div class="col-xl-9 text-black"> 
                            <h4 class="font-17 text-justify font-weight-bold">
                                Advertencia: Se cancelara esta Const. olvido de marcaje, ¿Desea continuar?
                            </h4>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xl-6 p-1">
                            <button  type="submit" 
                                class="btn p-1 btn-light waves-effect waves-light btn-block font-24">
                                <i class="mdi mdi-check mdi-16px"></i>
                                Si
                            </button>
                        </div>
                        <div class="col-xl-6 p-1">
                            <button type="reset" 
                                class="btn btn-light p-1 waves-light waves-effect btn-block font-24" 
                                data-dismiss="modal" >
                                <i class="mdi mdi-block-helper mdi-16px" aria-hidden="true"></i>
                                No
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal-->
<!--Modal para dar alta fin-->

<!--MODAL ENVIAR-->
<div id="modalEnviar" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" 
    aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myCenterModalLabel">
                    <i class="dripicons-information  mdi-24px" style="margin: 0px;"></i> Cancelar</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ route('lic/enviar') }}" method="POST" id="enviarForm">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show"
                        role="alert" style="display:none" id="notificacion1">
                    </div>
                    <input type="hidden" name="_id" id="enviar_id">
                    <div class="row py-3 align-center">
                        <div class="col-xl-2 dripicons-information text-info fa-4x mr-1"></div>
                        <div class="col-xl-9 text-black"> 
                            <h4 class="font-17 text-justify font-weight-bold">
                                Advertencia: Se enviara la Const. olvido de Marcaje,
                            </h4>
                            <h4 class="font-17 text-justify font-weight-bold">
                                ¿Desea continuar?
                            </h4>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xl-6 p-1">
                            <button  type="button"  onClick="submitForm('#enviarForm','#notificacion1')"
                                class="btn p-1 btn-light waves-effect waves-light btn-block font-24">
                                <i class="mdi mdi-check mdi-16px"></i>
                                Si
                            </button>
                        </div>
                        <div class="col-xl-6 p-1">
                            <button type="reset" 
                                class="btn btn-light p-1 waves-light waves-effect btn-block font-24" 
                                data-dismiss="modal" >
                                <i class="mdi mdi-block-helper mdi-16px" aria-hidden="true"></i>
                                No
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!--MODAL ENVIAR FIN-->
<div id="modalObservaciones" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" 
    aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myCenterModalLabel">
                    <i class="fa fa-eye mdi-36px" style="margin: 0px;"></i> Observaciones</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>           
            <div class="modal-body">
               
                    <table class="table" style="width: 100%" id="obs-table"> 
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Procedimiento</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                    </table>
                
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- start page title -->
<div class="row">
    <div class="col-xl-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Inicio</a></li>
                    <li class="breadcrumb-item active">Const. Olvido de Marcaje</li>
                </ol>
            </div>
            <h4 class="page-title">&nbsp;</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        
        <div class="card-box">
           
            <div class="row py-2">
                <div class="col order-first">
                    <h3>
                        Constancia Olvido de Marcaje
                    </h3>
                </div>
                <div class="col-lg-1 order-last">
                    <!-- Button trigger modal -->
                 <button type="button" title="Agregar Licencia"
                    class="btn btn-primary dripicons-plus"
                    data-toggle="modal" data-target="#modalRegistro"></button>
                </div>                
            </div>
            
            <table  class="table" style="width: 100%" id="Lic-table">
                <thead>
                <tr>
                    <th class="col-sm-2">Fecha</th>
                    <th class="col-sm-2">Marcaje</th>
                    <th class="col-sm-2">Hora de olvido</th>
                    <th class="col-sm-2">Estado</th>
                    <th class="col-sm-1">Acciones</th>
                </tr>
                </thead>
              
                <tbody>
                    
                    @foreach ($data as $item)
                        <tr>
                            <th class="align-middle ">{{Carbon\Carbon::parse($item->fecha_uso)->format('d/M/Y')}}</th>
                            <td class="align-middle "> <span class="badge badge-success font-13">{{$item->olvido}}</span></td>
                            <td class="align-middle ">{{date('H:i', strtotime($item->hora_inicio))}}</td>
                            <td class="align-middle">
                                @if($item->estado =='Guardado') 
                                    <span class="badge badge-primary font-13">{{$item->estado}}</span>
                                @endif
                                @if($item->estado =='Cancelado') 
                                    <span class="badge badge-danger font-13">{{$item->estado}}</span>
                                @endif
                                @if ($item->estado =='Enviado a Jefatura' or $item->estado =='Enviado a RRHH')
                                    <span class="badge badge-primary font-13">{{$item->estado}}</span>
                                @endif
                                @if ($item->estado =='Observaciones de RRHH' or $item->estado =='Observaciones de Jefatura')
                                    <span class="badge badge-danger font-13">{{$item->estado}}</span>
                                @endif
                                @if ($item->estado =='Aceptado por Jefatura' or $item->estado =='Aceptado')
                                    <span class="badge badge-success font-13">{{$item->estado}}</span>
                                @endif                        
                            </td>
                            <td class="align-middle ">
                                <div class="row">
                                    <div class="col text-center">
                                        @php
                                            $todos_btn = $item->estado == 'Guardado' ||
                                            $item->estado == 'Observaciones de RRHH' || 
                                            $item->estado == 'Observaciones de Jefatura';
                                        @endphp
                                        <div class="btn-group" role="group">
                                            <button title="Observaciones" class="btn btn-outline-primary btn-sm rounded-left" 
                                            @if ($item->estado =='CANCELADO')
                                                disabled
                                            @else
                                              value="{{$item->identificador}}" 
                                              onclick="observaciones(this)"
                                            @endif>
                                                <i class="fa fa-eye font-16 my-1" aria-hidden="true"></i>
                                            </button>
                                            <button title="Enviar" class="btn btn-outline-primary btn-sm" 
                                            @if($todos_btn)
                                                value="{{$item->identificador}}"
                                                 onclick="enviar(this)"
                                                 @else disabled
                                                 @endif>                                                
                                                <i class="fa fa-arrow-circle-up font-16 my-1" aria-hidden="true"></i>
                                            </button>
                                            <button title="Editar" 
                                            class="btn btn-outline-primary btn-sm border-letf-0"  
                                            @if($todos_btn)
                                                 value="{{$item->identificador}}"
                                                onclick="editar(this)"
                                                @else
                                                disabled
                                                @endif>
                                                <i class="fa fa-edit font-16 my-1" aria-hidden="true"></i>
                                            </button>
                                            <button title="Cancelar" 
                                                class="btn btn-outline-primary btn-sm border-left-0 btn-outline-danger rounded-right"
                                            @if(
                                                $item->estado =='Aceptado' || $item->estado=='Enviado a Jefatura' || $item->estado=='Enviado a RRHH')
                                               disabled
                                               @else
                                               onclick="cancelar(this)"
                                                value="{{$item->identificador}}"
                                               @endif>
                                                <i class="fa fa-times font-16 my-1"></i>
                                            </button>                                   
                                        </div>
                                    </div>
                                </div>
                            </td>  
                        </tr>
                    @endforeach 
                    
                               
                </tbody>
            </table>
            

        </div> <!-- end card-box -->
    </div> <!-- end col -->
</div>
<!-- end row -->

@else
    <div class="row m-3">
        <div class="col-xl-12">
            <div class="card-box p-2 border">
                <p> <i class="fa fa-info-circle"></i> No es posible cargar la información perteneciente a <strong> {{auth()->user()->name}} </strong>.</p>
                <label> A continuación se detallan las posibles causas: </label>
                <ul>
                    <li>El Usuario no se encuentra vinculado con ningun <strong>Empleado</strong> registrado en el sistema.</li>
                </ul>
            </div>
        </div>
    </div>
@endif
@endsection

@section('plugins')
<link href="{{ asset('template-admin/dist/assets/libs/select2/select2.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('template-admin/dist/assets/libs/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('template-admin/dist/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet"/>
<style>

</style>
@endsection

@section('plugins-js')
    <!-- Bootstrap Select -->
    <script src="{{ asset('template-admin/dist/assets/libs/bootstrap-select/bootstrap-select.min.js') }}" ></script>
    <script src="{{ asset('template-admin/dist/assets/libs/select2/select2.min.js') }}" ></script>
    <script src="{{ asset('template-admin/dist/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js') }}" ></script>
    <script src="{{ asset('js/scripts/data-table.js') }}" ></script>
    <script src="{{ asset('js/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('vendor/summernote/lang/summernote-es-ES.js') }}"></script>
    <script src="{{ asset('template-admin/dist/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/scripts/configuracion.js') }}" ></script>
    <script src="{{ asset('js/constancia/constaciaOlvido.js') }}" ></script>
    <script src="{{ asset('js/constancia/constanciaTable.js')}}"></script>
 
@endsection

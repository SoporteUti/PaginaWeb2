@extends('layouts.admin')
@section('content')
<!-- inicio Modal de registro -->
<div class="modal fade bs-example-modal-lg" role="dialog" 
    aria-labelledby="myLargeModalLabel"   id="modalRegistro" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id=" exampleModalLongTitle"><i class=" mdi mdi-account-badge-horizontal mdi-36px"></i> Empleado</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="registroForm"  action="{{ route('EmpleadoReg') }}" method="POST">
            @csrf
            <div class="modal-body">
                <input type="hidden" id="idE" name="_id" value=""/>
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
                            <label for="fileE">Foto <code>*</code></label>
                            <label for="fileE" class="text-center">
                                <img  class="rounded img-fluid img-thumbnail" id="fotoE" >
                            </label>                            
                        </div>
                        <div class="form-group text-center">
                            <label for="fileE" class="centrado text-black"><i class="mdi mdi-mouse font-20"></i> Click para subir foto</label>
                            <input type="file" id="fileE" name="foto" accept="image/*">
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="nombreE">Nombre <code>*</code></label>
                            <input type="text" class="form-control" id='nombreE' name="nombre"  autocomplete="off" placeholder="Digite el nombre">
                        </div>
                        <div class="form-group">
                            <label for="apellidoE">Apellido <code>*</code></label>
                            <input type="text" class="form-control" id="apellidoE" name="apellido"  autocomplete="off" placeholder="Digite el apellido">
                        </div>
                        <div class="form-group">
                            <label for="duiE">DUI <code>*</code></label>
                            <input type="text" class="form-control" name="dui" id="duiE" placeholder="00000000-0" 
                                data-mask="00000000-0">
                        </div>
                        <div class="form-group">
                            <label for="nitE">NIT</label>
                            <input type="text" class="form-control" name="nit" id="nitE" data-mask="0000-000000-000-0" 
                            placeholder="0000-000000-000-0">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="">Teléfono </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="mdi mdi-phone-classic"></i></span>
                                </div>
                                <input type="tel" class="form-control" id="telE" name="telefono" data-mask="0000-0000"
                                placeholder="0000-0000">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="salarioE">Salario <code>*</code></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><strong>$</strong></span>
                                </div>
                                <input type="text" name="salario" id="salarioE" class="form-control" placeholder="00.00">
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="Departamento">Tipo Contrato <code>*</code></label>
                            <select  style="width: 100%;" class="form-group select2" data-live-search="false" data-style="btn-white"
                                    id="tipo_contratoE" name="tipo_contrato">
                            <option value="" selected>Seleccione</option>
                            @foreach ($tcontrato as $contrato)
                                <option value="{!!$contrato->id!!}">{!!$contrato->tipo!!}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="Departamento">Tipo Jornada <code>*</code></label>
                            <select  class=" form-group select2" style="width: 100%;" data-live-search="true" 
                                id="tipo_jornadaE" name="tipo_jornada">
                                <option value="" selected>Seleccione</option>
                                @foreach ($tjornada as $jornada)
                                    <option value="{!!$jornada->id!!}">{!!$jornada->tipo!!} - {!!$jornada->horas_semanales!!} horas</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="Departamento">Departamento <code>*</code></label>
                            <select style="width: 100%;" class="form-group select2" data-live-search="true" data-style="btn-white"
                                id="deptoE" name="departamento">
                                <option value="" selected>Seleccione</option>
                                @foreach ($departamentos as $depto)
                                    <option value="{!!$depto->id!!}">{!!$depto->nombre_departamento!!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="Departamento">Tipo Empleado <code>*</code></label>
                            <select style="width: 100%;" class="form-group select2" data-live-search="true"
                                id="tipo_empleadoE" name="tipo_empleado">
                                <option name="" value="" selected>Seleccione</option>
                                <option value="Administrativo">Administrativo</option>
                                <option value="Académico">Académico</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="categoriaE">Categoria <code>*</code></label>
                            <select class="select2 form-group" id="categoriaE"
                                data-live-search="true" style="width: 100%;" name="categoria">
                                <option value="" selected>Seleccione</option>
                                @foreach ($categorias as $item)
                                <option value="{!!$item->id!!}">{!!$item->categoria!!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="Departamento">Jefes y Empleados </label>
                            <select class="select2 form-group " data-live-search="true"  data-style="btn-white"
                                id="jefe_empleadoE" name="jefe" style="width: 100%;">
                                <option name="" value="">Seleccione</option>
                                @foreach ($empleados as $item)
                                    <option name="{!!$item->id!!}" value="{!!$item->id!!}" id="jefe_empleadoE_option{!!$item->id!!}">{!!$item->nombre.' '.$item->apellido!!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-dismiss="modal"><i class="fa fa-ban"
                    aria-hidden="true"></i> Cerrar</button>
                <button type="button" class="btn btn-primary"
                    onClick="submitForm('#registroForm','#notificacion')">
                    <li class="fa fa-save"></li> Guardar
                </button>
            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg"
    role="dialog" aria-labelledby="myLargeModalLabel"
    id="modalCategoria"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id=" exampleModalLongTitle"><i class="dripicons-briefcase  mdi-36px"></i> Categoria</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
            <div class="modal-body">
                <div class="alert alert-primary alert-dismissible bg-danger text-white border-0 fade show"
                        role="alert" style="display:none" id="notificacionCat">
                </div>
                <div class="alert  alert-primary alert-dismissible bg-danger  border-0 fade show"
                    role="alert" id="notificacionEliminar" style="display:none" >
                    <div class="row">
                        <div class="col-lg-10 order-firts">
                            <h4 class="text-white">El elemento de eliminara de nuestros registros, ¿continuar?.</h4>
                            <form action="{{ route('empleadoCatDest') }}" method="POST" id="eliminarCatForm">
                                @csrf
                                <input type="hidden" name="_id" id="idCat">
                                <div class="row">
                                    <div class="col-xl-6 p-1">
                                        <button  type="button" onclick="$('.alert').hide();
                                        httpCategoria('#eliminarCatForm','#notificacionCat');"
                                            class="btn my-1 mr-1 btn-danger border rounded waves-effect waves-light btn-block font-24">
                                            <i class="mdi mdi-check mdi-16px"></i>
                                            Si
                                        </button>
                                    </div>
                                    <div class="col-xl-6 p-1">
                                        <button type="button" onclick="$('.alert').hide();"
                                            class="btn my-1 btn-danger p-1 border rounded waves-light waves-effect btn-block font-24">
                                            <i class="mdi mdi-block-helper mdi-16px" aria-hidden="true"></i>
                                            No
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-2 order-last text-center text-white">
                            <li class="fa fa-exclamation-triangle fa-6x"></li>
                        </div>
                    </div>
                </div>
                <form action="{{ route('empleadoCatReg') }}" id="empleadoCatReg"
                    method="POST" class="px-3">
                    @csrf
                    <input type="hidden" id="_idCat" name="_id"/>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Nota: <code>* Campos Obligatorio</code></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-10">
                            <div class="form-group">
                                <label for="">Categoria <code>*</code></label>
                                <input type="text" class="form-control" id="categoria" name="categoria" placeholder="Digite la categoria">
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="form-group">
                                <label for="">&nbsp;</label>
                                <button type="button" class="btn btn-primary form-control" id="guardadCat"
                                    onClick="httpCategoria('#empleadoCatReg','#notificacionCat')">
                                    <li class="fa fa-save"></li> Guardar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="p-3 container-fluid">
                    <table class="table " style="width: 100%" id="categoriaTb">
                        <thead>
                            <tr>
                                <th class="col-sm-1">#</th>
                                <th>Categoria</th>
                                <th class="col-xl-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="catbody">
                            @php
                                $i=0;
                            @endphp
                            @foreach ($categorias as $item)
                                @php
                                    $i++;
                                @endphp
                                <tr>
                                    <td class="col-sm-1">{{$i}}</td>
                                    <td>{!!$item->categoria!!}</td>
                                    <td class="col-xl-2">
                                        <div class="btn-group text-center" role="group">
                                            <button onclick="editarCat({!!$item->id!!},this);"
                                                title="Editar" class="btn btn-outline-primary mr-1 btn-sm rounded">
                                                <i class="fa fa-edit font-15" aria-hidden="true"></i>
                                            </button>
                                            <button title="Eliminar" class="btn btn-outline-danger btn-sm rounded"
                                                onclick="eliminarCat({!!$item->id!!});">
                                                <i class=" mdi mdi-trash-can-outline font-18" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-dismiss="modal"><i class="fa fa-ban"
                    aria-hidden="true"></i> Cerrar</button>
            </div>
      </div>
    </div>
</div>
<!--fin modal de registro-->

<!--modal para dar alta-->
<div id="modalAlta" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" 
    aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myCenterModalLabel">
                    <i class="mdi mdi-arrow-up-bold  mdi-24px" style="margin: none; padding: none;"></i>
                    <i class="mdi-arrow-down-bold mdi mdi-24px" style="margin: 0px;"></i> Dar Baja/Alta</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ route('empEstado') }}" method="POST" id="altaBajaForm">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show"
                        role="alert" style="display:none" id="notificacion1">
                    </div>
                    <input type="hidden" name="_id" id="activarId">
                    <div class="row py-3">
                        <div class="col-xl-2 fa fa-exclamation-triangle text-warning fa-4x mr-1"></div>
                        <div class="col-xl-9 text-black"> 
                            <h4 class="font-17 text-justify font-weight-bold">
                                Advertencia: Se dara de alta/baja este usuario, ¿Desea continuar?
                            </h4>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xl-6 p-1">
                            <button  type="button" onclick="submitForm('#altaBajaForm','#notificacion1')"
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
</div><!-- /.modal -->
<!--Modal para dar alta fin-->

<div class="row">
    <div class="col-xl-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Inicio</a></li>
                    <li class="breadcrumb-item active">Empleados</li>
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
                        Empleados
                    </h3>
                </div>
                <div class="col-lg-2 order-last text-right">
                    <!-- Button trigger modal -->
                    <div class="btn-group" role="group">
                        <button type="button" title="Agregar Categoria"
                            class="btn dripicons-briefcase btn-success mr-1 rounded font-18" onclick="$('#categoriaTb').trigger('processing.dt');$('#modalCategoria').modal();">
                        </button>
                        <button type="button" title="Agregar Empleado"
                            class="btn btn-primary dripicons-plus rounded"
                            data-toggle="modal" data-target="#modalRegistro">
                        </button>
                    </div>
                </div>
            </div>
            <table class="table" style="width: 100%;">
                <thead>
                <tr>
                    <th data-priority="1" class="col-sm-1">#</th>
                    <th data-priority="3">Nombre</th>
                    <th data-priority="3" class="col-sm-1 text-center">Categoria</th>
                    <th data-priority="3" class="col-sm-1 text-center">Contrato</th>
                    <th data-priority="3" class="col-sm-2 text-center">Jornada</th>
                    <th data-priority="3" class="col-sm-2 text-center">Departamento</th>
                    <th data-priority="3" class="col-sm-1 text-center">Estado</th>
                    <th data-priority="1" class="col-sm-1 text-center">Acciones</th>
                </tr>
                </thead>
                <tbody>
               @php
                   $i=0;
               @endphp
                @foreach ($empleados as $item)
                <tr>
                    @php
                        $i++;
                    @endphp
                    <th class="align-middle " style="width: 10%">{!!$i!!}</th>
                    <td class="align-middle ">{!!$item->nombre.' '.$item->apellido!!}</td>
                    <td class="align-middle ">{!!$item->categoria!!}</td>
                    <td class="align-middle ">{!!$item->contrato!!}</td>
                    <td class="align-middle ">{!!$item->jornada!!}</td>
                    <td class="align-middle ">{!!$item->departamento!!}</td>
                    <td class="align-middle font-16">{!! !$item->estado?'<span class="badge badge-danger">Desactivado</span> ' : '<span class="badge badge-success">Activado</span> ' !!}</td>
                    <td class="align-middle ">
                        <div class="row">
                            <div class="col text-center">
                                <div class="btn-group" role="group">
                                    <button title="Editar" class="btn btn-outline-primary btn-sm rounded" onclick="editar({{$item->id}},this)">
                                        <i class="fa fa-edit font-16" aria-hidden="true"></i>
                                    </button>
                                    <button title="{!! !$item->estado ? 'Activar' : 'Desactivar' !!}" onclick="AltaBaja({{$item->id}})"
                                        class="btn btn-outline-primary btn-sm mx-1 rounded {!! $item->estado?'btn-outline-danger' : 'btn-outline-success' !!}">
                                        {!! !$item->estado ? '<i class="mdi  mdi mdi-arrow-up-bold   font-18"></i>'
                                                            :'<i class="mdi  mdi mdi-arrow-down-bold font-18"></i>'!!}
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

@endsection


@section('plugins')
<style>
    #fileE{
    display: none;
    }
    .contenedor{
        position: relative;
        display: inline-block;
        text-align: center;
    }
    .centrado{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }    

    #categoriaTb>tbody>tr>:nth-child(1){
        width: 10%;
    }
    #categoriaTb>tbody>tr>:nth-child(2){
        width: 90%;
    }
    #categoriaTb>tbody>tr>:nth-child(3){
        width: 10%;
    }
</style>
<link href="{{ asset('template-admin/dist/assets/libs/select2/select2.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('template-admin/dist/assets/libs/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet"/>
@endsection

@section('plugins-js')
<!-- Bootstrap Select -->
<script src="{{ asset('/template-admin/dist/assets/libs/bootstrap-select/bootstrap-select.min.js') }}" ></script>
<script src="{{ asset('template-admin/dist/assets/libs/select2/select2.min.js') }}" ></script>
<!-- Bootstrap Select -->
<script src="{{ asset('js/jquery.mask.js') }}" ></script>
<script src="{{ asset('js/scripts/data-table.js') }}" ></script>
<script src="{{ asset('js/scripts/empleados.js') }}" ></script>
@endsection

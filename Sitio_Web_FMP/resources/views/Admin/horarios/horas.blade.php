@extends('layouts.admin')

@section('content')
<!-- Modal -->
<div class="modal fade" id="horas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id=" exampleModalLongTitle"><i class="mdi mdi-account-clock mdi-24px" aria-hidden="true" ></i> Agregar Horas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="horasForm" action="{{route('horas/create')}}" method="POST">
            <div class="modal-body">
                <input type="hidden" id="_id" name="_id"/>
                    @csrf
                    <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show" 
                        role="alert" style="display:none" id="notificacionCreate">                                               
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group mb-0">
                                <label>Horas</label>
                                <div>
                                    <div class="input-daterange input-group" data-provide="datepicker">
                                        <input type="time" class="form-control" name="hora_inicio" id="hora_inicio"  />
                                        <input type="time" class="form-control" name="hora_final" id="hora_final" />
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>   
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-ban" aria-hidden="true"></i>Cerrar</button>
                <button type="button" class="btn btn-primary" onClick="submitForm('#horasForm','#notificacionCreate')"><li class="fa fa-save"></li>Guardar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
<!-- start page title -->

<!--modal para eliminar-->
<div id="modalAlta" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" 
    aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myCenterModalLabel">
                    <i class="mdi-trash-can mdi mdi-24px" style="margin: 0px;"></i>Eliminar</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ route('estadoHora') }}" method="POST" id="altaBajaForm">
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
                                Advertencia: Se Eliminara por completo el registro, ¿Desea continuar?
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
<!--Modal para Eliminar fin-->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Inicio</a></li>
                    <li class="breadcrumb-item active">Horas de clase</li>
                </ol>
            </div>
            <h4 class="page-title">Creación de Horas</h4>
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
                        Horas Registradas
                    </h3>      
                </div>
                <div class="col-lg-1 order-last">
                    <!-- Button trigger modal -->
                 <button type="button" title="Agregar Horas"
                  class="btn btn-primary dripicons-plus" data-toggle="modal"
                   data-target="#horas"></button>
                </div>
            </div>
            <table  class="table table-bordered" style="width: 100%">
                <thead>
                <tr>
                    <th data-priority="1" style="width: 5%;">N°</th>
                    <th data-priority="3">Hora Incio</th>
                    <th data-priority="3">Hora Fin</th>
                    <th data-priority="1" class="col-sm-1 text-center">Acciones</th>
                  
                </tr>
                </thead>
                <tbody >
                    @php
                        $i=0;
                    @endphp
             @foreach ($horas as $item)
                <tr>       
                    @php
                        $i++;
                    @endphp
                     <td>{!!$i!!}</td>
                     <th>{!!$item->inicio!!}</th>
                     <th>{!!$item->fin!!}</th>
                     <td class="align-middle ">
                        <div class="row">
                            <div class="col text-center">
                                <div class="btn-group" role="group">
                                    <button title="Editar" class="btn btn-outline-primary btn-sm rounded"  onclick="editarHoras({!!$item->id!!})"
                                    data-toggle="modal" data-target="#horas"><i class="fa fa-edit font-16" aria-hidden="true"></i>
                                    </button>
                                    <button title="Eliminar hora" 
                                        class="btn btn-outline-primary btn-sm mx-1 rounded 
                                        btn-outline-danger" 
                                        data-toggle="modal" data-target="#modalAlta" 
                                        onclick="$('#activarId').val({!!$item->id!!});">
                                        <i class="mdi mdi-trash-can font-18"></i>
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
@endsection

@section('plugins-js')
<!-- Dashboard Init JS -->
<script src="{{ asset('js/scripts/http.min.js') }}"></script>
<script src="{{ asset('js/horariosJs/horas.js') }}"></script>
<script>
    function editarHoras(id){
        $json = {!!json_encode($horas)!!}.find(x => x.id==id);
        editar($json);
        }
</script>
<script src="{{ asset('js/scripts/data-table.js') }}" defer></script>
@endsection

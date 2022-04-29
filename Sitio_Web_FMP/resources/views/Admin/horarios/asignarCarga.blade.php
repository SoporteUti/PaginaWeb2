@extends('layouts.admin')

@section('content')
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id=" exampleModalLongTitle"><i class="mdi mdi-briefcase-edit-outline mdi-24px"></i> Asignar Carga Administrativa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="empleadoForm" action="{{route('create/asignacion')}}" method="POST">
            <div class="modal-body">
                <input type="hidden" name="_id" id="_id">
                    @csrf
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
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="exampleInputCarga">Ciclo Activo <code>*</code></label>
                                <select class="form-control selectpicker" style="width: 100%" data-live-search="true" 
                                data-style="btn-white" name="id_ciclo" id="id_ciclo">
                                    <option value="" selected>Seleccione</option>
                                    @foreach ($ciclos as $i)
                                        <option data-icon="mdi mdi mdi-school font-18" value="{!!$i->id!!}">{!!$i->nombre.'-'.$i->año!!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="Departamento">Empleado <code>*</code></label>
                                <select class="form-control selectpicker" style="width: 100%" data-live-search="true" 
                                data-style="btn-white" name="id_empleado" id="id_empleado">
                                    <option value="" selected>Seleccione</option>
                                    @foreach ($empleados as $index)
                                    @php
                                    $b=false;
                                     @endphp
                                        @foreach ($asig as $item)
                                        @if ($item->id==$index->id)
                                            @php
                                            $b=$item->id==$index->id;
                                            @endphp
                                            @break;
                                        @endif
                                        @endforeach
                                        @if($b)
                                        <option data-icon="mdi mdi-account-plus-outline font-18" class="text-danger"  value="{!!$index->id!!}">
                                            <span>
                                            {!!$index->nombre.' '.$index->apellido!!}
                                            </span>
                                        </option>
                                        @else
                                        <option data-icon="mdi mdi-account-plus-outline font-18" value="{!!$index->id!!}">
                                            <span>
                                            {!!$index->nombre.' '.$index->apellido!!}
                                            </span>
                                        </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="exampleInputDocente">Carga Administrativa <code>*</code></label>
                           <select class="form-control selectpicker" style="width: 100%" data-live-search="true" 
                                data-style="btn-white" name="carga" id="carga" aria-placeholder="Seleccione">
                                    <option value="" selected >Seleccione</option>
                                         
                           </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="exampleInputDias">Día <code>*</code></label>
                                <select class="form-control selectpicker" style="width: 100%" data-live-search="true" 
                                data-style="btn-white" name="dias" id="dias" aria-placeholder="Seleccione">
                               
                                    <option value="">Seleccione</option>
                                    <option value="Lunes">Lunes</option>
                                    <option value="Martes">Martes</option>
                                    <option value="Miércoles">Miércoles</option>
                                    <option value="Jueves">Jueves</option>
                                    <option value="Viernes">Viernes</option>
                                    <option value="Todos">Todos los días</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                              <label for="exampleInputCantidad">Proyectos Sociales Asesorando</label>
                              <input type="number" min="1" name="sociales" id="sociales" class="form-control" placeholder="Ingrese la cantidad">
                              </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                              <label for="exampleInputCantidad">Trabajo de Grado Asesorando</label>
                              <input type="number" min="1" name="tg" id="tg" class="form-control" placeholder="Ingrese la cantidad">
                              </div>
                        </div>

                    </div>


                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-ban" aria-hidden="true"></i>  Cerrar</button>
                <button type="button" class="btn btn-primary" onClick="submitForm('#empleadoForm','#notificacion')"><li class="fa fa-save"></li>  Guardar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Inicio</a></li>
                    <li class="breadcrumb-item active">Carga Administrativa</li>
                </ol>
            </div>
            <h4 class="page-title">Asignación de Carga Administrativa</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card-box">
            <div class="row">
                <div class="col-6">
                    <h3>
                    Carga Administrativa Asignada
                    </h3>      
                </div>
                <div class="col-3">
                    <!-- Button trigger modal -->
                 <button type="button" title="Agregar Carga Asignar Administrativa" style="margin-left: 450px;" class="btn btn-primary dripicons-plus" data-toggle="modal" data-target="#exampleModalCenter"></button>
                </div>
            </div>
            <table  class="table table-bordered" style="width: 100%">
                <thead>
                <tr>
                    <th data-priority="1">#</th>
                    <th data-priority="1">Personal</th>
                    <th data-priority="3">Ciclo</th>
                    <th data-priority="3">Carga Administrativa</th>
                    <th data-priority="3">Días</th>
                    <th data-priority="3">Investigación</th>
                    <th data-priority="3">Trabajo de Grado</th>
                    <th data-priority="1">Acciones</th>
                  
                </tr>
                </thead>
                <tbody>
                @php
                    $i=0;
                @endphp
           
               @foreach ($tablaA as $item)
               @php
                   $i++;
               @endphp
                <tr>
                   
                    <td>{!!$i!!}</td>
                    <td>{!!$item->E_nombre!!}{!!' '!!}{!!$item->apellido!!}</td>
                    <td>{!!$item->nombre!!}{!!'-'!!}{!!$item->año!!}</td>
                    <td>{!!$item->nombre_carga!!}</td>
                    <td>{!!$item->dias!!}</td>
                    @if (!is_null($item->sociales))
                    <td>{!!'Proyectos Sociales Asignados: '!!}{!!$item->sociales!!}</td>    
                    @else
                    <td>{!!'Proyectos Sociales Asignados: 0'!!}</td>   
                    @endif

                    @if (!is_null($item->tg))
                    <td>{!!'Trabajo de Grado Asignados: '!!}{!!$item->tg!!}</td>    
                    @else
                    <td>{!!'Trabajo de Grado Asignados: 0'!!}</td>   
                    @endif
                    <td class="align-middle ">
                        <div class="row">
                            <div class="col text-center">
                                <div class="btn-group" role="group">
                                    <button title="Editar Asignación" class="btn btn-outline-primary btn-sm rounded" onclick="editar({{$item->id}},this)">
                                        <i class="fa fa-edit py-1 font-16" aria-hidden="true"></i>
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

@section('plugins')
<link href="{{ asset('template-admin/dist/assets/libs/select2/select2.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('template-admin/dist/assets/libs/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet"/>
@endsection

@section('plugins-js')
<script src="{{ asset('js/scripts/data-table.js') }}" defer></script>
<!-- Bootstrap Select -->
<script src="{{ asset('/template-admin/dist/assets/libs/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('template-admin/dist/assets/libs/select2/select2.min.js') }}"></script>

<script>
    $('#roles').select2();
</script>
<script src="{{ asset('js/scripts/http.min.js') }}"></script>
<script src="{{ asset('js/horariosJs/asignacionCarga.js') }}"></script>
<script src="{{ asset('js/horariosJs/asignacion.js') }}"></script>

@endsection

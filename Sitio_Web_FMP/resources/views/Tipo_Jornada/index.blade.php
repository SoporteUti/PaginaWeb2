@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title"><i class="fa fa-list"></i> Administación de Tipos de Jornadas</h4>
        </div>
    </div>
</div>
<div class="card-box">
    <div class="row">
        <div class="col-9">
            <h3>Tipos de Jornadas Registradas</h3>
        </div>
        <div class="col-3" style="text-align:right">
            <button class="btn btn btn-primary" title="Agregar nuevo registro" data-toggle="modal" data-target="#modalRegistro" id="btnNuevoRegistro"> <i class=" dripicons-plus" aria-hidden="true"></i> </button>
            {{--  <a href="{{ route('admin.tjornada.create')}}" class="btn btn-primary" title="Agregar nuevo registro">
                <i class=" dripicons-plus" aria-hidden="true"></i>
            </a>  --}}
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
    <table  class="table table-sm dt-responsive nowrap" style="width:100%" id="table-tjornada">
        <thead>
        <tr>
            <th>Registro</th>
            <th data-priority="1">Id</th>
            <th data-priority="3">Tipo</th>
            <th data-priority="3">Horas Semanales</th>
            <th data-priority="3">Estado</th>
            <th data-priority="3">Acciones</th>

        </tr>
        </thead>
        <tbody>
        @foreach($tjornada as $item)
        <tr>
            <th  data-sort="{{ strtotime($item->created_at) }}">{{ date('d/m/Y H:m', strtotime($item -> created_at)) }}</th>
            <th>{{ $item->id }}</span></th>
            <td>{{ $item->tipo }}</td>
            <td>{{ $item->horas_semanales }}</td>
            <td>{{ $item->estado }}</td>
            <td>
                <button class="btn btn-outline-primary btn-sm" title="Modificar contenido" data-id="{{ $item->id }}" data-toggle="modal" data-target="#modalRegistro" onclick="btnEdit(this);"><i class="fa fa-edit fa-fw" aria-hidden="true"></i></button>
                <button type="buttom"  class="btn btn-outline-danger btn-sm" onclick="fnEliminar({{$item->id}})" data-toggle="modal" data-target="#modalEliminar"><i class="mdi mdi-delete"></i></button>
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
            <h4 class="modal-title"><i class=" mdi mdi-account-badge-horizontal mdi-24px" aria-hidden="true" ></i> Tipo de Jornada</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form id="registroForm"  action="{{ route('admin.tjornada.store') }}" method="POST">
                <input type="hidden" name="_id" id="_id">
                <div class="modal-body">
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
                        <div class="col-12">
                            <div class="form-group">
                                <label for="tip">Tipo <span class="text-danger">*</span> </label>
                                <input type="text" class="form-control" name="tipo" id="tipo" aria-describedby="tipo" placeholder="Ingrese Tipo Jornada">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                            <label for="horaS">Horas Semanales<span class="text-danger">*</span> </label>
                            <input type="number" class="form-control" name="horas_semanales" id="horas_semanales" min="0" aria-describedby="tipo" placeholder="Ingrese el # de horas por semana">

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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myCenterModalLabel"><i class="mdi mdi-delete mdi-24px"></i> Eliminar</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="frmDelete" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="row py-3">
                        <div class="col-lg-2 fa fa-exclamation-triangle text-warning fa-4x"></div>
                        <div class="col-lg-10 text-black">
                            <h4 class="font-17 text-justify font-weight-bold">Advertencia: Se elimina este registro de manera permanente, ¿Desea continuar?</h4>
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
<script>
    $(document).ready(function () {
        $('#table-tjornada').DataTable({
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
    function btnEdit(element){
        let id = $(element).data('id');
        let data = getData('GET', `{{ url('admin/tjornada') }}/`+id,'#notificacion');
        data.then(function(response){
            $("#registroForm #tipo").val(response.tipo);
            $("#registroForm #horas_semanales").val(response.horas_semanales);
            $("#registroForm #_id").val(response.id);
        });
    }
    function fnEliminar(id){
        $("#frmDelete").attr('action', `{{ url("admin/tjornada/") }}/`+id);
    }
</script>
@endsection

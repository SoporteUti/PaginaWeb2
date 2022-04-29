@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title"><i class="fa fa-list"></i> Notificaciones</h4>
        </div>
    </div>
</div>

<div class="card-box">
    <div class="row">
        <div class="col-12">
            <h3>Notificaciones Registradas</h3>
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
    <table  class="table table-sm" id="table-tcontrato">
        <thead>
            <tr>
                <th>Registro</th>
                <th>Mensaje</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notificaciones as $item)
            <tr>
                <th data-sort="{{ strtotime($item->created_at) }}">{{ $item->created_at->diffForHumans() }}</th>
                <th>{{ $item->mensaje }}</th>
                <td>{{ $item->tipo }}</td>
                <td>
                    @php
                        $estado = ($item->estado) ? 'Sin revisar' : 'Revisado';
                        $estado_color = ($item->estado) ? 'info' : 'success';
                    @endphp
                    <span class="badge badge-{{ $estado_color }}">{{ $estado }}</span>
                </td>
                <td class="text-center">
                    <button type="buttom"  class="btn btn-outline-dark btn-sm" onclick="fnEliminar({{$item->id}})" title="Confirmar de revisado" data-toggle="modal" data-target="#modalEliminar"><i class="mdi mdi-check"></i></button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="modalEliminar" class="modal fade bs-example-modal-center" tabindex="-1"  role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myCenterModalLabel"><i class="mdi mdi-check mdi-24px"></i> Confirmar</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="frmDelete" action="" method="GET">
                    @csrf
                    <div class="row py-3">
                        <div class="col-lg-2 fa fa-exclamation-triangle text-warning fa-4x"></div>
                        <div class="col-lg-10 text-black">
                            <h4 class="font-17 text-justify font-weight-bold">Advertencia: El cambio de este registro es manera permanente, ¿Desea continuar?</h4>
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
    $(document).ready(function () {
        $('#table-tcontrato').DataTable({
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

    function fnEliminar(id){
        $("#frmDelete").attr('action', `{{ url("admin/notificaciones/check") }}/`+id);
    }

</script>
@endsection

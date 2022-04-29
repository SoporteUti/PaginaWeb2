@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Directorios</li>
                </ol>
            </div>
            <h4 class="page-title"> <i class="fa fa-list"></i> Administración de Directorios</h4>
        </div>
    </div>
</div>


<div class="card-box">
    @if(Session::has('flash_message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <div class="alert-message">
                <strong> <i class="fa fa-info-circle"></i> Información!</strong> {{ (Session::get('flash_message')) }}
            </div>
        </div>
    @endif


    <div class="row">
        <div class="col-9">
            <h3>Directorios Registrados</h3>
        </div>
        <div class="col-3" style="text-align:right">
            <a href="{{ route('admin.transparencia.directorios.create') }}" class="btn btn-primary" title="Agregar nuevo registro">
                <i class=" dripicons-plus" aria-hidden="true"></i>
            </a>
        </div>
    </div>

    <br/>
    <br/>
    <table class="table table-sm dt-responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>Contacto</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
    </table>
</div>


<div class="modal fade" id="modalViewPDF" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <i class="fa fa-file-pdf"></i> Visualización de PDF</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="contentPDF">

            </div>
        </div>
    </div>
</div>



@endsection

@section('plugins-js')
<script type="text/javascript">
    $(function () {
        let tabla = $('table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.transparencia.directorios.index') }}",
            columns: [
                {data: 'created_at'},
                {data: 'nombre'},
                {data: 'contacto'},
                {
                    data: 'action',
                    width: '150',
                    orderable: false,
                    searchable: false
                },
            ],
            order: [ [0, 'desc'] ],
            language:{
                url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
            },
        });
    });


</script>
@endsection


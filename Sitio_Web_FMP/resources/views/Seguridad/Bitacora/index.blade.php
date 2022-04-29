@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Bitácora</li>
                </ol>
            </div>
            <h4 class="page-title"> <i class="fa fa-list"></i> Bitácora</h4>
        </div>
    </div>
</div>


<div class="card-box">

    <div class="row">
        <div class="col-9">
            <h3>Acciones Registradas</h3>
        </div>
    </div>

    <br/>
    <br/>
    <table class="table table-sm">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Evento</th>
                <th>Acción</th>
                <th>Modulo</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@section('plugins-js')
<script type="text/javascript">
     $(function () {
        let tabla = $('table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.bitacora') }}",
            columns: [
                {data: 'created_at'},
                {data: 'evento'},
                {data: 'accion'},
                {data: 'modulo'},
            ],
            order: [ [0, 'desc'] ],
            language:{
                url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
            },
        });
    });


</script>
@endsection


@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">{{ $titulo }}</li>
                </ol>
            </div>
            <h4 class="page-title"> <i class="fa fa-list"></i> Administración de {{ $titulo }}</h4>
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
            <h3>{{ $titulo }} Registrados</h3>
        </div>
        <div class="col-3" style="text-align:right">
            <a href="{{ route('admin.transparencia.create', $categoria) }}" class="btn btn-primary" title="Agregar nuevo registro">
                <i class=" dripicons-plus" aria-hidden="true"></i>
            </a>
        </div>
        <!--<div class="col-12 col-sm-4">
            <a href="{{ route('admin.transparencia.create', $categoria) }}" class="btn btn-success" title="Add New Client">
                <i class="fa fa-plus" aria-hidden="true"></i> Agregar nuevo registro
            </a>
        </div>-->
    </div>

    <br/>
    <br/>
    <table class="table table-sm dt-responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Público</th>
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
            ajax: "{{ route('admin.transparencia.index', $categoria) }}",
            columns: [
                {data: 'created_at'},
                {data: 'titulo'},
                {data: 'descripcion'},
                {data: 'publicar'},
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

        //para actualizar el dom y que reconozca el  class de los botones
        tabla.on( 'draw', function () {
            const btns = document.querySelectorAll('.btnViewPDF');
            btns.forEach(el => el.addEventListener('click', event => {

                let id = $(el).data('id')
                let categoria = $(el).data('categoria')
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'GET',
                    url: '{{ url("admin/transparencia") }}/'+categoria+'/file/'+id,
                    // data: formData,
                    dataType: 'JSON',
                    beforeSend: function(){
                        $("#contentPDF").html(`
                            <div class="text-center">
                                <img src="{{ asset("images/loading.gif") }}" class="img-fluid" />
                                <p class="lead">Procesando...</p>
                            </div>
                        `);
                    },
                    success: function (data) {
                        if(data.existe){
                            $("#contentPDF").html(`
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <div class="alert-message">
                                        <strong> <i class="fa fa-info-circle"></i> Información!</strong> Documento cargado con éxito
                                    </div>
                                </div>
                                <object id="PDFdoc" width="100%" height="500px" type="application/pdf" data="${data.path}"></object>
                            `);
                        }else{
                            $("#contentPDF").html(`
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <div class="alert-message">
                                        <strong> <i class="fa fa-info-circle"></i> Error!</strong> No se encontro el archivo
                                    </div>
                                </div>
                                <div id="loader" class="text-center">
                                    <img src="{{ asset("images/not-found.png") }}" class="img-fluid" />
                                </div>
                            `);
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });

            }));

            const frmPublicar = document.querySelectorAll('.frmPublicar');
            frmPublicar.forEach(el => el.addEventListener('change', event => {
                el.submit();
            }));
        });
    });


</script>
@endsection


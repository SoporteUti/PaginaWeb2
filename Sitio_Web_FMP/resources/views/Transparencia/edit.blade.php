@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.transparencia.index', $categoria) }}">{{ $titulo }}</a></li>
                    <li class="breadcrumb-item active">Modificacion</li>
                </ol>
            </div>
            <h4 class="page-title"> <i class="fa fa-list"></i> Administracion de {{ $titulo }}</h4>
        </div>
    </div>
</div>

<div class="card-box">
    <form method="POST" action="{{ route('admin.transparencia.update', [$categoria, $transparencia->id]) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        <div class="card-title">
            <h4 class="page-title"><i class="fa fa-edit"></i> Modificación de Registro #{{ $transparencia->id }}
                <span class="float-right">
                    <table class="table table-sm table-borderless mb-0 pt-0 mt-0 pb-0">
                        <tr>
                            <th>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-block" data-toggle="modal" data-target="#modalViewPDF"> <i class="fa fa-file-pdf"></i> Visualizar PDF</button>
                            </th>
                            <th>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="modificar_doc" name="modificar_doc" value="true"  {{ old('modificar_doc') ? 'checked' :''}}>
                                    <label class="form-check-label font-weight-light" style="font-size: 13px; text-align: center;" for="modificar_doc">Modificar Archivo PDF</label>
                                </div>
                            </td>
                        </tr>
                    </table>
                </span>
            </h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <div class="alert-message">
                        <strong> <i class="fa fa-info-circle"></i> Información!</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @include ('Transparencia.form', ['formMode' => 'edit'])
        </div>
    </form>
</div>

<div class="modal fade" id="modalViewPDF" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> <i class="fa fa-file-pdf"></i> Visualización de PDF</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <object class="PDFdoc" width="100%" height="500px" type="application/pdf" data="{{ asset('storage').'/'.$transparencia->documento }}"></object>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $('#modificar_doc').on('change', function () {
        $('#divPDF').hide('slow');
        if($(this).is(':checked')){
            $('#divPDF').show('slow');
        }
    });
</script>
@endsection

